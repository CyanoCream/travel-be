<?php

namespace App\Http\Controllers;

use App\Exceptions\BusinessLogicException;
use App\Exceptions\InvalidStatusTransitionException;
use App\Helpers\ApiResponse;
use App\Helpers\PaginationHelper;
use App\Jobs\CheckExpiredBooking;
use App\Models\Payment;
use App\Models\TicketBooking;
use App\Models\TravelSchedule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TicketBookingController extends Controller
{
    public function getUserBookings(Request $request)
    {
        try {
            $query = TicketBooking::with(['travelSchedule', 'payment'])
                ->where('user_id', auth()->id());

            $limit = $request->limit !== null ? (int) $request->get("limit") : null;
            $offset = (int) $request->get("offset", 0);
            $total = $query->count();

            $totalPages = PaginationHelper::getTotalPages($total, $limit);
            $currentPage = PaginationHelper::getCurrentPage($offset, $limit, $totalPages);

            $data = collect(PaginationHelper::getData($query->get(), $offset, $limit, $total));


            $mappedData = $data->map(function($booking) {
                return [
                    'id' => optional($booking->travelSchedule)->id,
                    'destination' => optional($booking->travelSchedule)->destination,
                    'departure_date' => optional($booking->travelSchedule)->departure_date,
                    'departure_time' => optional($booking->travelSchedule)->departure_time,
                    'price' => optional($booking->travelSchedule)->ticket_price,
                    'payment_status' => $booking->payment_status
                ];
            });


            $pagination = [
                'total_result' => sizeof($mappedData),
                'total_data' => $total,
                'offset' => $offset,
                'limit' => $limit === null ? $total : $limit,
                'total_pages' => $totalPages,
                'current_page' => $currentPage
            ];

            return ApiResponse::make(true, 'OK', $mappedData, $pagination);
        } catch (Exception $e) {
            return ApiResponse::make(false, $e->getMessage());
        }
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'travel_schedule_id' => 'required|exists:travel_schedule,id',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            // Get schedule
            $schedule = TravelSchedule::findOrFail($request->travel_schedule_id);

            // Validate past travel date
            if (Carbon::parse($schedule->departure_date)->isPast()) {
                throw new BusinessLogicException('Cannot book past travel dates');
            }

            // Check for duplicate booking
            $existingBooking = TicketBooking::where('user_id', auth()->id())
                ->where('travel_schedule_id', $request->travel_schedule_id)
                ->whereIn('payment_status', ['PENDING', 'CONFIRMED'])
                ->first();

            if ($existingBooking) {
                throw new BusinessLogicException('You already have an active booking for this schedule');
            }

            // Check quota availability with proper locking
            $bookedCount = TicketBooking::where('travel_schedule_id', $request->travel_schedule_id)
                ->whereIn('payment_status', ['PENDING', 'CONFIRMED'])
                ->count();

            if ($bookedCount >= $schedule->passenger_quota) {
                throw new BusinessLogicException('No seats available for this schedule');
            }

            $booking = TicketBooking::create([
                'user_id' => auth()->id(),
                'travel_schedule_id' => $request->travel_schedule_id,
                'status' => 'PENDING',
                'booking_code' => 'BK-' . uniqid(),
                'expired_at' => now()->addHours(24) // Booking expires in 24 hours if not paid
            ]);
            $payment = Payment::create([
                'ticket_booking_id' => $booking->id,
                'amount' => $schedule->ticket_price, // Sesuaikan dengan harga tiket
                'payment_status' => 'PENDING', // ✅ Set default payment status
                'payment_code' => 'PAY-' . uniqid()
            ]);

            DB::commit();

            // Dispatch job to check expired bookings
            CheckExpiredBooking::dispatch($booking)->delay(now()->addHours(24));

            return response()->json([
                'status' => true,
                'message' => 'Booking created successfully',
                'data' => $booking
            ], 201);

        } catch (BusinessLogicException $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Failed to create booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateBookingStatus(Request $request, $bookingId)
    {
        DB::beginTransaction();
        try {
            $booking = TicketBooking::findOrFail($bookingId);
            $newStatus = $request->status;

            // Define valid status transitions
            $validTransitions = [
                'PENDING' => ['CONFIRMED'],
                'CONFIRMED' => ['COMPLETED'],
                'COMPLETED' => []
            ];

            if (!isset($validTransitions[$booking->status]) ||
                !in_array($newStatus, $validTransitions[$booking->status])) {
                throw new InvalidStatusTransitionException(
                    "Invalid status transition from {$booking->status} to {$newStatus}"
                );
            }

            $booking->status = $newStatus;
            $booking->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Booking status updated successfully',
                'data' => $booking
            ]);

        } catch (InvalidStatusTransitionException $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Failed to update booking status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function checkStatus($id)
    {
        try {
            $booking = TicketBooking::where('user_id', auth()->id())
                ->findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => [
                    'booking_status' => $booking->status,
                    'payment_status' => optional($booking->payment)->status
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Booking not found'
            ], 404);
        }
    }
    public function getBookingsReport(Request $request)
    {
        try {
            $bookings = TicketBooking::with(['user', 'travelSchedule', 'payment'])
                ->when($request->date_from, function($q) use ($request) {
                    return $q->whereDate('created_at', '>=', $request->date_from);
                })
                ->when($request->date_to, function($q) use ($request) {
                    return $q->whereDate('created_at', '<=', $request->date_to);
                })
                ->when($request->status, function($q) use ($request) {
                    return $q->where('status', $request->status);
                })
                ->get();

            // Prepare CSV data
            $csvData = [
                ['Booking ID', 'Passenger Name', 'Destination', 'Departure Date', 'Departure Time', 'Amount', 'Booking Status', 'Payment Status', 'Created At']
            ];

            foreach ($bookings as $booking) {
                $csvData[] = [
                    $booking->booking_code,
                    $booking->user->name,
                    $booking->travelSchedule->destination,
                    $booking->travelSchedule->departure_date,
                    $booking->travelSchedule->departure_time,
                    optional($booking->payment)->amount ?? 'N/A',
                    $booking->status,
                    optional($booking->payment)->status ?? 'PENDING',
                    $booking->created_at->format('Y-m-d H:i:s')
                ];
            }

            // Create CSV file
            $callback = function() use ($csvData) {
                $file = fopen('php://output', 'w');
                foreach ($csvData as $row) {
                    fputcsv($file, $row);
                }
                fclose($file);
            };

            // Return CSV response
            return response()->streamDownload(function () use ($csvData) {
                $file = fopen('php://output', 'w');
                foreach ($csvData as $row) {
                    fputcsv($file, $row);
                }
                fclose($file);
            }, 'bookings-report.csv');



        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to generate bookings report',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function downloadInvoice($id)
    {
        $booking = TicketBooking::with('payment')->findOrFail($id);

        if ($booking->payment_status !== 'CONFIRMED') {
            return response()->json(['message' => 'Invoice can only be downloaded for CONFIRMED payments'], 403);
        }

        $csvData = [
            ['Invoice ID', 'Destination', 'Price', 'Status', 'Date'],
            [
                $booking->payment->payment_code ?? 'N/A',  // Ambil dari payment_code
                $booking->travelSchedule->destination ?? 'N/A',  // Ambil dari travel schedule
                $booking->payment->amount ?? 'N/A',  // Ambil dari amount
                $booking->payment_status,  // Status tetap
                $booking->payment->created_at ?? 'N/A',  // Ambil dari payment created_at
            ]
        ];

        $filename = "invoice_{$booking->id}.csv";

        $handle = fopen('php://temp', 'w');
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        return response($csvContent, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename={$filename}");
    }

}

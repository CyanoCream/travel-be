<?php

namespace App\Http\Controllers;

use App\Exceptions\BusinessLogicException;
use App\Exceptions\InvalidStatusTransitionException;
use App\Models\Payment;
use App\Models\TicketBooking;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    public function store(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $booking = TicketBooking::where('travel_schedule_id',$id)->first();
            if (!$booking) {
                return response()->json(['status' => false, 'message' => 'Booking not found'], 404);
            }

            $payment = Payment::create([
                'ticket_booking_id' => $booking->id,
                'amount' => $request->amount,
                'payment_proof' => $request->payment_proof,
                'payment_status' => 'PAID',
                'payment_code' => 'PAY-' . uniqid()
            ]);


            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Payment submitted successfully',
                'data' => $payment
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
                'message' => 'Failed to submit payment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updatePaymentStatus(Request $request, $paymentId)
    {
        DB::beginTransaction();
        try {
            $payment = Payment::with('booking')->findOrFail($paymentId);
            $newStatus = $request->status;

            // Define valid status transitions
            $validTransitions = [
                'PENDING' => ['VERIFIED'],
                'VERIFIED' => ['COMPLETED'],
                'COMPLETED' => []
            ];

            if (!isset($validTransitions[$payment->status]) ||
                !in_array($newStatus, $validTransitions[$payment->status])) {
                throw new InvalidStatusTransitionException(
                    "Invalid status transition from {$payment->status} to {$newStatus}"
                );
            }

            $payment->status = $newStatus;
            $payment->save();

            // If payment is completed, update booking status
            if ($newStatus === 'COMPLETED') {
                $payment->booking->status = 'COMPLETED';
                $payment->booking->save();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Payment status updated successfully',
                'data' => $payment
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
                'message' => 'Failed to update payment status',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function generateInvoice($bookingId)
    {
        try {
            $booking = TicketBooking::with(['user', 'travelSchedule', 'payment'])
                ->findOrFail($bookingId);

            // Here you would typically generate a PDF invoice
            // For this example, we'll just return the data
            $invoiceData = [
                'invoice_number' => 'INV-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
                'passenger_name' => $booking->user->name,
                'destination' => $booking->travelSchedule->destination,
                'departure_date' => $booking->travelSchedule->departure_date,
                'departure_time' => $booking->travelSchedule->departure_time,
                'amount_paid' => $booking->payment->amount,
                'payment_status' => $booking->payment->status,
                'payment_date' => $booking->payment->created_at
            ];

            return response()->json([
                'status' => true,
                'data' => $invoiceData
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to generate invoice',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getPaymentsReport(Request $request)
    {
        try {
            $query = Payment::with(['booking.travelSchedule', 'booking.user'])
                ->when($request->date_from, function($q) use ($request) {
                    return $q->whereDate('created_at', '>=', $request->date_from);
                })
                ->when($request->date_to, function($q) use ($request) {
                    return $q->whereDate('created_at', '<=', $request->date_to);
                })
                ->when($request->status, function($q) use ($request) {
                    return $q->where('status', $request->status);
                });

            $payments = $query->get()->map(function($payment) {
                return [
                    'travel_schedule' => $payment->booking->travelSchedule->destination,
                    'departure_date' => $payment->booking->travelSchedule->departure_date,
                    'passenger_name' => $payment->booking->user->name,
                    'amount' => $payment->amount,
                    'status' => $payment->status,
                    'payment_date' => $payment->created_at,
                    'payment_proof' => $payment->payment_proof
                ];
            });

            // Calculate summary statistics
            $summary = [
                'total_payments' => $payments->count(),
                'total_amount' => $payments->sum('amount'),
                'completed_payments' => $payments->where('status', 'COMPLETED')->count(),
                'pending_payments' => $payments->where('status', 'PENDING')->count(),
                'daily_totals' => $payments->groupBy(function($payment) {
                    return $payment['payment_date']->format('Y-m-d');
                })->map(function($group) {
                    return [
                        'count' => $group->count(),
                        'amount' => $group->sum('amount')
                    ];
                })
            ];

            return ApiResponse::make(true, 'OK', [
                'detailed_payments' => $payments,
                'summary' => $summary
            ]);
        } catch (Exception $e) {
            return ApiResponse::make(false, $e->getMessage());
        }
    }
    public function checkStatus($id)
    {
        try {
            $payment = Payment::whereHas('booking', function($q) {
                $q->where('user_id', auth()->id());
            })->findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => [
                    'payment_status' => $payment->status,
                    'amount' => $payment->amount,
                    'created_at' => $payment->created_at
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Payment not found'
            ], 404);
        }
    }
}

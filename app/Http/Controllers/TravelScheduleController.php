<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Helpers\PaginationHelper;
use App\Models\Payment;
use App\Models\TicketBooking;
use App\Models\TravelSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Mockery\Exception;

class TravelScheduleController extends Controller
{
    public function index(Request $request){
        try {
            $model = TravelSchedule::with(['bookings'])->get();
            $limit = $request->limit !== null ? (int) $request->get("limit") : null;
            $offset = (int) $request->get("offset", 0);
            $total = $model->count();
            $totalPages = PaginationHelper::getTotalPages($total, $limit);
            $currentPage = PaginationHelper::getCurrentPage($offset, $limit, $totalPages);
            $data = PaginationHelper::getData($model, $offset, $limit, $total);
            $pagination = [
                'total_result' => sizeof($data),
                'total_data' => $total,
                'offset' => $offset,
                'limit' => $limit === null ? $total : $limit,
                'total_pages' => $totalPages,
                'current_page' => $currentPage
            ];
            return ApiResponse::make(true, 'OK', $data, $pagination);
        } catch (Exception $e){
            return ApiResponse::make(false, $e->getMessage());
        }
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'destination' => 'required|string',
                'departure_date' => 'required|date',
                'departure_time' => 'required',
                'passenger_quota' => 'required|integer|min:1',
                'ticket_price' => 'required|numeric|min:0'
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $schedule = TravelSchedule::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Schedule created successfully',
                'data' => $schedule
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create schedule',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getPassengerReport(Request $request, $scheduleId)
    {
        try {
            // Pastikan kita mengambil data dalam bentuk Collection, bukan Query Builder
            $query = TicketBooking::with(['user'])
                ->where('travel_schedule_id', $scheduleId);

            $limit = $request->limit !== null ? (int) $request->get("limit") : null;
            $offset = (int) $request->get("offset", 0);
            $total = $query->count();

            // Ambil data dalam bentuk Collection terlebih dahulu
            $collection = $query->get(); // Pastikan sudah Collection sebelum dikirim ke helper

            $totalPages = PaginationHelper::getTotalPages($total, $limit);
            $currentPage = PaginationHelper::getCurrentPage($offset, $limit, $totalPages);
            $data = PaginationHelper::getData($collection, $offset, $limit, $total); // Kirim Collection, bukan Query Builder

            $pagination = [
                'total_result' => sizeof($data),
                'total_data' => $total,
                'offset' => $offset,
                'limit' => $limit === null ? $total : $limit,
                'total_pages' => $totalPages,
                'current_page' => $currentPage
            ];

            return ApiResponse::make(true, 'OK', $data, $pagination);
        } catch (Exception $e) {
            return ApiResponse::make(false, $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'destination' => 'sometimes|string',
                'departure_date' => 'sometimes|date',
                'departure_time' => 'sometimes',
                'passenger_quota' => 'sometimes|integer|min:1',
                'ticket_price' => 'sometimes|numeric|min:0'
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $schedule = TravelSchedule::findOrFail($id);
            $schedule->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Schedule updated successfully',
                'data' => $schedule
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update schedule',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function destroy($id)
    {
        try {
            $schedule = TravelSchedule::findOrFail($id);
            $schedule->delete();

            return response()->json([
                'status' => true,
                'message' => 'Schedule deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete schedule',
                'error' => $e->getMessage()
            ], 500);
        }
    }

// Admin Reports
    public function getStatistics(Request $request)
    {
        return response()->json([
            'user' => $request->user(), // Cek user yang sedang login
            'role' => $request->user()?->role, // Cek role user
        ]);
        try {
            $statistics = [
                'total_schedules' => TravelSchedule::count(),
                'total_bookings' => TicketBooking::count(),
                'revenue' => Payment::where('status', 'COMPLETED')->sum('amount'),
                'popular_destinations' => TravelSchedule::select('destination')
                    ->withCount('bookings')
                    ->orderBy('bookings_count', 'desc')
                    ->take(5)
                    ->get()
            ];

            return response()->json([
                'status' => true,
                'data' => $statistics
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

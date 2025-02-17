<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\TicketBooking;
use App\Models\TravelSchedule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        try {
            $recentBookings = TicketBooking::with(['user', 'travelSchedule'])
                ->latest()
                ->take(10)
                ->get()
                ->map(function ($booking) {
                    return [
                        'id' => $booking->id,
                        'passenger_name' => $booking->user->name,
                        'schedule' => [
                            'destination' => $booking->travelSchedule->destination,
                            'departure_date' => $booking->travelSchedule->departure_date,
                            'departure_time' => $booking->travelSchedule->departure_time
                        ],
                        'status' => $booking->status
                    ];
                });

            $data = [
                'totalSchedules' => TravelSchedule::count(),
                'totalBookings' => TicketBooking::count(),
                'totalRevenue' => Payment::where('payment_status', 'COMPLETED')->sum('amount'),
                'recentBookings' => $recentBookings
            ];

            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch dashboard data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function passengerDashboard()
    {
        try {
            $userId = auth()->id();

            $nextTrip = TicketBooking::with('travelSchedule')
                ->where('user_id', $userId)
                ->whereIn('payment_status', ['CONFIRMED', 'PENDING'])
                ->whereHas('travelSchedule', function ($query) {
                    $query->where('departure_date', '>=', now());
                })
                ->orderBy('created_at', 'desc')
                ->first();

            $data = [
                'nextTrip' => $nextTrip ? [
                    'id' => $nextTrip->id,
                    'schedule' => [
                        'destination' => $nextTrip->travelSchedule->destination,
                        'departure_date' => $nextTrip->travelSchedule->departure_date,
                        'departure_time' => $nextTrip->travelSchedule->departure_time
                    ]
                ] : null,
                'totalBookings' => TicketBooking::where('user_id', $userId)->count(),
                'upcomingTrips' => TicketBooking::where('user_id', $userId)
                    ->whereIn('payment_status', ['CONFIRMED', 'PENDING'])
                    ->whereHas('travelSchedule', function ($query) {
                        $query->where('departure_date', '>=', now());
                    })
                    ->count(),
                'totalSpent' => Payment::whereHas('ticketBooking', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                    ->where('payment_status', 'COMPLETED')
                    ->sum('amount')

            ];

            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch dashboard data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}


<?php
// routes/api.php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TicketBookingController;
use App\Http\Controllers\TravelScheduleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::prefix('v1')->group(function () {
    // Auth routes
    Route::post('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');



    // Public travel schedules
    Route::get('travel-schedules', [TravelScheduleController::class, 'index']);
});

// Protected routes (requires authentication)
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    // Auth
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);

    // Passenger routes
    Route::middleware(['role:PASSENGER'])->prefix('passenger')->group(function () {

        Route::get('dashboard', [DashboardController::class, 'passengerDashboard']);
        // Booking Management
        Route::prefix('bookings')->group(function () {
            Route::get('/', [TicketBookingController::class, 'getUserBookings']);
            Route::post('/', [TicketBookingController::class, 'store']);
            Route::get('/{id}/status', [TicketBookingController::class, 'checkStatus']);
            Route::get('/{id}/invoice', [TicketBookingController::class, 'downloadInvoice']);


        });

        // Payment Management
        Route::prefix('payments')->group(function () {
            Route::post('/{id}/pay', [PaymentController::class, 'store']);
            Route::post('/', [PaymentController::class, 'store']);
            Route::get('invoice/{bookingId}', [PaymentController::class, 'generateInvoice']);
            Route::get('/{id}/status', [PaymentController::class, 'checkStatus']);
        });


    });

    // Admin routes
    Route::middleware(['auth:sanctum', 'role:ADMIN'])->prefix('admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'adminDashboard']);
        // Travel Schedule Management
        Route::prefix('travel-schedules')->group(function () {
            Route::post('/', [TravelScheduleController::class, 'store']);
            Route::put('/{id}', [TravelScheduleController::class, 'update']);
            Route::delete('/{id}', [TravelScheduleController::class, 'destroy']);
            Route::get('/{id}/passenger-report', [TravelScheduleController::class, 'getPassengerReport']);
        });

        // Admin Reports & Statistics
        Route::get('statistics', [TravelScheduleController::class, 'getStatistics']);
        Route::get('bookings/report', [TicketBookingController::class, 'getBookingsReport']);
        Route::get('payments/report', [PaymentController::class, 'getPaymentsReport']);
        Route::put('bookings/{id}/status', [TicketBookingController::class, 'updateBookingStatus']);
        Route::put('payments/{id}/status', [PaymentController::class, 'updatePaymentStatus']);
    });
});

<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('user-management')->group(function () {
    Route::prefix('users')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);

        // Route yang membutuhkan autentikasi JWT
        Route::middleware('auth:api')->group(function () {
            // protected routes here
        });
    });
});


Route::get('/products', [ProductController::class, 'getAllProduct']);
Route::get('/products/{slug}', [ProductController::class, 'getProductBySlug']);

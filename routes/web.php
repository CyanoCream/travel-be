<?php

use App\Http\Controllers\Merchant\MerchantController;
use App\Http\Controllers\Merchant\MerchantPaymentController;
use App\Http\Controllers\Monitoring\CartItemController;
use App\Http\Controllers\Monitoring\SalesReportController;
use App\Http\Controllers\Monitoring\ShipmentController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Product\ProductCategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\Provincecontroller;
use App\Http\Controllers\CityController;
use App\Http\Controllers\SubdistrictController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
//Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
//
//Auth::routes();

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
//
//Route::middleware('auth')->group(callback: function () {
//    Route::view('about', 'about')->name('about');
//
//    Route::middleware(['check.role:ADMIN'])->group(function () {
////    Master User
//
//    });
//
//});
//
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//


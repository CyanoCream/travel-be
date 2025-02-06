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
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(callback: function () {
    Route::view('about', 'about')->name('about');

// routes/web.php
//    Master User
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('user-roles', UserRoleController::class);

//    Master City
    Route::resource('provinces', ProvinceController::class);
    Route::resource('cities', CityController::class);
    Route::resource('subdistricts', SubdistrictController::class);

//    product
    Route::resource('products', ProductController::class);
    Route::resource('product-category', ProductCategoryController::class);

//    merchant
    Route::resource('merchants', MerchantController::class);

//    Monitoring
    Route::resource('cart-items', CartItemController::class);
    Route::get('cart-total', [CartItemController::class, 'getCartTotal']);

//    Merchant-payments
    Route::resource('merchant-payments', MerchantPaymentController::class);

//    Shipments
    Route::resource('shipments', ShipmentController::class);
//    Sales Report
    Route::resource('sales-reports', SalesReportController::class);

//    Payment
    Route::resource('payments', PaymentController::class);

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



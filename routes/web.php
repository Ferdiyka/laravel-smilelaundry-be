<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return view('pages.auth.login');
});

Route::middleware([
    'auth',
])->group(function () {
    Route::get('home', function () {
        return view('pages.dashboard');
    })->name('home');
    Route::middleware([
        'is_admin',
    ])->group(function () {
    Route::resource('user', UserController::class);
    Route::resource('product', ProductController::class);
    Route::resource('order', OrderController::class);
    Route::put('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
    Route::put('/orders/{order}/update-payment-status', [OrderController::class, 'updatePaymentStatus'])->name('order.updatePaymentStatus');
    Route::get('/orders/export', [OrderController::class, 'exportOrders'])->name('orders.export');
    });
});

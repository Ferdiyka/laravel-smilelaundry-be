<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;


Route::get('/', function () {
    return view('pages.auth.login');
});

Route::middleware([
    'auth',
])->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::middleware([
        'is_admin',
    ])->group(function () {
    Route::resource('user', UserController::class);
    Route::resource('product', ProductController::class);
    Route::resource('order', OrderController::class);
    Route::get('/orders/detail', [OrderController::class, 'detail'])->name('order.detail');
    Route::put('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
    Route::put('/orders/{order}/update-payment-status', [OrderController::class, 'updatePaymentStatus'])->name('order.updatePaymentStatus');
    Route::get('/orders/export', [OrderController::class, 'exportOrders'])->name('orders.export');
    Route::get('/orders/{order}/download-pdf', [OrderController::class, 'downloadOrderPDF'])->name('order.downloadPDF');
    });
});

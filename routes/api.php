<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;

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

// register
Route::post('/register', [AuthController::class, 'register']);
//logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
//login
Route::post('/login', [AuthController::class, 'login']);
//product
Route::get('/products', [ProductController::class, 'index']);
//user
Route::apiResource('/users', UserController::class)->middleware('auth:sanctum');
//user update
Route::post('/users/update', [UserController::class, 'updateAddress'])->middleware('auth:sanctum');
//order
Route::post('/order', [OrderController::class, 'order'])->middleware('auth:sanctum');
//udpate fcm id
Route::post('/update-fcm', [AuthController::class, 'updateFcmId'])->middleware('auth:sanctum');
//get order by user
Route::get('/orders', [OrderController::class, 'getOrderByUser'])->middleware('auth:sanctum');

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\DriverApiController;
use App\Http\Controllers\Api\AdminOrderApiController;
use App\Http\Controllers\Api\CustomerApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/driver/login', [DriverApiController::class, 'login']);
Route::post('/driver/set-online', [DriverApiController::class, 'setOnline']);
Route::post('/driver/logout', [DriverApiController::class, 'logout']);
Route::get('/driver/orders', [DriverApiController::class, 'getOrders']);
Route::get('/driver/order/active', [DriverApiController::class, 'getActiveOrder']);
Route::get('/driver/profile', [DriverApiController::class, 'getProfile']);
Route::post('/driver/order/status', [DriverApiController::class, 'updateOrderStatus']);
Route::post('/driver/order/charge-qris', [DriverApiController::class, 'chargeQris']);
Route::post('/driver/order/check-payment', [DriverApiController::class, 'checkPayment']);
Route::post('/driver/order/simulate-payment', [DriverApiController::class, 'simulatePayment']);
Route::post('/driver/withdraw', [DriverApiController::class, 'withdraw']);
Route::post('/admin/create-order', [AdminOrderApiController::class, 'createOrder']);
Route::get('/admin/drivers', [AdminOrderApiController::class, 'getDrivers']);
Route::post('/admin/driver/detach', [AdminOrderApiController::class, 'detachDriver']);

Route::post('/customer/create-order', [CustomerApiController::class, 'createOrder']);
Route::post('/customer/estimate-fares', [CustomerApiController::class, 'estimateFares']);
Route::post('/orders/{id}/rate', [CustomerApiController::class, 'rateOrder']);

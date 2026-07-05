<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\DriverApiController;
use App\Http\Controllers\Api\AdminOrderApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/driver/login', [DriverApiController::class, 'login']);
Route::post('/driver/logout', [DriverApiController::class, 'logout']);
Route::post('/driver/order/status', [DriverApiController::class, 'updateOrderStatus']);
Route::post('/admin/create-order', [AdminOrderApiController::class, 'createOrder']);
Route::get('/admin/drivers', [AdminOrderApiController::class, 'getDrivers']);
Route::post('/admin/driver/detach', [AdminOrderApiController::class, 'detachDriver']);

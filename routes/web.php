<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDriverController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminAccountController;
use App\Http\Controllers\AdminPerformanceController;
use App\Http\Controllers\AdminFinanceController;
use App\Http\Controllers\AdminServiceController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::get('/admin/accounts', [AdminAccountController::class, 'index'])->name('admin.accounts.index');
    Route::get('/admin/performance', [AdminPerformanceController::class, 'index'])->name('admin.performance.index');
    Route::get('/admin/finance', [AdminFinanceController::class, 'index'])->name('admin.finance.index');
    Route::get('/admin/services', [AdminServiceController::class, 'index'])->name('admin.services.index');
    Route::post('/admin/services', [AdminServiceController::class, 'store'])->name('admin.services.store');
    Route::put('/admin/services/{service}', [AdminServiceController::class, 'update'])->name('admin.services.update');
    Route::delete('/admin/services/{service}', [AdminServiceController::class, 'destroy'])->name('admin.services.destroy');
    
    // Profile Edit
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Admin WiroJek Actions
    Route::post('/admin/drivers', [AdminDriverController::class, 'store'])->name('admin.drivers.store');
    Route::put('/admin/drivers/{driver}', [AdminDriverController::class, 'update'])->name('admin.drivers.update');
    Route::delete('/admin/drivers/{driver}', [AdminDriverController::class, 'destroy'])->name('admin.drivers.destroy');
    Route::post('/admin/settings', [AdminDriverController::class, 'saveSettings'])->name('admin.settings.save');
});

require __DIR__.'/auth.php';

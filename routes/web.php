<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Models\Driver;
use App\Models\Order;

use App\Http\Controllers\AdminDriverController;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    $drivers = Driver::latest()->get();
    $orders = Order::with('driver')->latest()->take(15)->get();
    $settings = DB::table('admin_settings')->pluck('value', 'key')->toArray();
    return view('dashboard', compact('drivers', 'orders', 'settings'));
})->name('dashboard');

Route::get('/dashboard', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Admin WiroJek Actions
    Route::post('/admin/drivers', [AdminDriverController::class, 'store'])->name('admin.drivers.store');
    Route::put('/admin/drivers/{driver}', [AdminDriverController::class, 'update'])->name('admin.drivers.update');
    Route::delete('/admin/drivers/{driver}', [AdminDriverController::class, 'destroy'])->name('admin.drivers.destroy');
    Route::post('/admin/settings', [AdminDriverController::class, 'saveSettings'])->name('admin.settings.save');
    Route::get('/admin/orders/{order}', [AdminDriverController::class, 'showOrder'])->name('admin.orders.show');
});

require __DIR__.'/auth.php';

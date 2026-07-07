<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class AdminPerformanceController extends Controller
{
    public function index()
    {
        // Fetch drivers ranked by completed orders count
        $drivers = Driver::withCount(['orders' => function ($query) {
            $query->where('status', 'completed');
        }])
        ->withAvg('orders', 'rating_driver')
        ->orderByDesc('orders_count')
        ->get();

        return view('admin.performance', compact('drivers'));
    }
}

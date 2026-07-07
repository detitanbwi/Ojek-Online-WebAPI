<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class AdminPerformanceController extends Controller
{
    public function index(Request $request)
    {
        // Default to start of month to end of month
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        // Fetch drivers ranked by completed orders count in the date range
        $drivers = Driver::withCount(['orders' => function ($query) use ($startDate, $endDate) {
            $query->where('status', 'completed')
                  ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }])
        ->withAvg(['orders' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }], 'rating_driver')
        ->orderByDesc('orders_count')
        ->get();

        return view('admin.performance', compact('drivers', 'startDate', 'endDate'));
    }
}

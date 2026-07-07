<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        // Default to start of month to end of month
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        $drivers = Driver::latest()->get();
        
        $orders = Order::with('driver')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->latest()
            ->get();
            
        $settings = DB::table('admin_settings')->pluck('value', 'key')->toArray();

        return view('admin.orders', compact('drivers', 'orders', 'settings', 'startDate', 'endDate'));
    }

    public function show(Order $order)
    {
        return response()->json([
            'success' => true,
            'data' => $order->load('driver')
        ]);
    }
}

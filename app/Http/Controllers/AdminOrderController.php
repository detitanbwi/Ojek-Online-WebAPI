<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    public function index()
    {
        $drivers = Driver::latest()->get();
        $orders = Order::with('driver')->latest()->take(15)->get();
        $settings = DB::table('admin_settings')->pluck('value', 'key')->toArray();

        return view('admin.orders', compact('drivers', 'orders', 'settings'));
    }

    public function show(Order $order)
    {
        return response()->json([
            'success' => true,
            'data' => $order->load('driver')
        ]);
    }
}

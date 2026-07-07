<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalDrivers = Driver::count();
        $totalCustomers = User::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('admin_fee');

        // Let's pass this to view
        return view('admin.dashboard', compact('totalDrivers', 'totalCustomers', 'totalOrders', 'totalRevenue'));
    }
}

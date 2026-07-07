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

        $commissionType = DB::table('admin_settings')->where('key', 'commission_type')->value('value') ?? 'percentage';
        $commissionValue = floatval(DB::table('admin_settings')->where('key', 'commission_value')->value('value') ?? 10);

        // Let's pass this to view
        return view('admin.dashboard', compact('totalDrivers', 'totalCustomers', 'totalOrders', 'totalRevenue', 'commissionType', 'commissionValue'));
    }
}

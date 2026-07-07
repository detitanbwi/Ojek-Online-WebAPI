<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminFinanceController extends Controller
{
    public function index()
    {
        $adminBalance = Order::where('status', 'completed')->sum('admin_fee');
        $transactions = Transaction::with(['order', 'driver'])->latest()->get();

        return view('admin.finance', compact('adminBalance', 'transactions'));
    }
}

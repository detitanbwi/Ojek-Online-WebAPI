<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminFinanceController extends Controller
{
    public function index(Request $request)
    {
        // Default to start of month to end of month
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        $commissionInSum = Transaction::where('type', 'commission_in')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('amount');
            
        $withdrawalOutSum = Transaction::where('type', 'withdrawal_out')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('amount');
            
        $adminBalance = $commissionInSum - $withdrawalOutSum;
        
        $transactions = Transaction::with(['order', 'driver'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->latest()
            ->get();

        return view('admin.finance', compact('adminBalance', 'transactions', 'startDate', 'endDate'));
    }
}

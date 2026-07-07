<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;

class AdminAccountController extends Controller
{
    public function index()
    {
        $drivers = Driver::latest()->get();
        $customers = User::latest()->get();

        return view('admin.accounts', compact('drivers', 'customers'));
    }
}

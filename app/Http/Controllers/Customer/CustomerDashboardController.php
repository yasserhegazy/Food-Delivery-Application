<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerDashboardController extends Controller
{
    /**
     * Display customer dashboard.
     */
    public function index()
    {
        return view('customer.dashboard');
    }
}

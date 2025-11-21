<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DriverDashboardController extends Controller
{
    /**
     * Display driver dashboard.
     */
    public function index()
    {
        return view('driver.dashboard');
    }
}

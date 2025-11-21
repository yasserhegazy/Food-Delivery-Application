<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RestaurantDashboardController extends Controller
{
    /**
     * Display restaurant dashboard.
     */
    public function index()
    {
        return view('restaurant.dashboard');
    }
}

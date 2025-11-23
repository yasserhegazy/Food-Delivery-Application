<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class CustomerDashboardController extends Controller
{
    /**
     * Display customer dashboard.
     */
    public function index()
    {
        // Get featured restaurants (high rated, active)
        $featuredRestaurants = Restaurant::active()
            ->where('rating', '>=', 4.0)
            ->with('categories')
            ->orderBy('rating', 'desc')
            ->take(6)
            ->get();

        // Get recently added restaurants
        $recentRestaurants = Restaurant::active()
            ->with('categories')
            ->latest()
            ->take(6)
            ->get();

        return view('customer.dashboard', compact('featuredRestaurants', 'recentRestaurants'));
    }
}

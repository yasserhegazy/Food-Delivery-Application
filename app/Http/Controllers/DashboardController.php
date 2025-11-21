<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Redirect to role-specific dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        return match ($user->role) {
            'customer' => redirect()->route('customer.dashboard'),
            'restaurant_owner' => redirect()->route('restaurant.dashboard'),
            'driver' => redirect()->route('driver.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            default => abort(403, 'Invalid user role'),
        };
    }
}

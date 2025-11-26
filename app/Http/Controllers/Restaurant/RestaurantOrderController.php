<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class RestaurantOrderController extends Controller
{
    public function index(Request $request)
    {
        $restaurant = Auth::user()->restaurant;
        if (!$restaurant) {
            abort(403, 'You do not have a restaurant.');
        }

        $status = $request->query('status', 'pending');
        
        $orders = Order::where('restaurant_id', $restaurant->id)
            ->when($status === 'active', function ($query) {
                return $query->whereIn('status', ['confirmed', 'preparing', 'ready_for_pickup']);
            })
            ->when($status === 'past', function ($query) {
                return $query->whereIn('status', ['delivered', 'cancelled']);
            })
            ->when($status === 'pending', function ($query) {
                return $query->where('status', 'pending');
            })
            ->with(['user', 'items'])
            ->latest()
            ->paginate(10);

        return view('restaurant.orders.index', compact('orders', 'status'));
    }

    public function show(Order $order)
    {
        $restaurant = Auth::user()->restaurant;
        if ($order->restaurant_id !== $restaurant->id) {
            abort(403);
        }

        $order->load(['user', 'items.menuItem', 'address']);

        return view('restaurant.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $restaurant = Auth::user()->restaurant;
        if ($order->restaurant_id !== $restaurant->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:confirmed,preparing,ready_for_pickup,on_way,delivered,cancelled',
        ]);

        // Add logic to validate status transitions if needed (e.g., can't go from delivered to pending)
        
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated successfully.');
    }
}

<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderStatusHistory;
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
            ->with(['user', 'items.menuItem', 'address', 'driver'])
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
        $this->authorize('update', $order);

        $request->validate([
            'status' => 'required|in:confirmed,preparing,ready_for_pickup,on_way,delivered,cancelled',
        ]);

        // Add logic to validate status transitions if needed (e.g., can't go from delivered to pending)
        
        $order->update(['status' => $request->status]);

        OrderStatusHistory::create([
            'order_id' => $order->id,
            'status' => $request->status,
            'changed_by' => Auth::id(),
        ]);

        // Notify customer about status change
        $order->user->notify(new \App\Notifications\OrderStatusChanged($order, $request->status));

        // If order is ready for pickup, notify all drivers
        if ($request->status === 'ready_for_pickup') {
            $drivers = \App\Models\User::where('role', 'driver')->where('is_active', true)->get();
            \Illuminate\Support\Facades\Notification::send($drivers, new \App\Notifications\NewDeliveryAvailable($order));
        }

        return back()->with('success', 'Order status updated successfully.');
    }
}

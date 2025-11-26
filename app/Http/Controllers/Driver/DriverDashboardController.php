<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DriverDashboardController extends Controller
{
    /**
     * Redirect to available deliveries (default dashboard).
     */
    public function index()
    {
        return redirect()->route('driver.deliveries.available');
    }

    /**
     * Display available deliveries (ready for pickup).
     */
    public function availableDeliveries()
    {
        $orders = Order::where('status', 'ready_for_pickup')
            ->whereNull('driver_id')
            ->with(['restaurant', 'address', 'items'])
            ->latest()
            ->paginate(10);

        return view('driver.deliveries.available', compact('orders'));
    }

    /**
     * Display driver's assigned deliveries.
     */
    public function myDeliveries(Request $request)
    {
        $status = $request->query('status', 'active');
        
        $orders = Order::where('driver_id', Auth::id())
            ->when($status === 'active', function ($query) {
                return $query->where('status', 'on_way');
            })
            ->when($status === 'completed', function ($query) {
                return $query->where('status', 'delivered');
            })
            ->with(['restaurant', 'address', 'user', 'items'])
            ->latest()
            ->paginate(10);

        return view('driver.deliveries.my-deliveries', compact('orders', 'status'));
    }

    /**
     * Accept a delivery assignment.
     */
    public function acceptDelivery(Order $order)
    {
        if ($order->status !== 'ready_for_pickup' || $order->driver_id !== null) {
            return back()->with('error', 'This delivery is no longer available.');
        }

        $order->update([
            'driver_id' => Auth::id(),
            'status' => 'on_way',
        ]);

        return redirect()->route('driver.deliveries.my')->with('success', 'Delivery accepted! You can now proceed to deliver.');
    }

    /**
     * Update delivery status.
     */
    public function updateDeliveryStatus(Request $request, Order $order)
    {
        if ($order->driver_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'status' => 'required|in:delivered',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Delivery status updated successfully.');
    }

    /**
     * Show delivery details.
     */
    public function show(Order $order)
    {
        if ($order->driver_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $order->load(['restaurant', 'address', 'user', 'items.menuItem']);

        return view('driver.deliveries.show', compact('order'));
    }
}

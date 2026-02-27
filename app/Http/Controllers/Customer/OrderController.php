<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['restaurant', 'items.menuItem', 'address', 'driver'])
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->load(['restaurant', 'items.menuItem', 'address', 'statusHistory.changedBy']);

        return view('customer.orders.show', compact('order'));
    }
}

<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\CartService;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartItems = $this->cartService->getCart();
        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.cart.index')->with('error', 'Your cart is empty.');
        }

        $cartTotal = $this->cartService->getCartTotal();
        $addresses = auth()->user()->addresses;

        return view('customer.checkout.index', compact('cartItems', 'cartTotal', 'addresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'special_instructions' => 'nullable|string|max:1000',
        ]);

        $cartItems = $this->cartService->getCart();
        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.cart.index')->with('error', 'Your cart is empty.');
        }

        $address = \App\Models\Address::where('id', $request->address_id)->where('user_id', auth()->id())->firstOrFail();

        // Get restaurant from first item (cart is grouped by restaurant)
        $firstRestaurantItems = $cartItems->first();
        $firstItem = $firstRestaurantItems->first();
        $restaurantId = $firstItem->menuItem->category->restaurant_id;

        try {
            DB::beginTransaction();

            $order = \App\Models\Order::create([
                'user_id' => auth()->id(),
                'restaurant_id' => $restaurantId,
                'delivery_address_id' => $address->id,
                'total_amount' => $this->cartService->getCartTotal(),
                'status' => 'pending',
                'special_instructions' => $request->special_instructions,
            ]);

            // Create order items from all cart items (flatten the grouped collection)
            foreach ($cartItems->flatten() as $cartItem) {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $cartItem->menuItem->id,
                    'name' => $cartItem->menuItem->name,
                    'price' => $cartItem->price,
                    'quantity' => $cartItem->quantity,
                ]);
            }

            $this->cartService->clearCart();

            // Notify restaurant owner about new order
            $order->restaurant->user->notify(new \App\Notifications\OrderPlaced($order));

            DB::commit();

            return redirect()->route('customer.checkout.success', $order)->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to place order. Please try again. ' . $e->getMessage());
        }
    }

    public function success(\App\Models\Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        return view('customer.checkout.success', compact('order'));
    }
}

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
        if (count($cartItems) === 0) {
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
        if (count($cartItems) === 0) {
            return redirect()->route('customer.cart.index')->with('error', 'Your cart is empty.');
        }

        // Verify address belongs to user
        $address = \App\Models\Address::where('id', $request->address_id)->where('user_id', auth()->id())->firstOrFail();

        // Get restaurant from first item (assuming single restaurant cart)
        $firstItem = reset($cartItems);
        // Assuming the cart item structure has 'model' which is the MenuItem
        $restaurantId = $firstItem['model']->category->restaurant_id;

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

            foreach ($cartItems as $id => $item) {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $item['model']->id,
                    'name' => $item['model']->name,
                    'price' => $item['model']->price, // Should ideally handle discount price logic here if CartService uses it
                    'quantity' => $item['quantity'],
                ]);
            }

            $this->cartService->clearCart();

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

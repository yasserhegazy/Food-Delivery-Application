<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display the cart.
     */
    public function index()
    {
        $cartItems = $this->cartService->getCart();
        $cartTotal = $this->cartService->getCartTotal();
        $cartCount = $this->cartService->getCartCount();

        return view('customer.cart.index', compact('cartItems', 'cartTotal', 'cartCount'));
    }

    /**
     * Add item to cart (AJAX).
     */
    public function add(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1|max:99',
            'special_instructions' => 'nullable|string|max:500',
        ]);

        try {
            $cartItem = $this->cartService->addItem(
                $request->menu_item_id,
                $request->quantity,
                $request->special_instructions
            );

            return response()->json([
                'success' => true,
                'message' => 'Item added to cart!',
                'cart_count' => $this->cartService->getCartCount(),
                'cart_item' => $cartItem,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add item to cart.',
            ], 500);
        }
    }

    /**
     * Update cart item quantity (AJAX).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0|max:99',
        ]);

        try {
            $cartItem = $this->cartService->updateQuantity($id, $request->quantity);

            return response()->json([
                'success' => true,
                'message' => 'Cart updated!',
                'cart_count' => $this->cartService->getCartCount(),
                'cart_total' => $this->cartService->getCartTotal(),
                'cart_item' => $cartItem,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update cart.',
            ], 500);
        }
    }

    /**
     * Remove item from cart (AJAX).
     */
    public function remove($id)
    {
        try {
            $this->cartService->removeItem($id);

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart!',
                'cart_count' => $this->cartService->getCartCount(),
                'cart_total' => $this->cartService->getCartTotal(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item.',
            ], 500);
        }
    }

    /**
     * Clear entire cart.
     */
    public function clear()
    {
        $this->cartService->clearCart();

        return redirect()->route('customer.cart.index')->with('success', 'Cart cleared!');
    }
}

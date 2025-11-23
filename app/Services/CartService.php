<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    /**
     * Get the session ID for the cart.
     */
    protected function getSessionId(): string
    {
        if (!Session::has('cart_session_id')) {
            Session::put('cart_session_id', Session::getId());
        }
        
        return Session::get('cart_session_id');
    }

    /**
     * Get all cart items for the current user/session.
     */
    public function getCart()
    {
        $query = CartItem::with(['menuItem.category.restaurant']);

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', $this->getSessionId());
        }

        return $query->get()->groupBy(function ($item) {
            return $item->menuItem->category->restaurant->id;
        });
    }

    /**
     * Get cart items count.
     */
    public function getCartCount(): int
    {
        $query = CartItem::query();

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', $this->getSessionId());
        }

        return $query->sum('quantity');
    }

    /**
     * Get cart total.
     */
    public function getCartTotal(): float
    {
        $query = CartItem::query();

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', $this->getSessionId());
        }

        $items = $query->get();
        
        return $items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    /**
     * Add item to cart.
     */
    public function addItem(int $menuItemId, int $quantity = 1, ?string $specialInstructions = null): CartItem
    {
        $menuItem = MenuItem::findOrFail($menuItemId);

        // Check if item already exists in cart
        $query = CartItem::where('menu_item_id', $menuItemId);

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', $this->getSessionId());
        }

        $cartItem = $query->first();

        if ($cartItem) {
            // Update existing cart item
            $cartItem->quantity += $quantity;
            if ($specialInstructions) {
                $cartItem->special_instructions = $specialInstructions;
            }
            $cartItem->save();
        } else {
            // Create new cart item
            $cartItem = CartItem::create([
                'session_id' => Auth::check() ? null : $this->getSessionId(),
                'user_id' => Auth::id(),
                'menu_item_id' => $menuItemId,
                'quantity' => $quantity,
                'price' => $menuItem->discount_price ?? $menuItem->price,
                'special_instructions' => $specialInstructions,
            ]);
        }

        return $cartItem->load('menuItem.category.restaurant');
    }

    /**
     * Update cart item quantity.
     */
    public function updateQuantity(int $cartItemId, int $quantity): CartItem
    {
        $cartItem = $this->getCartItem($cartItemId);
        
        if ($quantity <= 0) {
            $cartItem->delete();
            return $cartItem;
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        return $cartItem->load('menuItem.category.restaurant');
    }

    /**
     * Remove item from cart.
     */
    public function removeItem(int $cartItemId): void
    {
        $cartItem = $this->getCartItem($cartItemId);
        $cartItem->delete();
    }

    /**
     * Clear entire cart.
     */
    public function clearCart(): void
    {
        $query = CartItem::query();

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', $this->getSessionId());
        }

        $query->delete();
    }

    /**
     * Get a specific cart item (ensuring it belongs to current user/session).
     */
    protected function getCartItem(int $cartItemId): CartItem
    {
        $query = CartItem::where('id', $cartItemId);

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', $this->getSessionId());
        }

        return $query->firstOrFail();
    }

    /**
     * Transfer cart from session to user after login.
     */
    public function transferCartToUser(int $userId): void
    {
        CartItem::where('session_id', $this->getSessionId())
            ->update(['user_id' => $userId, 'session_id' => null]);
    }
}

@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

    @if($cartItems->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Cart Items --}}
            <div class="lg:col-span-2 space-y-6">
                @foreach($cartItems as $restaurantId => $items)
                    @php
                        $restaurant = $items->first()->menuItem->category->restaurant;
                        $restaurantTotal = $items->sum(fn($item) => $item->subtotal);
                    @endphp
                    
                    <x-card>
                        {{-- Restaurant Header --}}
                        <div class="flex items-center justify-between mb-4 pb-4 border-b">
                            <div class="flex items-center gap-3">
                                @if($restaurant->logo)
                                    <img src="{{ $restaurant->logo_url }}" 
                                         alt="{{ $restaurant->name }}"
                                         class="w-12 h-12 rounded-lg object-cover">
                                @endif
                                <div>
                                    <h3 class="font-bold text-lg">{{ $restaurant->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $items->count() }} item{{ $items->count() > 1 ? 's' : '' }}</p>
                                </div>
                            </div>
                            <span class="text-lg font-bold text-orange-600">
                                ${{ number_format($restaurantTotal, 2) }}
                            </span>
                        </div>

                        {{-- Cart Items --}}
                        <div class="space-y-4">
                            @foreach($items as $item)
                                <div x-data="{
                                    quantity: {{ $item->quantity }},
                                    loading: false,
                                    
                                    async updateQuantity(newQuantity) {
                                        this.loading = true;
                                        try {
                                            const response = await fetch('{{ route('customer.cart.update', $item->id) }}', {
                                                method: 'PATCH',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                    'Accept': 'application/json',
                                                },
                                                body: JSON.stringify({ quantity: newQuantity })
                                            });
                                            
                                            const data = await response.json();
                                            if (data.success) {
                                                if (newQuantity === 0) {
                                                    window.location.reload();
                                                } else {
                                                    this.quantity = newQuantity;
                                                    window.location.reload();
                                                }
                                            }
                                        } catch (error) {
                                            console.error('Error updating cart:', error);
                                        } finally {
                                            this.loading = false;
                                        }
                                    },
                                    
                                    async removeItem() {
                                        if (!confirm('Remove this item from cart?')) return;
                                        
                                        this.loading = true;
                                        try {
                                            const response = await fetch('{{ route('customer.cart.remove', $item->id) }}', {
                                                method: 'DELETE',
                                                headers: {
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                    'Accept': 'application/json',
                                                }
                                            });
                                            
                                            const data = await response.json();
                                            if (data.success) {
                                                window.location.reload();
                                            }
                                        } catch (error) {
                                            console.error('Error removing item:', error);
                                        } finally {
                                            this.loading = false;
                                        }
                                    }
                                }" class="flex gap-4 p-4 bg-gray-50 rounded-lg">
                                    {{-- Item Image --}}
                                    @if($item->menuItem->image)
                                        <img src="{{ $item->menuItem->image_url }}" 
                                             alt="{{ $item->menuItem->name }}"
                                             class="w-20 h-20 rounded-lg object-cover flex-shrink-0">
                                    @else
                                        <div class="w-20 h-20 rounded-lg bg-gray-200 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                            </svg>
                                        </div>
                                    @endif

                                    {{-- Item Details --}}
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900">{{ $item->menuItem->name }}</h4>
                                        <p class="text-sm text-gray-600">${{ number_format($item->price, 2) }} each</p>
                                        
                                        @if($item->special_instructions)
                                            <p class="text-xs text-gray-500 mt-1">
                                                <span class="font-medium">Note:</span> {{ $item->special_instructions }}
                                            </p>
                                        @endif

                                        {{-- Quantity Controls --}}
                                        <div class="flex items-center gap-3 mt-2">
                                            <div class="flex items-center border border-gray-300 rounded-lg">
                                                <button @click="updateQuantity(Math.max(0, quantity - 1))" 
                                                        :disabled="loading"
                                                        class="px-3 py-1 hover:bg-gray-100 transition disabled:opacity-50">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                    </svg>
                                                </button>
                                                <span class="px-4 py-1 font-medium" x-text="quantity"></span>
                                                <button @click="updateQuantity(Math.min(99, quantity + 1))" 
                                                        :disabled="loading"
                                                        class="px-3 py-1 hover:bg-gray-100 transition disabled:opacity-50">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                    </svg>
                                                </button>
                                            </div>

                                            <button @click="removeItem()" 
                                                    :disabled="loading"
                                                    class="text-red-600 hover:text-red-700 text-sm font-medium disabled:opacity-50">
                                                Remove
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Item Subtotal --}}
                                    <div class="text-right">
                                        <p class="font-bold text-gray-900">${{ number_format($item->subtotal, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-card>
                @endforeach
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-1">
                <x-card title="Order Summary" class="sticky top-4">
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal ({{ $cartCount }} items)</span>
                            <span>${{ number_format($cartTotal, 2) }}</span>
                        </div>
                        
                        @php
                            $deliveryFee = $cartItems->sum(function($items) {
                                return $items->first()->menuItem->category->restaurant->delivery_fee;
                            });
                        @endphp
                        
                        <div class="flex justify-between text-gray-600">
                            <span>Delivery Fee</span>
                            <span>${{ number_format($deliveryFee, 2) }}</span>
                        </div>
                        
                        <div class="border-t pt-3 flex justify-between text-lg font-bold">
                            <span>Total</span>
                            <span class="text-orange-600">${{ number_format($cartTotal + $deliveryFee, 2) }}</span>
                        </div>
                    </div>

                    <div class="mt-6 space-y-3">
                        <a href="{{ route('customer.checkout.index') }}" class="block">
                            <x-button variant="primary" class="w-full">
                                Proceed to Checkout
                            </x-button>
                        </a>
                        
                        <form action="{{ route('customer.cart.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear your cart?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    {{-- onclick="return confirm('Are you sure you want to clear your cart?')" --}}
                                    class="w-full text-red-600 hover:text-red-700 font-medium text-sm">
                                Clear Cart
                            </button>
                        </form>
                    </div>
                </x-card>
            </div>
        </div>
    @else
        {{-- Empty Cart --}}
        <x-card>
            <div class="text-center py-12">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Your cart is empty</h3>
                <p class="text-gray-600 mb-6">Add some delicious items to get started!</p>
                <a href="{{ route('restaurants.index') }}">
                    <x-button variant="primary">
                        Browse Restaurants
                    </x-button>
                </a>
            </div>
        </x-card>
    @endif
</div>
@endsection

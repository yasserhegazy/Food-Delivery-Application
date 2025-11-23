@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

    <form action="{{ route('customer.checkout.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Delivery Address --}}
                <x-card title="Delivery Address">
                    @if($addresses->count() > 0)
                        <div class="space-y-3">
                            @foreach($addresses as $address)
                                <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition hover:border-orange-500 {{ $address->is_default ? 'border-orange-500 bg-orange-50' : 'border-gray-200' }}">
                                    <input type="radio" 
                                           name="address_id" 
                                           value="{{ $address->id }}"
                                           {{ $address->is_default ? 'checked' : '' }}
                                           class="mt-1 w-4 h-4 text-orange-600 border-gray-300 focus:ring-orange-500"
                                           required>
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold text-gray-900">{{ $address->label }}</span>
                                            @if($address->is_default)
                                                <span class="px-2 py-0.5 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                                                    Default
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ $address->address_line_1 }}
                                            @if($address->address_line_2), {{ $address->address_line_2 }}@endif
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            {{ $address->city }}, {{ $address->zip_code }}
                                        </p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('customer.addresses.create') }}" class="text-orange-600 hover:text-orange-700 font-medium text-sm">
                                + Add New Address
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-600 mb-4">You don't have any saved addresses yet.</p>
                            <a href="{{ route('customer.addresses.create') }}">
                                <x-button variant="primary">
                                    Add Delivery Address
                                </x-button>
                            </a>
                        </div>
                    @endif
                    
                    @error('address_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </x-card>

                {{-- Special Instructions --}}
                <x-card title="Special Instructions (Optional)">
                    <textarea name="special_instructions" 
                              rows="4" 
                              placeholder="Add any special delivery instructions here..."
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">{{ old('special_instructions') }}</textarea>
                    @error('special_instructions')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </x-card>

                {{-- Order Items --}}
                <x-card title="Order Items">
                    <div class="space-y-4">
                        @foreach($cartItems as $restaurantId => $items)
                            @php
                                $restaurant = $items->first()->menuItem->category->restaurant;
                            @endphp
                            
                            <div class="border-b pb-4 last:border-b-0">
                                <h4 class="font-semibold text-gray-900 mb-3">{{ $restaurant->name }}</h4>
                                
                                @foreach($items as $item)
                                    <div class="flex justify-between items-center py-2">
                                        <div class="flex-1">
                                            <p class="text-gray-900">{{ $item->menuItem->name }}</p>
                                            <p class="text-sm text-gray-600">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                                        </div>
                                        <span class="font-medium text-gray-900">${{ number_format($item->subtotal, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </x-card>
            </div>

            {{-- Order Summary Sidebar --}}
            <div class="lg:col-span-1">
                <x-card title="Order Summary" class="sticky top-4">
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
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

                    <div class="mt-6">
                        @if($addresses->count() > 0)
                            <x-button type="submit" variant="primary" class="w-full">
                                Place Order
                            </x-button>
                        @else
                            <x-button type="button" variant="secondary" class="w-full" disabled>
                                Add Address to Continue
                            </x-button>
                        @endif
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('customer.cart.index') }}" class="block text-center text-gray-600 hover:text-gray-900 text-sm">
                            ← Back to Cart
                        </a>
                    </div>
                </x-card>
            </div>
        </div>
    </form>
</div>
@endsection

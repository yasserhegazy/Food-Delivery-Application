@extends('layouts.app')

@section('title', 'Order Placed Successfully')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <x-card>
        <div class="text-center py-8">
            {{-- Success Icon --}}
            <div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-6">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-2">Order Placed Successfully!</h1>
            <p class="text-gray-600 mb-8">Thank you for your order. We'll start preparing it right away.</p>

            {{-- Order Details --}}
            <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
                <h2 class="font-semibold text-lg text-gray-900 mb-4">Order Details</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order Number:</span>
                        <span class="font-medium text-gray-900">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Restaurant:</span>
                        <span class="font-medium text-gray-900">{{ $order->restaurant->name }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Amount:</span>
                        <span class="font-bold text-orange-600">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="px-3 py-1 text-sm font-medium text-yellow-700 bg-yellow-100 rounded-full">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    
                    <div class="border-t pt-3 mt-3">
                        <p class="text-gray-600 text-sm mb-1">Delivery Address:</p>
                        <p class="font-medium text-gray-900">{{ $order->address->label }}</p>
                        <p class="text-sm text-gray-600">
                            {{ $order->address->address_line_1 }}
                            @if($order->address->address_line_2), {{ $order->address->address_line_2 }}@endif
                        </p>
                        <p class="text-sm text-gray-600">
                            {{ $order->address->city }}, {{ $order->address->zip_code }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Order Items --}}
            <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
                <h2 class="font-semibold text-lg text-gray-900 mb-4">Items Ordered</h2>
                
                <div class="space-y-3">
                    @foreach($order->items as $item)
                        <div class="flex justify-between items-center">
                            <div class="flex-1">
                                <p class="text-gray-900">{{ $item->name }}</p>
                                <p class="text-sm text-gray-600">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                            </div>
                            <span class="font-medium text-gray-900">${{ number_format($item->price * $item->quantity, 2) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('restaurants.index') }}">
                    <x-button variant="primary">
                        Browse More Restaurants
                    </x-button>
                </a>
                <a href="{{ route('customer.dashboard') }}">
                    <x-button variant="secondary">
                        Go to Dashboard
                    </x-button>
                </a>
            </div>
        </div>
    </x-card>
</div>
@endsection

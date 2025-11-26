@extends('layouts.app')

@section('title', 'Order #' . str_pad($order->id, 6, '0', STR_PAD_LEFT))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('customer.orders.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to My Orders
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Order Header --}}
            <x-card>
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">
                            Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                        </h1>
                        <p class="text-gray-600">{{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                    </div>
                    <x-status-badge :status="$order->status" />
                </div>
                
                <div class="border-t pt-4">
                    <h2 class="text-lg font-bold text-gray-900 mb-2">{{ $order->restaurant->name }}</h2>
                    <p class="text-gray-600">{{ $order->restaurant->address }}, {{ $order->restaurant->city }}</p>
                </div>
            </x-card>

            {{-- Order Items --}}
            <x-card title="Order Items">
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex justify-between items-start py-3 border-b last:border-0">
                            <div class="flex-1">
                                <div class="flex items-center gap-3">
                                    <span class="font-bold text-gray-900">{{ $item->quantity }}x</span>
                                    <span class="text-gray-900">{{ $item->name }}</span>
                                </div>
                            </div>
                            <span class="font-medium text-gray-900">${{ number_format($item->price * $item->quantity, 2) }}</span>
                        </div>
                    @endforeach

                    <div class="pt-4 flex justify-between items-center text-lg font-bold border-t">
                        <span>Total Amount</span>
                        <span class="text-orange-600">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </x-card>

            {{-- Special Instructions --}}
            @if($order->special_instructions)
                <x-card title="Special Instructions">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-yellow-800">{{ $order->special_instructions }}</p>
                    </div>
                </x-card>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Delivery Address --}}
            <x-card title="Delivery Address">
                <div class="text-sm text-gray-600">
                    <p class="font-medium text-gray-900 mb-1">{{ $order->address->label }}</p>
                    <p>{{ $order->address->address_line_1 }}</p>
                    @if($order->address->address_line_2)
                        <p>{{ $order->address->address_line_2 }}</p>
                    @endif
                    <p>{{ $order->address->city }}, {{ $order->address->zip_code }}</p>
                </div>
            </x-card>

            {{-- Order Status Timeline --}}
            <x-card title="Order Status">
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full {{ in_array($order->status, ['pending', 'confirmed', 'preparing', 'ready_for_pickup', 'on_way', 'delivered']) ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                        <span class="text-sm {{ $order->status === 'pending' ? 'font-bold text-gray-900' : 'text-gray-600' }}">Order Placed</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full {{ in_array($order->status, ['confirmed', 'preparing', 'ready_for_pickup', 'on_way', 'delivered']) ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                        <span class="text-sm {{ $order->status === 'confirmed' ? 'font-bold text-gray-900' : 'text-gray-600' }}">Confirmed</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full {{ in_array($order->status, ['preparing', 'ready_for_pickup', 'on_way', 'delivered']) ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                        <span class="text-sm {{ $order->status === 'preparing' ? 'font-bold text-gray-900' : 'text-gray-600' }}">Preparing</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full {{ in_array($order->status, ['ready_for_pickup', 'on_way', 'delivered']) ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                        <span class="text-sm {{ $order->status === 'ready_for_pickup' ? 'font-bold text-gray-900' : 'text-gray-600' }}">Ready for Pickup</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full {{ in_array($order->status, ['on_way', 'delivered']) ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                        <span class="text-sm {{ $order->status === 'on_way' ? 'font-bold text-gray-900' : 'text-gray-600' }}">On the Way</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full {{ $order->status === 'delivered' ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                        <span class="text-sm {{ $order->status === 'delivered' ? 'font-bold text-gray-900' : 'text-gray-600' }}">Delivered</span>
                    </div>
                    
                    @if($order->status === 'cancelled')
                        <div class="flex items-center gap-3 mt-4 pt-4 border-t">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <span class="text-sm font-bold text-red-600">Order Cancelled</span>
                        </div>
                    @endif
                </div>
            </x-card>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Delivery Details')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('driver.deliveries.my') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to My Deliveries
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Restaurant Info --}}
            <x-card title="Pickup Location">
                <div class="space-y-2">
                    <h3 class="text-lg font-bold text-gray-900">{{ $order->restaurant->name }}</h3>
                    <p class="text-gray-600">{{ $order->restaurant->address }}</p>
                    <p class="text-gray-600">{{ $order->restaurant->city }}</p>
                    <p class="text-gray-600">{{ $order->restaurant->phone }}</p>
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
            {{-- Status Card --}}
            <x-card title="Delivery Status">
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-600">Current Status:</span>
                        <x-status-badge :status="$order->status" />
                    </div>
                </div>

                @if($order->status === 'on_way')
                    <form action="{{ route('driver.deliveries.status', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="delivered">
                        <x-button type="submit" variant="primary" class="w-full">
                            Mark as Delivered
                        </x-button>
                    </form>
                @endif
            </x-card>

            {{-- Customer Details --}}
            <x-card title="Customer Details">
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-lg">
                            {{ substr($order->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                            <a href="tel:{{ $order->user->phone }}" class="text-sm text-orange-600 hover:text-orange-700">
                                {{ $order->user->phone }}
                            </a>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <h4 class="font-medium text-gray-900 mb-2">Delivery Address</h4>
                        <div class="text-sm text-gray-600">
                            <p class="font-medium text-gray-900 mb-1">{{ $order->address->label }}</p>
                            <p>{{ $order->address->address_line_1 }}</p>
                            @if($order->address->address_line_2)
                                <p>{{ $order->address->address_line_2 }}</p>
                            @endif
                            <p>{{ $order->address->city }}, {{ $order->address->zip_code }}</p>
                        </div>
                        
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($order->address->address_line_1 . ', ' . $order->address->city . ', ' . $order->address->zip_code) }}" 
                           target="_blank"
                           class="inline-flex items-center gap-2 mt-3 text-orange-600 hover:text-orange-700 text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Get Directions
                        </a>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</div>
@endsection

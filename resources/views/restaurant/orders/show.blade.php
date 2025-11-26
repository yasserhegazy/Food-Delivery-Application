@extends('layouts.app')

@section('title', 'Order #' . str_pad($order->id, 6, '0', STR_PAD_LEFT))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('restaurant.orders.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Orders
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
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
                                @if($item->menuItem && $item->menuItem->description)
                                    <p class="text-sm text-gray-500 ml-8 mt-1">{{ Str::limit($item->menuItem->description, 50) }}</p>
                                @endif
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
            <x-card title="Order Status">
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-600">Current Status:</span>
                        <x-status-badge :status="$order->status" />
                    </div>
                    <p class="text-sm text-gray-500">
                        Last updated: {{ $order->updated_at->diffForHumans() }}
                    </p>
                </div>

                <div class="space-y-3">
                    @if($order->status === 'pending')
                        <form action="{{ route('restaurant.orders.status', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="confirmed">
                            <x-button type="submit" variant="primary" class="w-full">
                                Accept Order
                            </x-button>
                        </form>
                        <form action="{{ route('restaurant.orders.status', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to reject this order?')">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="w-full px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg font-medium transition border border-red-200 hover:border-red-300">
                                Reject Order
                            </button>
                        </form>
                    @elseif($order->status === 'confirmed')
                        <form action="{{ route('restaurant.orders.status', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="preparing">
                            <x-button type="submit" variant="primary" class="w-full">
                                Start Preparing
                            </x-button>
                        </form>
                    @elseif($order->status === 'preparing')
                        <form action="{{ route('restaurant.orders.status', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="ready_for_pickup">
                            <x-button type="submit" variant="primary" class="w-full">
                                Mark Ready for Pickup
                            </x-button>
                        </form>
                    @elseif($order->status === 'ready_for_pickup')
                        <form action="{{ route('restaurant.orders.status', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="delivered">
                            <x-button type="submit" variant="primary" class="w-full">
                                Mark as Delivered
                            </x-button>
                        </form>
                    @endif
                </div>
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
                            <p class="text-sm text-gray-500">{{ $order->user->phone }}</p>
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
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</div>
@endsection

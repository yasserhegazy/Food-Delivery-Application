@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">My Orders</h1>

    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                <x-card>
                    <div class="flex flex-col md:flex-row justify-between gap-4">
                        {{-- Order Info --}}
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-lg font-bold text-gray-900">
                                    {{ $order->restaurant->name }}
                                </h3>
                                <x-status-badge :status="$order->status" />
                            </div>
                            
                            <p class="text-sm text-gray-500 mb-2">
                                Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }} • {{ $order->created_at->format('M d, Y h:i A') }}
                            </p>
                            
                            <p class="text-gray-600">
                                <span class="font-medium">Items:</span> {{ $order->items->count() }} items
                                <span class="text-gray-400 mx-2">|</span>
                                <span class="font-medium">Total:</span> ${{ number_format($order->total_amount, 2) }}
                            </p>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center">
                            <a href="{{ route('customer.orders.show', $order) }}">
                                <x-button variant="secondary">
                                    View Details
                                </x-button>
                            </a>
                        </div>
                    </div>
                </x-card>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @else
        <x-card>
            <div class="text-center py-12">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No orders yet</h3>
                <p class="text-gray-600 mb-4">Start browsing restaurants to place your first order!</p>
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

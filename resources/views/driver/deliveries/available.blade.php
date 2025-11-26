@extends('layouts.app')

@section('title', 'Available Deliveries')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Available Deliveries</h1>

    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                <x-card>
                    <div class="flex flex-col md:flex-row justify-between gap-4">
                        {{-- Delivery Info --}}
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-lg font-bold text-gray-900">
                                    {{ $order->restaurant->name }}
                                </h3>
                                <span class="text-sm text-gray-500">
                                    Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                            
                            <div class="space-y-1 text-sm text-gray-600">
                                <p>
                                    <span class="font-medium">Pickup:</span> {{ $order->restaurant->address }}, {{ $order->restaurant->city }}
                                </p>
                                <p>
                                    <span class="font-medium">Deliver to:</span> {{ $order->address->address_line_1 }}, {{ $order->address->city }}
                                </p>
                                <p>
                                    <span class="font-medium">Items:</span> {{ $order->items->count() }} items
                                    <span class="text-gray-400 mx-2">|</span>
                                    <span class="font-medium">Total:</span> ${{ number_format($order->total_amount, 2) }}
                                </p>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center">
                            <form action="{{ route('driver.deliveries.accept', $order) }}" method="POST">
                                @csrf
                                <x-button type="submit" variant="primary">
                                    Accept Delivery
                                </x-button>
                            </form>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No deliveries available</h3>
                <p class="text-gray-600">Check back later for new delivery opportunities!</p>
            </div>
        </x-card>
    @endif
</div>
@endsection

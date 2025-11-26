@extends('layouts.app')

@section('title', 'Order Management')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Order Management</h1>
    </div>

    {{-- Status Tabs --}}
    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8">
            <a href="{{ route('restaurant.orders.index', ['status' => 'pending']) }}"
               class="{{ $status === 'pending' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                New Orders
            </a>
            <a href="{{ route('restaurant.orders.index', ['status' => 'active']) }}"
               class="{{ $status === 'active' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Active Orders
            </a>
            <a href="{{ route('restaurant.orders.index', ['status' => 'past']) }}"
               class="{{ $status === 'past' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Order History
            </a>
        </nav>
    </div>

    {{-- Orders List --}}
    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                <x-card>
                    <div class="flex flex-col md:flex-row justify-between gap-4">
                        {{-- Order Info --}}
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-lg font-bold text-gray-900">
                                    Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                </h3>
                                <x-status-badge :status="$order->status" />
                                <span class="text-sm text-gray-500">
                                    {{ $order->created_at->diffForHumans() }}
                                </span>
                            </div>
                            
                            <p class="text-gray-600 mb-1">
                                <span class="font-medium">Customer:</span> {{ $order->user->name }}
                            </p>
                            <p class="text-gray-600">
                                <span class="font-medium">Items:</span> {{ $order->items->count() }} items
                                <span class="text-gray-400 mx-2">|</span>
                                <span class="font-medium">Total:</span> ${{ number_format($order->total_amount, 2) }}
                            </p>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-3">
                            <a href="{{ route('restaurant.orders.show', $order) }}">
                                <x-button variant="secondary">
                                    View Details
                                </x-button>
                            </a>

                            @if($order->status === 'pending')
                                <form action="{{ route('restaurant.orders.status', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="confirmed">
                                    <x-button type="submit" variant="primary">
                                        Accept Order
                                    </x-button>
                                </form>
                                <form action="{{ route('restaurant.orders.status', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to reject this order?')">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg font-medium transition">
                                        Reject
                                    </button>
                                </form>
                            @elseif($order->status === 'confirmed')
                                <form action="{{ route('restaurant.orders.status', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="preparing">
                                    <x-button type="submit" variant="primary">
                                        Start Preparing
                                    </x-button>
                                </form>
                            @elseif($order->status === 'preparing')
                                <form action="{{ route('restaurant.orders.status', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="ready_for_pickup">
                                    <x-button type="submit" variant="primary">
                                        Mark Ready
                                    </x-button>
                                </form>
                            @endif
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
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No orders found</h3>
                <p class="text-gray-600">There are no orders in this category right now.</p>
            </div>
        </x-card>
    @endif
</div>
@endsection

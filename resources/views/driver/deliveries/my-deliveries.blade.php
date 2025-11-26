@extends('layouts.app')

@section('title', 'My Deliveries')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">My Deliveries</h1>

    {{-- Status Tabs --}}
    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8">
            <a href="{{ route('driver.deliveries.my', ['status' => 'active']) }}"
               class="{{ $status === 'active' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Active Deliveries
            </a>
            <a href="{{ route('driver.deliveries.my', ['status' => 'completed']) }}"
               class="{{ $status === 'completed' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Completed
            </a>
        </nav>
    </div>

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
                                <x-status-badge :status="$order->status" />
                            </div>
                            
                            <div class="space-y-1 text-sm text-gray-600">
                                <p>
                                    <span class="font-medium">Customer:</span> {{ $order->user->name }}
                                </p>
                                <p>
                                    <span class="font-medium">Deliver to:</span> {{ $order->address->address_line_1 }}, {{ $order->address->city }}
                                </p>
                                <p>
                                    <span class="font-medium">Total:</span> ${{ number_format($order->total_amount, 2) }}
                                    <span class="text-gray-400 mx-2">|</span>
                                    <span class="text-gray-500">{{ $order->created_at->diffForHumans() }}</span>
                                </p>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-3">
                            <a href="{{ route('driver.deliveries.show', $order) }}">
                                <x-button variant="secondary">
                                    View Details
                                </x-button>
                            </a>

                            @if($order->status === 'on_way')
                                <form action="{{ route('driver.deliveries.status', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="delivered">
                                    <x-button type="submit" variant="primary">
                                        Mark as Delivered
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
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No deliveries found</h3>
                <p class="text-gray-600">
                    @if($status === 'active')
                        You don't have any active deliveries right now.
                    @else
                        You haven't completed any deliveries yet.
                    @endif
                </p>
            </div>
        </x-card>
    @endif
</div>
@endsection

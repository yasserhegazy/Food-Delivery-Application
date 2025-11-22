@extends('layouts.app')

@section('title', $restaurant->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <a href="{{ route('admin.restaurants.index') }}" class="text-orange-600 hover:text-orange-700 mb-4 inline-flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Restaurants
        </a>
        <div class="flex items-start justify-between mt-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $restaurant->name }}</h1>
                <p class="text-gray-600 mt-1">{{ $restaurant->city }}</p>
            </div>
            <x-status-badge :status="$restaurant->is_active" class="text-base px-4 py-2" />
        </div>
    </div>

    {{-- Analytics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <x-card>
            <div class="text-center">
                <p class="text-3xl font-bold text-blue-600">{{ $stats['total_categories'] }}</p>
                <p class="text-sm text-gray-600 mt-1">Categories</p>
            </div>
        </x-card>
        <x-card>
            <div class="text-center">
                <p class="text-3xl font-bold text-green-600">{{ $stats['total_menu_items'] }}</p>
                <p class="text-sm text-gray-600 mt-1">Menu Items</p>
            </div>
        </x-card>
        <x-card>
            <div class="text-center">
                <p class="text-3xl font-bold text-orange-600">{{ $stats['active_menu_items'] }}</p>
                <p class="text-sm text-gray-600 mt-1">Available Items</p>
            </div>
        </x-card>
        <x-card>
            <div class="text-center">
                <p class="text-3xl font-bold text-purple-600">${{ number_format($stats['avg_menu_price'], 2) }}</p>
                <p class="text-sm text-gray-600 mt-1">Avg Menu Price</p>
            </div>
        </x-card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Restaurant Information --}}
        <div class="lg:col-span-2 space-y-6">
            <x-card title="Restaurant Information">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Owner</label>
                        <p class="text-gray-900">{{ $restaurant->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $restaurant->user->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Phone</label>
                        <p class="text-gray-900">{{ $restaurant->phone }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Email</label>
                        <p class="text-gray-900">{{ $restaurant->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">City</label>
                        <p class="text-gray-900">{{ $restaurant->city }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-gray-500">Address</label>
                        <p class="text-gray-900">{{ $restaurant->address }}</p>
                    </div>
                    @if($restaurant->description)
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-gray-500">Description</label>
                        <p class="text-gray-900">{{ $restaurant->description }}</p>
                    </div>
                    @endif
                </div>
            </x-card>

            <x-card title="Operating Details">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Opening Time</label>
                        <p class="text-gray-900">{{ $restaurant->opening_time ?? 'Not set' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Closing Time</label>
                        <p class="text-gray-900">{{ $restaurant->closing_time ?? 'Not set' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Delivery Time</label>
                        <p class="text-gray-900">{{ $restaurant->delivery_time ? $restaurant->delivery_time . ' minutes' : 'Not set' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Delivery Fee</label>
                        <p class="text-gray-900">${{ number_format($restaurant->delivery_fee, 2) }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Minimum Order</label>
                        <p class="text-gray-900">${{ number_format($restaurant->minimum_order, 2) }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Rating</label>
                        <div class="flex items-center gap-2">
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $restaurant->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-gray-900">{{ number_format($restaurant->rating, 1) }} ({{ $restaurant->total_reviews }} reviews)</span>
                        </div>
                    </div>
                </div>
            </x-card>

            {{-- Categories and Menu Items --}}
            @if($restaurant->categories->count() > 0)
            <x-card title="Menu Categories">
                <div class="space-y-4">
                    @foreach($restaurant->categories as $category)
                    <div class="border-b last:border-b-0 pb-4 last:pb-0">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-semibold text-gray-900">{{ $category->name }}</h4>
                            <span class="text-sm text-gray-500">{{ $category->menuItems->count() }} items</span>
                        </div>
                        @if($category->menuItems->count() > 0)
                        <div class="space-y-2">
                            @foreach($category->menuItems as $item)
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-700">{{ $item->name }}</span>
                                    @if(!$item->is_available)
                                    <span class="text-xs text-red-600">(Unavailable)</span>
                                    @endif
                                </div>
                                <span class="font-medium text-gray-900">${{ number_format($item->price, 2) }}</span>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </x-card>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            <x-card title="Quick Stats">
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Total Orders</label>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p>
                        <p class="text-xs text-gray-500">Coming soon</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Total Revenue</label>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($stats['total_revenue'], 2) }}</p>
                        <p class="text-xs text-gray-500">Coming soon</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Pending Orders</label>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_orders'] }}</p>
                        <p class="text-xs text-gray-500">Coming soon</p>
                    </div>
                </div>
            </x-card>

            <x-card title="Owner Information">
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                            <span class="text-orange-600 font-semibold text-lg">{{ substr($restaurant->user->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $restaurant->user->name }}</p>
                            <x-role-badge :role="$restaurant->user->role" />
                        </div>
                    </div>
                    <div class="pt-3 border-t">
                        <p class="text-sm text-gray-600">{{ $restaurant->user->email }}</p>
                        <p class="text-sm text-gray-600">{{ $restaurant->user->phone ?? 'No phone' }}</p>
                    </div>
                    <div class="pt-3 border-t">
                        <a href="{{ route('admin.users.show', $restaurant->user) }}" class="text-orange-600 hover:text-orange-700 text-sm">
                            View Owner Profile →
                        </a>
                    </div>
                </div>
            </x-card>

            <x-card title="Timeline">
                <div class="space-y-3 text-sm">
                    <div>
                        <label class="text-gray-500">Created</label>
                        <p class="text-gray-900">{{ $restaurant->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <label class="text-gray-500">Last Updated</label>
                        <p class="text-gray-900">{{ $restaurant->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
        <p class="text-gray-600 mt-1">Platform overview and management</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <x-card>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_users'] }}</p>
                    <p class="text-sm text-gray-600">Total Users</p>
                </div>
            </div>
        </x-card>

        <x-card>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_restaurants'] }}</p>
                    <p class="text-sm text-gray-600">Restaurants</p>
                </div>
            </div>
        </x-card>

        <x-card>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_orders'] }}</p>
                    <p class="text-sm text-gray-600">Total Orders</p>
                </div>
            </div>
        </x-card>

        <x-card>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">${{ number_format($stats['total_revenue'], 2) }}</p>
                    <p class="text-sm text-gray-600">Total Revenue</p>
                </div>
            </div>
        </x-card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <x-card title="User Distribution">
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Customers</p>
                            <p class="text-sm text-gray-500">{{ $stats['customers'] }} users</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-gray-800">{{ $stats['customers'] }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Restaurant Owners</p>
                            <p class="text-sm text-gray-500">{{ $stats['restaurant_owners'] }} users</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-gray-800">{{ $stats['restaurant_owners'] }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Drivers</p>
                            <p class="text-sm text-gray-500">{{ $stats['drivers'] }} users</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-gray-800">{{ $stats['drivers'] }}</span>
                </div>
            </div>
        </x-card>

        <x-card title="Quick Actions">
            <div class="space-y-3">
                <a href="{{ route('admin.users.index') }}">
                    <x-button variant="primary" class="w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Manage Users
                    </x-button>
                </a>
                <a href="{{ route('admin.restaurants.index') }}">
                    <x-button variant="outline" class="w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        View Restaurants
                    </x-button>
                </a>
                <a href="{{ route('admin.categories.index') }}">
                    <x-button variant="outline" class="w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        View Categories
                    </x-button>
                </a>
                <a href="{{ route('admin.menu-items.index') }}">
                    <x-button variant="outline" class="w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        View Menu Items
                    </x-button>
                </a>
            </div>
        </x-card>
    </div>

    @if($recentRestaurants->count() > 0 || $recentUsers->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @if($recentRestaurants->count() > 0)
        <x-card title="Recent Restaurants">
            <div class="space-y-3">
                @foreach($recentRestaurants as $restaurant)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $restaurant->name }}</p>
                        <p class="text-sm text-gray-500">{{ $restaurant->city }} • {{ $restaurant->user->name }}</p>
                    </div>
                    <x-status-badge :status="$restaurant->is_active" />
                </div>
                @endforeach
            </div>
        </x-card>
        @endif

        @if($recentUsers->count() > 0)
        <x-card title="Recent Users">
            <div class="space-y-3">
                @foreach($recentUsers as $user)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    </div>
                    <x-role-badge :role="$user->role" />
                </div>
                @endforeach
            </div>
        </x-card>
        @endif
    </div>
    @endif
</div>
@endsection

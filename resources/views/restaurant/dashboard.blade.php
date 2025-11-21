@extends('layouts.app')

@section('title', 'Restaurant Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Restaurant Dashboard</h1>
            <p class="mt-2 text-gray-600">Manage your restaurant and menu</p>
        </div>

        @php
            $restaurant = auth()->user()->restaurant;
            $stats = [
                'categories' => $restaurant ? $restaurant->categories()->count() : 0,
                'menuItems' => $restaurant ? $restaurant->menuItems()->count() : 0,
                'available' => $restaurant ? $restaurant->menuItems()->available()->count() : 0,
            ];
        @endphp

        @if(!$restaurant)
            <!-- No Restaurant Alert -->
            <x-alert type="warning" class="mb-8">
                <strong>Welcome!</strong> You haven't set up your restaurant profile yet. Get started by creating your restaurant.
            </x-alert>

            <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                <svg class="mx-auto h-16 w-16 text-orange-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Create Your Restaurant</h2>
                <p class="text-gray-600 mb-6">Set up your restaurant profile to start managing your menu and accepting orders.</p>
                <a href="{{ route('restaurant.profile.edit') }}">
                    <x-button variant="primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Restaurant Profile
                    </x-button>
                </a>
            </div>
        @else
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <x-stat-card 
                    title="Total Categories" 
                    :value="$stats['categories']"
                    color="blue">
                    <x-slot:icon>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                    </x-slot:icon>
                </x-stat-card>

                <x-stat-card 
                    title="Total Menu Items" 
                    :value="$stats['menuItems']"
                    color="orange">
                    <x-slot:icon>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </x-slot:icon>
                </x-stat-card>

                <x-stat-card 
                    title="Available Items" 
                    :value="$stats['available']"
                    color="green">
                    <x-slot:icon>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </x-slot:icon>
                </x-stat-card>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <a href="{{ route('restaurant.profile.edit') }}" class="flex items-center gap-3 p-4 rounded-lg border-2 border-gray-200 hover:border-orange-500 hover:bg-orange-50 transition group">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center group-hover:bg-orange-500 transition">
                            <svg class="w-6 h-6 text-orange-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Edit Profile</div>
                            <div class="text-sm text-gray-500">Update info</div>
                        </div>
                    </a>

                    <a href="{{ route('restaurant.categories.index') }}" class="flex items-center gap-3 p-4 rounded-lg border-2 border-gray-200 hover:border-orange-500 hover:bg-orange-50 transition group">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-orange-500 transition">
                            <svg class="w-6 h-6 text-blue-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Categories</div>
                            <div class="text-sm text-gray-500">Manage categories</div>
                        </div>
                    </a>

                    <a href="{{ route('restaurant.menu.index') }}" class="flex items-center gap-3 p-4 rounded-lg border-2 border-gray-200 hover:border-orange-500 hover:bg-orange-50 transition group">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-orange-500 transition">
                            <svg class="w-6 h-6 text-green-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Menu Items</div>
                            <div class="text-sm text-gray-500">Manage menu</div>
                        </div>
                    </a>

                    <a href="{{ route('restaurants.show', $restaurant->slug) }}" target="_blank" class="flex items-center gap-3 p-4 rounded-lg border-2 border-gray-200 hover:border-orange-500 hover:bg-orange-50 transition group">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-orange-500 transition">
                            <svg class="w-6 h-6 text-purple-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">View Public Page</div>
                            <div class="text-sm text-gray-500">See your menu</div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Restaurant Info -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Restaurant Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Restaurant Name</h3>
                        <p class="text-gray-900">{{ $restaurant->name }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Status</h3>
                        @if($restaurant->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Inactive
                            </span>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Phone</h3>
                        <p class="text-gray-900">{{ $restaurant->phone }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">City</h3>
                        <p class="text-gray-900">{{ $restaurant->city }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Customer Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Welcome, {{ auth()->user()->name }}!</h1>
        <p class="text-gray-600 mt-1">Discover delicious food from restaurants near you</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <x-card>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">0</p>
                    <p class="text-sm text-gray-600">Active Orders</p>
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
                    <p class="text-2xl font-bold text-gray-800">0</p>
                    <p class="text-sm text-gray-600">Completed Orders</p>
                </div>
            </div>
        </x-card>

        <x-card>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">0</p>
                    <p class="text-sm text-gray-600">Favorite Restaurants</p>
                </div>
            </div>
        </x-card>
    </div>

    {{-- Featured Restaurants --}}
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Featured Restaurants</h2>
                <p class="text-gray-600 mt-1">Top-rated restaurants near you</p>
            </div>
            <a href="{{ route('restaurants.index') }}" class="text-orange-600 hover:text-orange-700 font-medium flex items-center gap-2">
                View All
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @if($featuredRestaurants->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredRestaurants as $restaurant)
                    <x-restaurant-card :restaurant="$restaurant" />
                @endforeach
            </div>
        @else
            <x-card>
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <p class="text-gray-500">No featured restaurants available yet</p>
                    <p class="text-sm text-gray-400 mt-1">Check back soon for delicious options!</p>
                </div>
            </x-card>
        @endif
    </div>

    {{-- Recently Added --}}
    @if($recentRestaurants->count() > 0)
    <div>
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Recently Added</h2>
            <p class="text-gray-600 mt-1">New restaurants on our platform</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($recentRestaurants as $restaurant)
                <x-restaurant-card :restaurant="$restaurant" />
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

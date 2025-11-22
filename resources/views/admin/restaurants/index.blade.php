@extends('layouts.app')

@section('title', 'Restaurants')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Restaurants</h1>
        <p class="text-gray-600 mt-1">View all restaurants and their analytics</p>
    </div>

    {{-- Statistics --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <x-card>
            <div class="text-center">
                <p class="text-3xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                <p class="text-sm text-gray-600 mt-1">Total Restaurants</p>
            </div>
        </x-card>
        <x-card>
            <div class="text-center">
                <p class="text-3xl font-bold text-green-600">{{ $stats['active'] }}</p>
                <p class="text-sm text-gray-600 mt-1">Active</p>
            </div>
        </x-card>
        <x-card>
            <div class="text-center">
                <p class="text-3xl font-bold text-red-600">{{ $stats['inactive'] }}</p>
                <p class="text-sm text-gray-600 mt-1">Inactive</p>
            </div>
        </x-card>
        <x-card>
            <div class="text-center">
                <p class="text-3xl font-bold text-orange-600">{{ number_format($stats['avg_rating'], 1) }}</p>
                <p class="text-sm text-gray-600 mt-1">Avg Rating</p>
            </div>
        </x-card>
    </div>

    {{-- Filters --}}
    <x-card class="mb-6">
        <form method="GET" action="{{ route('admin.restaurants.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <x-input 
                    name="search" 
                    placeholder="Search restaurants..." 
                    value="{{ request('search') }}"
                />
            </div>
            <div>
                <select name="city" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200">
                    <option value="">All Cities</option>
                    @foreach($cities as $city)
                    <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="status" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div>
                <select name="min_rating" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200">
                    <option value="">All Ratings</option>
                    <option value="4" {{ request('min_rating') == '4' ? 'selected' : '' }}>4+ Stars</option>
                    <option value="3" {{ request('min_rating') == '3' ? 'selected' : '' }}>3+ Stars</option>
                    <option value="2" {{ request('min_rating') == '2' ? 'selected' : '' }}>2+ Stars</option>
                </select>
            </div>
            <div class="flex gap-2">
                <x-button type="submit" variant="primary">Filter</x-button>
                <a href="{{ route('admin.restaurants.index') }}">
                    <x-button type="button" variant="outline">Clear</x-button>
                </a>
            </div>
        </form>
    </x-card>

    {{-- Restaurants Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($restaurants as $restaurant)
        <x-card class="hover:shadow-lg transition-shadow">
            <div class="space-y-4">
                {{-- Restaurant Header --}}
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $restaurant->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $restaurant->city }}</p>
                    </div>
                    <x-status-badge :status="$restaurant->is_active" />
                </div>

                {{-- Rating --}}
                <div class="flex items-center gap-2">
                    <div class="flex items-center">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $restaurant->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-sm text-gray-600">{{ number_format($restaurant->rating, 1) }} ({{ $restaurant->total_reviews }})</span>
                </div>

                {{-- Info --}}
                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>{{ $restaurant->user->name }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span>{{ $restaurant->phone }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Min Order: ${{ number_format($restaurant->minimum_order, 2) }}</span>
                    </div>
                </div>

                {{-- Action --}}
                <div class="pt-4 border-t">
                    <a href="{{ route('admin.restaurants.show', $restaurant) }}">
                        <x-button variant="outline" class="w-full">
                            View Details
                        </x-button>
                    </a>
                </div>
            </div>
        </x-card>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500">No restaurants found.</p>
        </div>
        @endforelse
    </div>

    @if($restaurants->hasPages())
    <div class="mt-6">
        {{ $restaurants->links() }}
    </div>
    @endif
</div>
@endsection

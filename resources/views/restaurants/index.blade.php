@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Discover Restaurants</h1>
            <p class="mt-2 text-gray-600">Find your favorite meals from local restaurants</p>
        </div>

        <!-- Search & Filters -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <form method="GET" action="{{ route('restaurants.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <x-input 
                            name="search" 
                            label="Search restaurants" 
                            placeholder="Restaurant name or cuisine..."
                            :value="request('search')"
                            icon="search" />
                    </div>

                    <!-- City Filter -->
                    <div>
                        <x-select 
                            name="city" 
                            label="City"
                            :options="$cities->mapWithKeys(fn($city) => [$city => $city])->toArray()"
                            :selected="request('city')"
                            placeholder="All cities" />
                    </div>

                    <!-- Rating Filter -->
                    <div>
                        <x-select 
                            name="min_rating" 
                            label="Minimum Rating"
                            :options="['4.5' => '4.5+ Stars', '4.0' => '4.0+ Stars', '3.5' => '3.5+ Stars']"
                            :selected="request('min_rating')"
                            placeholder="Any rating" />
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <x-button type="submit" variant="primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search
                    </x-button>
                    
                    @if(request()->hasAny(['search', 'city', 'min_rating']))
                        <a href="{{ route('restaurants.index') }}" class="text-gray-600 hover:text-gray-900">
                            Clear filters
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Results -->
        @if($restaurants->count() > 0)
            <div class="mb-4 text-gray-600">
                Found {{ $restaurants->total() }} restaurant{{ $restaurants->total() !== 1 ? 's' : '' }}
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($restaurants as $restaurant)
                    <x-restaurant-card :restaurant="$restaurant" />
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $restaurants->links() }}
            </div>
        @else
            <x-empty-state 
                title="No restaurants found"
                message="Try adjusting your search or filters to find what you're looking for."
                icon="search" />
        @endif
    </div>
</div>
@endsection

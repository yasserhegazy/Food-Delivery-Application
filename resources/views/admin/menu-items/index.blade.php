@extends('layouts.app')

@section('title', 'Menu Items')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Menu Items</h1>
        <p class="text-gray-600 mt-1">View all menu items across restaurants</p>
    </div>

    {{-- Filters --}}
    <x-card class="mb-6">
        <form method="GET" action="{{ route('admin.menu-items.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <x-input 
                    name="search" 
                    placeholder="Search menu items..." 
                    value="{{ request('search') }}"
                />
            </div>
            <div>
                <select name="restaurant_id" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200">
                    <option value="">All Restaurants</option>
                    @foreach($restaurants as $restaurant)
                    <option value="{{ $restaurant->id }}" {{ request('restaurant_id') == $restaurant->id ? 'selected' : '' }}>
                        {{ $restaurant->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="category_id" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }} ({{ $category->restaurant->name }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="available" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200">
                    <option value="">All Availability</option>
                    <option value="yes" {{ request('available') === 'yes' ? 'selected' : '' }}>Available</option>
                    <option value="no" {{ request('available') === 'no' ? 'selected' : '' }}>Unavailable</option>
                </select>
            </div>
            <div class="flex gap-2">
                <x-button type="submit" variant="primary">Filter</x-button>
                <a href="{{ route('admin.menu-items.index') }}">
                    <x-button type="button" variant="outline">Clear</x-button>
                </a>
            </div>
        </form>
    </x-card>

    {{-- Menu Items Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($menuItems as $item)
        <x-card class="hover:shadow-lg transition-shadow">
            <div class="space-y-4">
                {{-- Image --}}
                @if($item->image)
                <div class="aspect-video bg-gray-200 rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                </div>
                @else
                <div class="aspect-video bg-gradient-to-br from-orange-100 to-orange-200 rounded-lg flex items-center justify-center">
                    <svg class="w-16 h-16 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                @endif

                {{-- Info --}}
                <div>
                    <div class="flex items-start justify-between mb-2">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $item->name }}</h3>
                        <span class="text-lg font-bold text-orange-600">${{ number_format($item->price, 2) }}</span>
                    </div>
                    @if($item->description)
                    <p class="text-sm text-gray-600 mb-3">{{ Str::limit($item->description, 80) }}</p>
                    @endif

                    <div class="space-y-2 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Restaurant:</span>
                            <span class="font-medium text-gray-900">{{ $item->category->restaurant->name }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Category:</span>
                            <span class="font-medium text-gray-900">{{ $item->category->name }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Status:</span>
                            <x-status-badge :status="$item->is_available">
                                {{ $item->is_available ? 'Available' : 'Unavailable' }}
                            </x-status-badge>
                        </div>
                    </div>
                </div>
            </div>
        </x-card>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500">No menu items found.</p>
        </div>
        @endforelse
    </div>

    @if($menuItems->hasPages())
    <div class="mt-6">
        {{ $menuItems->links() }}
    </div>
    @endif
</div>
@endsection

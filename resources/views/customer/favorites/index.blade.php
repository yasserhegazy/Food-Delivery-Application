@extends('layouts.app')

@section('title', 'My Favorites')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">My Favorites</h1>
        <p class="text-gray-600 mt-1">Restaurants you've saved for later</p>
    </div>

    @if($restaurants->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($restaurants as $restaurant)
                <x-restaurant-card :restaurant="$restaurant" />
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">No favorites yet</h3>
            <p class="text-gray-500 mb-6">Start exploring restaurants and save your favorites!</p>
            <a href="{{ route('restaurants.index') }}" class="inline-flex items-center px-6 py-3 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 transition-colors">
                Browse Restaurants
            </a>
        </div>
    @endif
</div>
@endsection

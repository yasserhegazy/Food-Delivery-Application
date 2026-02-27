@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Restaurant Profile</h1>
            <p class="mt-2 text-gray-600">Manage your restaurant information and settings</p>
        </div>

        <form method="POST" action="{{ route('restaurant.profile.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <x-card title="Basic Information">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <x-input 
                            name="name" 
                            label="Restaurant Name" 
                            :value="old('name', $restaurant->name ?? '')"
                            required />
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea 
                            name="description" 
                            rows="3"
                            class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                            placeholder="Tell customers about your restaurant...">{{ old('description', $restaurant->description ?? '') }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-card>

            <!-- Contact Information -->
            <x-card title="Contact Information">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-input 
                        name="phone" 
                        label="Phone Number" 
                        type="tel"
                        :value="old('phone', $restaurant->phone ?? '')"
                        required />

                    <x-input 
                        name="email" 
                        label="Email Address" 
                        type="email"
                        :value="old('email', $restaurant->email ?? '')"
                        required />

                    <div class="md:col-span-2">
                        <x-input 
                            name="address" 
                            label="Street Address" 
                            :value="old('address', $restaurant->address ?? '')"
                            required />
                    </div>

                    <x-input 
                        name="city" 
                        label="City" 
                        :value="old('city', $restaurant->city ?? '')"
                        required />

                    <div class="grid grid-cols-2 gap-4">
                        <x-input 
                            name="latitude" 
                            label="Latitude" 
                            type="number"
                            step="0.0000001"
                            :value="old('latitude', $restaurant->latitude ?? '')" />

                        <x-input 
                            name="longitude" 
                            label="Longitude" 
                            type="number"
                            step="0.0000001"
                            :value="old('longitude', $restaurant->longitude ?? '')" />
                    </div>
                </div>
            </x-card>

            <!-- Operating Hours -->
            <x-card title="Operating Hours">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-input 
                        name="opening_time" 
                        label="Opening Time" 
                        type="time"
                        :value="old('opening_time', $restaurant->opening_time ?? '')" />

                    <x-input 
                        name="closing_time" 
                        label="Closing Time" 
                        type="time"
                        :value="old('closing_time', $restaurant->closing_time ?? '')" />
                </div>
            </x-card>

            <!-- Delivery Settings -->
            <x-card title="Delivery Settings">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <x-input 
                        name="delivery_time" 
                        label="Delivery Time (minutes)" 
                        type="number"
                        min="0"
                        :value="old('delivery_time', $restaurant->delivery_time ?? '')" />

                    <x-input 
                        name="minimum_order" 
                        label="Minimum Order ($)" 
                        type="number"
                        step="0.01"
                        min="0"
                        :value="old('minimum_order', $restaurant->minimum_order ?? '')" />

                    <x-input 
                        name="delivery_fee" 
                        label="Delivery Fee ($)" 
                        type="number"
                        step="0.01"
                        min="0"
                        :value="old('delivery_fee', $restaurant->delivery_fee ?? '')" />
                </div>
            </x-card>

            <!-- Images -->
            @if($restaurant->exists)
                <x-card title="Restaurant Images">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Logo</h4>
                            @if($restaurant->logo)
                                <img src="{{ $restaurant->logo_url }}" 
                                     alt="Logo" 
                                     class="w-32 h-32 object-cover rounded-lg mb-3">
                            @endif
                            <form action="{{ route('restaurant.profile.logo') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <x-image-upload name="logo" label="" :current="$restaurant->logo_url" />
                                <x-button type="submit" variant="secondary" class="mt-3">Upload Logo</x-button>
                            </form>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Cover Image</h4>
                            @if($restaurant->cover_image)
                                <img src="{{ $restaurant->cover_image_url }}" 
                                     alt="Cover" 
                                     class="w-full h-32 object-cover rounded-lg mb-3">
                            @endif
                            <form action="{{ route('restaurant.profile.cover') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <x-image-upload name="cover_image" label="" :current="$restaurant->cover_image_url" />
                                <x-button type="submit" variant="secondary" class="mt-3">Upload Cover</x-button>
                            </form>
                        </div>
                    </div>
                </x-card>
            @endif

            <!-- Submit -->
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('restaurant.dashboard') }}" class="text-gray-600 hover:text-gray-900">
                    Cancel
                </a>
                <x-button type="submit" variant="primary">
                    {{ $restaurant->exists ? 'Update Profile' : 'Create Restaurant' }}
                </x-button>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Add Menu Item</h1>
            <p class="mt-2 text-gray-600">Create a new item for your menu</p>
        </div>

        <form method="POST" action="{{ route('restaurant.menu.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                <!-- Basic Information -->
                <x-card title="Basic Information">
                    <div class="space-y-6">
                        <x-select 
                            name="category_id" 
                            label="Category"
                            :options="$categories->pluck('name', 'id')->toArray()"
                            :selected="old('category_id')"
                            required />

                        <x-input 
                            name="name" 
                            label="Item Name" 
                            :value="old('name')"
                            placeholder="e.g., Margherita Pizza"
                            required />

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea 
                                name="description" 
                                rows="3"
                                class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                                placeholder="Describe your dish...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-card>

                <!-- Pricing -->
                <x-card title="Pricing">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <x-input 
                            name="price" 
                            label="Regular Price ($)" 
                            type="number"
                            step="0.01"
                            min="0"
                            :value="old('price')"
                            required />

                        <x-input 
                            name="discount_price" 
                            label="Discount Price ($)" 
                            type="number"
                            step="0.01"
                            min="0"
                            :value="old('discount_price')"
                            placeholder="Optional" />

                        <x-input 
                            name="preparation_time" 
                            label="Prep Time (minutes)" 
                            type="number"
                            min="0"
                            :value="old('preparation_time')"
                            placeholder="Optional" />
                    </div>
                </x-card>

                <!-- Image -->
                <x-card title="Image">
                    <x-image-upload name="image" label="Menu Item Photo" />
                </x-card>

                <!-- Settings -->
                <x-card title="Settings">
                    <div class="space-y-4">
                        <x-toggle-switch 
                            name="is_available" 
                            label="Available for ordering" 
                            :checked="old('is_available', true)" />

                        <x-toggle-switch 
                            name="is_featured" 
                            label="Featured item" 
                            :checked="old('is_featured', false)" />
                    </div>
                </x-card>

                <!-- Submit -->
                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('restaurant.menu.index') }}" class="text-gray-600 hover:text-gray-900">
                        Cancel
                    </a>
                    <x-button type="submit" variant="primary">Create Menu Item</x-button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

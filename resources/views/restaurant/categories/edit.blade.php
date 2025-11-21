@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Category</h1>
            <p class="mt-2 text-gray-600">Update category information</p>
        </div>

        <form method="POST" action="{{ route('restaurant.categories.update', $category) }}">
            @csrf
            @method('PUT')

            <x-card>
                <div class="space-y-6">
                    <x-input 
                        name="name" 
                        label="Category Name" 
                        :value="old('name', $category->name)"
                        required />

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea 
                            name="description" 
                            rows="3"
                            class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                            placeholder="Optional description for this category">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-toggle-switch 
                        name="is_active" 
                        label="Active" 
                        :checked="old('is_active', $category->is_active)" />
                </div>
            </x-card>

            <div class="flex items-center justify-end gap-4 mt-6">
                <a href="{{ route('restaurant.categories.index') }}" class="text-gray-600 hover:text-gray-900">
                    Cancel
                </a>
                <x-button type="submit" variant="primary">Update Category</x-button>
            </div>
        </form>
    </div>
</div>
@endsection

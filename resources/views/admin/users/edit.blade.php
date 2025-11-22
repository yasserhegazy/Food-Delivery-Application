@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <a href="{{ route('admin.users.show', $user) }}" class="text-orange-600 hover:text-orange-700 mb-4 inline-flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to User Details
        </a>
        <h1 class="text-3xl font-bold text-gray-800 mt-4">Edit User</h1>
        <p class="text-gray-600 mt-1">Update user information</p>
    </div>

    <x-card>
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <x-input 
                        id="name"
                        name="name" 
                        type="text"
                        value="{{ old('name', $user->name) }}"
                        required
                    />
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <x-input 
                        id="email"
                        name="email" 
                        type="email"
                        value="{{ old('email', $user->email) }}"
                        required
                    />
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                        Phone
                    </label>
                    <x-input 
                        id="phone"
                        name="phone" 
                        type="tel"
                        value="{{ old('phone', $user->phone) }}"
                    />
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Role --}}
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="role"
                        name="role" 
                        class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200"
                        required
                    >
                        <option value="customer" {{ old('role', $user->role) === 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="restaurant_owner" {{ old('role', $user->role) === 'restaurant_owner' ? 'selected' : '' }}>Restaurant Owner</option>
                        <option value="driver" {{ old('role', $user->role) === 'driver' ? 'selected' : '' }}>Driver</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Address --}}
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                        Address
                    </label>
                    <textarea 
                        id="address"
                        name="address" 
                        rows="2"
                        class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200"
                    >{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- City --}}
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">
                            City
                        </label>
                        <x-input 
                            id="city"
                            name="city" 
                            type="text"
                            value="{{ old('city', $user->city) }}"
                        />
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Postal Code --}}
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">
                            Postal Code
                        </label>
                        <x-input 
                            id="postal_code"
                            name="postal_code" 
                            type="text"
                            value="{{ old('postal_code', $user->postal_code) }}"
                        />
                        @error('postal_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Status --}}
                <div>
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            value="1"
                            {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-orange-600 focus:ring-orange-500"
                        >
                        <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                    @error('is_active')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-4 pt-4 border-t">
                    <x-button type="submit" variant="primary">
                        Update User
                    </x-button>
                    <a href="{{ route('admin.users.show', $user) }}">
                        <x-button type="button" variant="outline">
                            Cancel
                        </x-button>
                    </a>
                </div>
            </div>
        </form>
    </x-card>
</div>
@endsection

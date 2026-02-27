@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
        <p class="mt-2 text-gray-600">Manage your account information</p>
    </div>

    <!-- Avatar Section -->
    <x-card title="Profile Photo" class="mb-6">
        <div class="flex items-center gap-6">
            @if(auth()->user()->avatar)
                <img src="{{ filter_var(auth()->user()->avatar, FILTER_VALIDATE_URL) ? auth()->user()->avatar : asset('storage/' . auth()->user()->avatar) }}"
                     alt="{{ auth()->user()->name }}"
                     class="w-24 h-24 rounded-full object-cover border-4 border-orange-100">
            @else
                <div class="w-24 h-24 rounded-full bg-orange-500 flex items-center justify-center text-white text-3xl font-bold border-4 border-orange-100">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
            @endif

            <div>
                <form action="{{ route('customer.profile.avatar') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-3">
                    @csrf
                    <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-orange-50 text-orange-600 rounded-lg border border-orange-200 hover:bg-orange-100 transition text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Choose Photo
                        <input type="file" name="avatar" accept="image/jpeg,image/png,image/jpg" class="hidden" onchange="this.form.submit()">
                    </label>
                </form>
                <p class="text-xs text-gray-500 mt-2">JPEG, PNG or JPG. Max 2MB.</p>
                @error('avatar')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </x-card>

    <!-- Profile Form -->
    <form method="POST" action="{{ route('customer.profile.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <x-card title="Personal Information">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-input
                    name="name"
                    label="Full Name"
                    :value="old('name', $user->name)"
                    required />

                <x-input
                    name="email"
                    label="Email Address"
                    type="email"
                    :value="old('email', $user->email)"
                    disabled
                    readonly
                    class="bg-gray-100 cursor-not-allowed" />

                <x-input
                    name="phone"
                    label="Phone Number"
                    type="tel"
                    :value="old('phone', $user->phone ?? '')"
                    placeholder="e.g. +1 234 567 890" />
            </div>
        </x-card>

        <x-card title="Address Information">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <x-input
                        name="address"
                        label="Street Address"
                        :value="old('address', $user->address ?? '')"
                        placeholder="e.g. 123 Main Street" />
                </div>

                <x-input
                    name="city"
                    label="City"
                    :value="old('city', $user->city ?? '')"
                    placeholder="e.g. New York" />

                <x-input
                    name="postal_code"
                    label="Postal Code"
                    :value="old('postal_code', $user->postal_code ?? '')"
                    placeholder="e.g. 10001" />
            </div>
        </x-card>

        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('customer.dashboard') }}" class="text-gray-600 hover:text-gray-900">
                Cancel
            </a>
            <x-button type="submit" variant="primary">
                Save Changes
            </x-button>
        </div>
    </form>
</div>
@endsection

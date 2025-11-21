@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<x-card>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Create Account</h2>
        <p class="text-gray-600 mt-1">Join our food delivery platform</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <x-input
            label="Full Name"
            name="name"
            type="text"
            placeholder="Enter your full name"
            required
        />

        <x-input
            label="Email Address"
            name="email"
            type="email"
            placeholder="Enter your email"
            required
        />

        <x-input
            label="Phone Number"
            name="phone"
            type="tel"
            placeholder="Enter your phone number (optional)"
        />

        <x-select
            label="Account Type"
            name="role"
            required
            :options="[
                'customer' => 'Customer - Order food from restaurants',
                'restaurant_owner' => 'Restaurant Owner - Manage my restaurant',
                'driver' => 'Delivery Driver - Deliver orders',
            ]"
            placeholder="Select your account type"
        />

        <x-input
            label="Password"
            name="password"
            type="password"
            placeholder="Create a password (min. 8 characters)"
            required
        />

        <x-input
            label="Confirm Password"
            name="password_confirmation"
            type="password"
            placeholder="Confirm your password"
            required
        />

        <div class="mb-6 p-4 bg-gray-50 rounded-lg" x-data="{ showAddress: false }">
            <button type="button" @click="showAddress = !showAddress" class="flex items-center justify-between w-full text-left">
                <span class="text-sm font-medium text-gray-700">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Add Address (Optional)
                </span>
                <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': showAddress }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="showAddress" x-collapse class="mt-4 space-y-4">
                <x-input
                    label="Street Address"
                    name="address"
                    type="text"
                    placeholder="Enter your street address"
                />

                <div class="grid grid-cols-2 gap-4">
                    <x-input
                        label="City"
                        name="city"
                        type="text"
                        placeholder="City"
                    />

                    <x-input
                        label="Postal Code"
                        name="postal_code"
                        type="text"
                        placeholder="Postal code"
                    />
                </div>
            </div>
        </div>

        <x-button type="submit" variant="primary" class="w-full">
            Create Account
        </x-button>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600">
            Already have an account?
            <a href="{{ route('login') }}" class="text-orange-500 hover:text-orange-600 font-semibold">
                Sign in
            </a>
        </p>
    </div>
</x-card>
@endsection

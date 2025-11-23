@extends('layouts.app')

@section('title', isset($address) ? 'Edit Address' : 'Add New Address')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">
        {{ isset($address) ? 'Edit Address' : 'Add New Address' }}
    </h1>

    <x-card>
        <form action="{{ isset($address) ? route('customer.addresses.update', $address) : route('customer.addresses.store') }}" 
              method="POST">
            @csrf
            @if(isset($address))
                @method('PUT')
            @endif

            <div class="space-y-6">
                {{-- Label --}}
                <div>
                    <label for="label" class="block text-sm font-medium text-gray-700 mb-2">
                        Address Label <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="label" 
                           name="label" 
                           value="{{ old('label', $address->label ?? '') }}"
                           placeholder="e.g., Home, Work, Office"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('label') border-red-500 @enderror"
                           required>
                    @error('label')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Address Line 1 --}}
                <div>
                    <label for="address_line_1" class="block text-sm font-medium text-gray-700 mb-2">
                        Address Line 1 <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="address_line_1" 
                           name="address_line_1" 
                           value="{{ old('address_line_1', $address->address_line_1 ?? '') }}"
                           placeholder="Street address"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('address_line_1') border-red-500 @enderror"
                           required>
                    @error('address_line_1')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Address Line 2 --}}
                <div>
                    <label for="address_line_2" class="block text-sm font-medium text-gray-700 mb-2">
                        Address Line 2
                    </label>
                    <input type="text" 
                           id="address_line_2" 
                           name="address_line_2" 
                           value="{{ old('address_line_2', $address->address_line_2 ?? '') }}"
                           placeholder="Apartment, suite, etc. (optional)"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('address_line_2') border-red-500 @enderror">
                    @error('address_line_2')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- City and Zip Code --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                            City <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="city" 
                               name="city" 
                               value="{{ old('city', $address->city ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('city') border-red-500 @enderror"
                               required>
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="zip_code" class="block text-sm font-medium text-gray-700 mb-2">
                            Zip Code <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="zip_code" 
                               name="zip_code" 
                               value="{{ old('zip_code', $address->zip_code ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('zip_code') border-red-500 @enderror"
                               required>
                        @error('zip_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Default Address --}}
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="is_default" 
                           name="is_default" 
                           value="1"
                           {{ old('is_default', $address->is_default ?? false) ? 'checked' : '' }}
                           class="w-4 h-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500">
                    <label for="is_default" class="ml-2 text-sm text-gray-700">
                        Set as default address
                    </label>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-4 pt-4">
                    <x-button type="submit" variant="primary" class="flex-1">
                        {{ isset($address) ? 'Update Address' : 'Add Address' }}
                    </x-button>
                    <a href="{{ route('customer.addresses.index') }}" class="flex-1">
                        <x-button type="button" variant="secondary" class="w-full">
                            Cancel
                        </x-button>
                    </a>
                </div>
            </div>
        </form>
    </x-card>
</div>
@endsection

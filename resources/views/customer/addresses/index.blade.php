@extends('layouts.app')

@section('title', 'My Addresses')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">My Addresses</h1>
        <a href="{{ route('customer.addresses.create') }}">
            <x-button variant="primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add New Address
            </x-button>
        </a>
    </div>

    @if($addresses->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($addresses as $address)
                <x-card>
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">{{ $address->label }}</h3>
                            @if($address->is_default)
                                <span class="inline-block px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full mt-1">
                                    Default
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="text-gray-600 space-y-1 mb-4">
                        <p>{{ $address->address_line_1 }}</p>
                        @if($address->address_line_2)
                            <p>{{ $address->address_line_2 }}</p>
                        @endif
                        <p>{{ $address->city }}, {{ $address->zip_code }}</p>
                    </div>

                    <div class="flex gap-2 pt-4 border-t">
                        <a href="{{ route('customer.addresses.edit', $address) }}" class="flex-1">
                            <x-button variant="secondary" class="w-full">
                                Edit
                            </x-button>
                        </a>
                        <form action="{{ route('customer.addresses.destroy', $address) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Are you sure you want to delete this address?')"
                                    class="w-full px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg font-medium transition">
                                Delete
                            </button>
                        </form>
                    </div>
                </x-card>
            @endforeach
        </div>
    @else
        <x-card>
            <div class="text-center py-12">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No addresses yet</h3>
                <p class="text-gray-600 mb-6">Add a delivery address to place orders</p>
                <a href="{{ route('customer.addresses.create') }}">
                    <x-button variant="primary">
                        Add Your First Address
                    </x-button>
                </a>
            </div>
        </x-card>
    @endif
</div>
@endsection

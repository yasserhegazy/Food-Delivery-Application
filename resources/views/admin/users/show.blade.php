@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <a href="{{ route('admin.users.index') }}" class="text-orange-600 hover:text-orange-700 mb-4 inline-flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Users
        </a>
        <h1 class="text-3xl font-bold text-gray-800 mt-4">User Details</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- User Info --}}
        <div class="md:col-span-2">
            <x-card title="Personal Information">
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Name</label>
                        <p class="text-gray-900">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Email</label>
                        <p class="text-gray-900">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Phone</label>
                        <p class="text-gray-900">{{ $user->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Role</label>
                        <div class="mt-1">
                            <x-role-badge :role="$user->role" />
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Status</label>
                        <div class="mt-1">
                            <x-status-badge :status="$user->is_active" />
                        </div>
                    </div>
                    @if($user->address || $user->city || $user->postal_code)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Address</label>
                        <p class="text-gray-900">{{ $user->full_address }}</p>
                    </div>
                    @endif
                    <div>
                        <label class="text-sm font-medium text-gray-500">Member Since</label>
                        <p class="text-gray-900">{{ $user->created_at->format('F d, Y') }}</p>
                    </div>
                </div>
            </x-card>

            @if($user->isRestaurantOwner() && $user->restaurant)
            <x-card title="Restaurant Information" class="mt-6">
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Restaurant Name</label>
                        <p class="text-gray-900">{{ $user->restaurant->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Location</label>
                        <p class="text-gray-900">{{ $user->restaurant->city }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Status</label>
                        <div class="mt-1">
                            <x-status-badge :status="$user->restaurant->is_active" />
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('admin.restaurants.show', $user->restaurant) }}" class="text-orange-600 hover:text-orange-700">
                            View Restaurant Details →
                        </a>
                    </div>
                </div>
            </x-card>
            @endif
        </div>

        {{-- Actions --}}
        <div>
            <x-card title="Actions">
                <div class="space-y-3">
                    <a href="{{ route('admin.users.edit', $user) }}" class="block">
                        <x-button variant="primary" class="w-full">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit User
                        </x-button>
                    </a>

                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
                        @csrf
                        <x-button type="submit" variant="outline" class="w-full">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            {{ $user->is_active ? 'Deactivate' : 'Activate' }} User
                        </x-button>
                    </form>

                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <x-button type="submit" variant="outline" class="w-full text-red-600 border-red-300 hover:bg-red-50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete User
                        </x-button>
                    </form>
                    @endif
                </div>
            </x-card>
        </div>
    </div>
</div>
@endsection

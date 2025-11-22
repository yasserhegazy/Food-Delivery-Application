@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">User Management</h1>
            <p class="text-gray-600 mt-1">Manage all platform users</p>
        </div>
    </div>

    {{-- Filters --}}
    <x-card class="mb-6">
        <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <x-input 
                    name="search" 
                    placeholder="Search users..." 
                    value="{{ request('search') }}"
                />
            </div>
            <div>
                <select name="role" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200">
                    <option value="">All Roles</option>
                    <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="restaurant_owner" {{ request('role') === 'restaurant_owner' ? 'selected' : '' }}>Restaurant Owner</option>
                    <option value="driver" {{ request('role') === 'driver' ? 'selected' : '' }}>Driver</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div>
                <select name="status" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="flex gap-2">
                <x-button type="submit" variant="primary">Filter</x-button>
                <a href="{{ route('admin.users.index') }}">
                    <x-button type="button" variant="outline">Clear</x-button>
                </a>
            </div>
        </form>
    </x-card>

    {{-- Users Table --}}
    <x-card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                    <span class="text-orange-600 font-semibold">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">ID: {{ $user->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <x-role-badge :role="$user->role" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $user->email }}</div>
                            <div class="text-sm text-gray-500">{{ $user->phone ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <x-status-badge :status="$user->is_active" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-900">
                                    View
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-orange-600 hover:text-orange-900">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900">
                                        {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        Delete
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No users found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="mt-4">
            {{ $users->links() }}
        </div>
        @endif
    </x-card>
</div>
@endsection

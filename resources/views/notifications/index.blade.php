@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Notifications</h1>
        
        @if($notifications->where('read_at', null)->count() > 0)
            <form action="{{ route('notifications.readAll') }}" method="POST">
                @csrf
                <x-button type="submit" variant="secondary">
                    Mark All as Read
                </x-button>
            </form>
        @endif
    </div>

    @if($notifications->count() > 0)
        <div class="space-y-3">
            @foreach($notifications as $notification)
                <x-card class="{{ $notification->read_at ? 'bg-white' : 'bg-blue-50 border-l-4 border-blue-500' }}">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    {{ $notification->data['title'] ?? 'Notification' }}
                                </h3>
                                @if(!$notification->read_at)
                                    <span class="px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-200 rounded-full">
                                        New
                                    </span>
                                @endif
                            </div>
                            
                            <p class="text-gray-700 mb-2">
                                {{ $notification->data['message'] ?? '' }}
                            </p>
                            
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span>{{ $notification->created_at->diffForHumans() }}</span>
                                @if($notification->read_at)
                                    <span>• Read {{ $notification->read_at->diffForHumans() }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-2 ml-4">
                            @if(isset($notification->data['action_url']))
                                <a href="{{ $notification->data['action_url'] }}">
                                    <x-button variant="primary" size="sm">
                                        View
                                    </x-button>
                                </a>
                            @endif
                            
                            @if(!$notification->read_at)
                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                    @csrf
                                    <x-button type="submit" variant="secondary" size="sm">
                                        Mark as Read
                                    </x-button>
                                </form>
                            @endif
                        </div>
                    </div>
                </x-card>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    @else
        <x-card>
            <div class="text-center py-12">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No notifications</h3>
                <p class="text-gray-600">You're all caught up!</p>
            </div>
        </x-card>
    @endif
</div>
@endsection

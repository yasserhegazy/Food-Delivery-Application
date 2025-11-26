<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Food Delivery') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 font-sans antialiased" x-data="{
    notification: { show: false, type: '', message: '' },
    cartCount: {{ auth()->check() && auth()->user()->isCustomer() ? app(\App\Services\CartService::class)->getCartCount() : 0 }}
}" 
@notify.window="notification = { show: true, type: $event.detail.type, message: $event.detail.message }; setTimeout(() => notification.show = false, 3000)"
@cart-updated.window="cartCount = $event.detail">
    
    {{-- Notification Toast --}}
    <div x-show="notification.show" 
         x-transition
         class="fixed top-4 right-4 z-50 max-w-sm">
        <div :class="{
            'bg-green-500': notification.type === 'success',
            'bg-red-500': notification.type === 'error',
            'bg-blue-500': notification.type === 'info'
        }" class="text-white px-6 py-4 rounded-lg shadow-lg">
            <p x-text="notification.message"></p>
        </div>
    </div>
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                            <svg class="w-8 h-8 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                            </svg>
                            <span class="text-xl font-bold text-gray-800">FoodDelivery</span>
                        </a>
                        
                        <!-- Navigation Links -->
                        <div class="hidden md:flex md:ml-10 md:space-x-8">
                            @if(auth()->user()->isCustomer())
                                <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('customer.dashboard') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300' }}">
                                    Home
                                </a>
                                <a href="{{ route('restaurants.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('restaurants.*') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300' }}">
                                    Browse Restaurants
                                </a>
                                <a href="{{ route('customer.orders.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('customer.orders.*') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300' }}">
                                    My Orders
                                </a>
                            @elseif(auth()->user()->isRestaurantOwner())
                                <a href="{{ route('restaurant.dashboard') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('restaurant.dashboard') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300' }}">
                                    Dashboard
                                </a>
                                <a href="{{ route('restaurant.menu.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('restaurant.menu.*') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300' }}">
                                    Menu
                                </a>
                                <a href="{{ route('restaurant.categories.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('restaurant.categories.*') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300' }}">
                                    Categories
                                </a>
                                <a href="{{ route('restaurant.orders.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('restaurant.orders.*') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300' }}">
                                    Orders
                                </a>
                                <a href="{{ route('restaurant.profile.edit') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('restaurant.profile.*') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300' }}">
                                    Profile
                                </a>
                            @elseif(auth()->user()->isDriver())
                                <a href="{{ route('driver.dashboard') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 border-b-2 {{ request()->routeIs('driver.dashboard') ? 'border-orange-500' : 'border-transparent hover:border-gray-300' }}">
                                    Available Deliveries
                                </a>
                                <a href="#" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:border-gray-300">
                                    My Deliveries
                                </a>
                            @elseif(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300' }}">
                                    Dashboard
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300' }}">
                                    Users
                                </a>
                                <a href="{{ route('admin.restaurants.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('admin.restaurants.*') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300' }}">
                                    Restaurants
                                </a>
                                <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('admin.categories.*') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300' }}">
                                    Categories
                                </a>
                                <a href="{{ route('admin.menu-items.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('admin.menu-items.*') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300' }}">
                                    Menu Items
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="flex items-center gap-4">
                        @auth
                            @if(auth()->user()->isCustomer())
                                <x-cart-icon :count="app(\App\Services\CartService::class)->getCartCount()" />
                            @endif
                        @endauth
                        
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-gray-900">
                                <div class="w-8 h-8 rounded-full bg-orange-500 flex items-center justify-center text-white font-semibold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="hidden md:block">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <x-alert type="success" dismissible>
                    {{ session('success') }}
                </x-alert>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <x-alert type="error" dismissible>
                    {{ session('error') }}
                </x-alert>
            </div>
        @endif

        <!-- Page Content -->
        <main class="py-8">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <p class="text-center text-sm text-gray-500">
                    &copy; {{ date('Y') }} FoodDelivery. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
    
    @stack('scripts')
</body>
</html>

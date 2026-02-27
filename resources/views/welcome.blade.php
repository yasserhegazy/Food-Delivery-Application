<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <x-seo-meta 
            title="Craving? We Deliver" 
            description="Order delicious food from the best local restaurants with FoodExpress. Fast delivery, easy ordering, and a wide variety of cuisines at your fingertips."
            url="{{ url('/') }}" />
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans text-gray-900 bg-white">
        
        <!-- Navigation -->
        <nav x-data="{ open: false, scrolled: window.scrollY > 10 }" class="absolute w-full z-50 transition-all duration-300" :class="{ 'bg-white/90 backdrop-blur-md shadow-sm py-2': open || scrolled, 'bg-transparent py-4': !open && !scrolled }" @scroll.window="scrolled = (window.scrollY > 10)">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ url('/') }}" class="flex items-center gap-2">
                            <div class="bg-orange-500 text-white p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <span class="font-bold text-xl tracking-tight text-gray-900">Food<span class="text-orange-500">Express</span></span>
                        </a>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#" class="text-gray-700 hover:text-orange-500 font-medium transition">Home</a>
                        <a href="#restaurants" class="text-gray-700 hover:text-orange-500 font-medium transition">Restaurants</a>
                        <a href="#how-it-works" class="text-gray-700 hover:text-orange-500 font-medium transition">How it Works</a>
                        <a href="#features" class="text-gray-700 hover:text-orange-500 font-medium transition">Features</a>
                        
                        @if (Route::has('login'))
                            <div class="flex items-center gap-4 ml-4">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-orange-500 font-medium">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-500 font-medium">Log in</a>

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-full font-medium transition shadow-lg shadow-orange-500/30 transform hover:-translate-y-0.5">
                                            Sign Up
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="md:hidden flex items-center">
                        <button @click="open = !open" class="text-gray-700 hover:text-orange-500 focus:outline-none">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': !open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': !open, 'inline-flex': open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <!-- Mobile Menu -->
            <div x-show="open" 
                 @click.away="open = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="md:hidden bg-white border-t border-gray-100 shadow-xl absolute w-full left-0 top-16 z-40 rounded-b-2xl">
                <div class="px-4 pt-4 pb-6 space-y-2">
                    <a href="#" @click="open = false" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition-colors">Home</a>
                    <a href="#restaurants" @click="open = false" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition-colors">Restaurants</a>
                    <a href="#how-it-works" @click="open = false" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition-colors">How it Works</a>
                    <a href="#features" @click="open = false" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition-colors">Features</a>
                    
                    <div class="border-t border-gray-100 my-2 pt-2">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition-colors">Log in</a>
                            <a href="{{ route('register') }}" class="block w-full text-center mt-4 px-4 py-3 rounded-xl text-base font-bold text-white bg-orange-500 hover:bg-orange-600 shadow-lg shadow-orange-500/30 transition-all transform active:scale-95">
                                Sign Up
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative pt-24 pb-16 lg:pt-32 lg:pb-24 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Text Content -->
                    <div class="text-center lg:text-left">
                        <div class="inline-flex items-center px-3 py-1 rounded-full bg-orange-100 text-orange-600 text-sm font-medium mb-6 animate-fade-in-up">
                            <span class="flex h-2 w-2 rounded-full bg-orange-600 mr-2"></span>
                            #1 Food Delivery Service
                        </div>
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
                            Your Favorite Meals, <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-red-600">Delivered Fast.</span>
                        </h1>
                        <p class="text-lg sm:text-xl text-gray-600 mb-8 max-w-2xl mx-auto lg:mx-0">
                            Order from the best local restaurants and get fresh food delivered to your doorstep in minutes. Satisfy your cravings now!
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <a href="{{ route('register') }}" class="inline-flex justify-center items-center px-8 py-4 border border-transparent text-lg font-medium rounded-full text-white bg-orange-500 hover:bg-orange-600 shadow-lg shadow-orange-500/30 transition transform hover:-translate-y-1">
                                Order Now
                                <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                            <a href="#how-it-works" class="inline-flex justify-center items-center px-8 py-4 border border-gray-200 text-lg font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 transition">
                                How it Works
                            </a>
                        </div>

                        <div class="mt-10 flex items-center justify-center lg:justify-start gap-6 text-gray-500 text-sm">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Free Delivery
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Secure Payment
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                24/7 Support
                            </div>
                        </div>
                    </div>

                    <!-- Hero Image -->
                    <div class="relative lg:block">
                        <div class="absolute top-0 -right-4 -z-10 w-72 h-72 bg-orange-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                        <div class="absolute -bottom-8 right-20 -z-10 w-72 h-72 bg-yellow-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
                        <div class="absolute -bottom-8 -left-4 -z-10 w-72 h-72 bg-pink-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
                        
                        <img src="{{ asset('images/hero-food.png') }}" alt="Delicious Food Spread" class="relative rounded-3xl shadow-2xl transform hover:scale-[1.02] transition duration-500 w-full object-cover h-[500px]">
                        
                        <!-- Floating Card -->
                        <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-2xl shadow-xl flex items-center gap-4 animate-bounce-slow">
                            <div class="bg-green-100 p-3 rounded-full text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Delivery Time</p>
                                <p class="text-lg font-bold text-gray-900">25-30 min</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Restaurants Section -->
        @if(isset($featuredRestaurants) && $featuredRestaurants->count())
        <section id="restaurants" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between mb-12">
                    <div>
                        <h2 class="text-orange-500 font-semibold tracking-wide uppercase text-sm">Top Rated</h2>
                        <h3 class="mt-2 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Popular Restaurants</h3>
                        <p class="mt-3 text-lg text-gray-500">Handpicked favorites loved by our customers.</p>
                    </div>
                    <a href="{{ route('restaurants.index') }}" class="hidden sm:inline-flex items-center gap-2 text-orange-500 hover:text-orange-600 font-semibold transition group">
                        View All
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($featuredRestaurants as $restaurant)
                        <x-restaurant-card :restaurant="$restaurant" />
                    @endforeach
                </div>

                <div class="text-center mt-8 sm:hidden">
                    <a href="{{ route('restaurants.index') }}" class="inline-flex items-center gap-2 text-orange-500 hover:text-orange-600 font-semibold">
                        View All Restaurants
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>
        </section>
        @endif

        <!-- Popular Menu Items Section -->
        @if(isset($popularItems) && $popularItems->count())
        <section class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-orange-500 font-semibold tracking-wide uppercase text-sm">Most Loved</h2>
                    <h3 class="mt-2 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Trending Dishes</h3>
                    <p class="mt-3 text-lg text-gray-500 max-w-2xl mx-auto">Explore the dishes everyone is talking about.</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                    @foreach($popularItems as $item)
                    <a href="{{ route('restaurants.show', $item->category->restaurant->slug ?? '#') }}"
                       class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                        <div class="relative h-44 bg-gray-100 overflow-hidden">
                            @if($item->image_url)
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-orange-300 to-orange-500 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-white opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </div>
                            @endif
                            @if($item->has_discount)
                                <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                    SALE
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold text-gray-900 group-hover:text-orange-600 transition-colors truncate">{{ $item->name }}</h4>
                            <p class="text-xs text-gray-400 mt-1 truncate">{{ $item->category->restaurant->name ?? '' }}</p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-lg font-bold text-orange-500">${{ number_format($item->final_price, 2) }}</span>
                                @if($item->has_discount)
                                    <span class="text-sm text-gray-400 line-through">${{ number_format($item->price, 2) }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- How It Works Section -->
        <section id="how-it-works" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-orange-500 font-semibold tracking-wide uppercase text-sm">Simple Process</h2>
                    <h3 class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        How It Works
                    </h3>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                        Get your favorite food in 3 simple steps.
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition text-center group">
                        <div class="w-16 h-16 bg-orange-100 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-orange-500 group-hover:text-white transition duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">Set Location</h4>
                        <p class="text-gray-500">Select your location to see available restaurants and deals in your area.</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition text-center group">
                        <div class="w-16 h-16 bg-orange-100 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-orange-500 group-hover:text-white transition duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">Choose Menu</h4>
                        <p class="text-gray-500">Browse through hundreds of menus and choose the food you crave.</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition text-center group">
                        <div class="w-16 h-16 bg-orange-100 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-orange-500 group-hover:text-white transition duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">Fast Delivery</h4>
                        <p class="text-gray-500">Get your food delivered to your doorstep hot and fresh in no time.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div class="order-2 lg:order-1">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-4 mt-8">
                                <div class="bg-orange-50 p-6 rounded-2xl">
                                    <div class="text-3xl font-bold text-orange-500 mb-1">{{ isset($totalRestaurants) ? $totalRestaurants . '+' : '500+' }}</div>
                                    <div class="text-gray-600 font-medium">Restaurants</div>
                                </div>
                                <div class="bg-gray-50 p-6 rounded-2xl">
                                    <div class="text-3xl font-bold text-gray-900 mb-1">{{ isset($totalUsers) ? number_format($totalUsers) . '+' : '50k+' }}</div>
                                    <div class="text-gray-600 font-medium">Happy Users</div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="bg-gray-50 p-6 rounded-2xl">
                                    <div class="text-3xl font-bold text-gray-900 mb-1">{{ isset($totalOrders) ? number_format($totalOrders) . '+' : '10k+' }}</div>
                                    <div class="text-gray-600 font-medium">Orders Delivered</div>
                                </div>
                                <div class="bg-orange-500 p-6 rounded-2xl text-white">
                                    <div class="text-3xl font-bold mb-1">24/7</div>
                                    <div class="font-medium opacity-90">Support</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <h2 class="text-orange-500 font-semibold tracking-wide uppercase text-sm mb-2">Why Choose Us</h2>
                        <h3 class="text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl mb-6">
                            We are more than just a delivery service
                        </h3>
                        <p class="text-lg text-gray-500 mb-8">
                            We focus on providing the best user experience with high-quality food, fast delivery, and excellent customer support.
                        </p>
                        
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <p class="ml-3 text-lg text-gray-600">Super fast delivery within 30 minutes</p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <p class="ml-3 text-lg text-gray-600">Real-time order tracking</p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <p class="ml-3 text-lg text-gray-600">Exclusive deals and discounts</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14">
                    <h2 class="text-orange-500 font-semibold tracking-wide uppercase text-sm">Testimonials</h2>
                    <h3 class="mt-2 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">What Our Customers Say</h3>
                    <p class="mt-3 text-lg text-gray-500 max-w-2xl mx-auto">Real stories from people who love ordering with FoodExpress.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    @php
                        $testimonials = [
                            [
                                'name' => 'Sarah Johnson',
                                'initials' => 'SJ',
                                'color' => 'bg-orange-500',
                                'stars' => 5,
                                'quote' => 'FoodExpress completely changed how I order food. The delivery is always on time and the food arrives hot. My go-to app every single day!',
                            ],
                            [
                                'name' => 'Michael Chen',
                                'initials' => 'MC',
                                'color' => 'bg-blue-500',
                                'stars' => 5,
                                'quote' => 'The variety of restaurants is amazing. I discovered so many hidden gems in my neighborhood that I never knew existed. Highly recommend!',
                            ],
                            [
                                'name' => 'Emily Rodriguez',
                                'initials' => 'ER',
                                'color' => 'bg-purple-500',
                                'stars' => 4,
                                'quote' => 'Super easy to use, great tracking system, and the customer support is top-notch. This is hands down the best food delivery app I\'ve used.',
                            ],
                        ];
                    @endphp

                    @foreach($testimonials as $testimonial)
                    <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col">
                        <div class="flex items-center gap-1 mb-4">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= $testimonial['stars'] ? 'text-yellow-400' : 'text-gray-200' }} fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        <p class="text-gray-600 leading-relaxed flex-grow">"{{ $testimonial['quote'] }}"</p>
                        <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100">
                            <div class="w-10 h-10 {{ $testimonial['color'] }} text-white rounded-full flex items-center justify-center font-bold text-sm">
                                {{ $testimonial['initials'] }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $testimonial['name'] }}</p>
                                <p class="text-sm text-gray-400">Verified Customer</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- App Stats Section -->
        <section class="py-20 bg-white" x-data="{ shown: false }" x-intersect.once="shown = true">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14">
                    <h2 class="text-orange-500 font-semibold tracking-wide uppercase text-sm">Our Impact</h2>
                    <h3 class="mt-2 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Trusted by Thousands</h3>
                    <p class="mt-3 text-lg text-gray-500 max-w-2xl mx-auto">Join the growing community that relies on FoodExpress every day.</p>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="text-center p-6" x-data="{ count: 0, target: {{ $totalRestaurants ?? 0 }} }" x-effect="if(shown) { let i = setInterval(() => { count = Math.min(count + Math.ceil(target/40), target); if(count >= target) clearInterval(i); }, 30) }">
                        <div class="w-16 h-16 bg-orange-100 text-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <div class="text-4xl font-extrabold text-gray-900" x-text="count + '+'"></div>
                        <p class="text-gray-500 mt-1 font-medium">Restaurants</p>
                    </div>
                    <div class="text-center p-6" x-data="{ count: 0, target: {{ $totalUsers ?? 0 }} }" x-effect="if(shown) { let i = setInterval(() => { count = Math.min(count + Math.ceil(target/40), target); if(count >= target) clearInterval(i); }, 30) }">
                        <div class="w-16 h-16 bg-blue-100 text-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div class="text-4xl font-extrabold text-gray-900" x-text="count + '+'"></div>
                        <p class="text-gray-500 mt-1 font-medium">Happy Customers</p>
                    </div>
                    <div class="text-center p-6" x-data="{ count: 0, target: {{ $totalOrders ?? 0 }} }" x-effect="if(shown) { let i = setInterval(() => { count = Math.min(count + Math.ceil(target/40), target); if(count >= target) clearInterval(i); }, 30) }">
                        <div class="w-16 h-16 bg-green-100 text-green-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                        <div class="text-4xl font-extrabold text-gray-900" x-text="count + '+'"></div>
                        <p class="text-gray-500 mt-1 font-medium">Orders Delivered</p>
                    </div>
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-purple-100 text-purple-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="text-4xl font-extrabold text-gray-900">24/7</div>
                        <p class="text-gray-500 mt-1 font-medium">Live Support</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Ecosystem CTA Section -->
        <section class="py-20 bg-gray-900 text-white overflow-hidden relative">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <svg class="h-full w-full" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-extrabold sm:text-4xl">Join our Ecosystem</h2>
                    <p class="mt-4 text-xl text-gray-400">Whether you want to sell food or deliver it, we have a place for you.</p>
                </div>

                <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    <!-- Restaurant CTA -->
                    <div class="bg-gray-800 rounded-2xl p-8 hover:bg-gray-750 transition border border-gray-700 hover:border-orange-500 group">
                        <div class="w-14 h-14 bg-orange-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">For Restaurants</h3>
                        <p class="text-gray-400 mb-6">Partner with us and reach more customers. Manage your menu and orders easily.</p>
                        <a href="{{ route('register') }}" class="inline-flex items-center text-orange-500 font-semibold hover:text-orange-400">
                            Register as Partner <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>

                    <!-- Driver CTA -->
                    <div class="bg-gray-800 rounded-2xl p-8 hover:bg-gray-750 transition border border-gray-700 hover:border-orange-500 group">
                        <div class="w-14 h-14 bg-blue-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">For Drivers</h3>
                        <p class="text-gray-400 mb-6">Be your own boss. Earn money by delivering food on your own schedule.</p>
                        <a href="{{ route('register') }}" class="inline-flex items-center text-blue-400 font-semibold hover:text-blue-300">
                            Register as Driver <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Ready to Order CTA Section -->
        <section class="py-20 bg-gradient-to-r from-orange-500 to-red-600 text-white relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <circle cx="20" cy="20" r="30" fill="white"/>
                    <circle cx="80" cy="80" r="40" fill="white"/>
                </svg>
            </div>
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold mb-6">Ready to Order?</h2>
                <p class="text-lg sm:text-xl text-orange-100 mb-10 max-w-2xl mx-auto">
                    Explore hundreds of restaurants near you and get your favorite meals delivered in minutes.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('restaurants.index') }}" class="inline-flex justify-center items-center px-8 py-4 bg-white text-orange-600 text-lg font-bold rounded-full hover:bg-gray-100 shadow-xl transition transform hover:-translate-y-1 hover:shadow-2xl">
                        Browse Restaurants
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                    @guest
                    <a href="{{ route('register') }}" class="inline-flex justify-center items-center px-8 py-4 border-2 border-white text-white text-lg font-bold rounded-full hover:bg-white/10 transition transform hover:-translate-y-1">
                        Create Account
                    </a>
                    @endguest
                </div>
            </div>
        </section>

        <!-- Footer -->
        @include('partials.footer')
    </body>
</html>

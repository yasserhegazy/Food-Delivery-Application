<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'FoodDelivery') }} - Craving? We Deliver.</title>
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
                                    <div class="text-3xl font-bold text-orange-500 mb-1">500+</div>
                                    <div class="text-gray-600 font-medium">Restaurants</div>
                                </div>
                                <div class="bg-gray-50 p-6 rounded-2xl">
                                    <div class="text-3xl font-bold text-gray-900 mb-1">50k+</div>
                                    <div class="text-gray-600 font-medium">Happy Users</div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="bg-gray-50 p-6 rounded-2xl">
                                    <div class="text-3xl font-bold text-gray-900 mb-1">10k+</div>
                                    <div class="text-gray-600 font-medium">Daily Orders</div>
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

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 pt-16 pb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
                    <div class="col-span-2 md:col-span-1">
                        <a href="{{ url('/') }}" class="flex items-center gap-2 mb-4">
                            <div class="bg-orange-500 text-white p-1.5 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <span class="font-bold text-lg tracking-tight text-gray-900">Food<span class="text-orange-500">Express</span></span>
                        </a>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            The best way to order food from your favorite local restaurants. Fast, fresh, and reliable.
                        </p>
                    </div>
                    
                    <div>
                        <h4 class="font-bold text-gray-900 mb-4">Company</h4>
                        <ul class="space-y-2 text-sm text-gray-500">
                            <li><a href="#" class="hover:text-orange-500">About Us</a></li>
                            <li><a href="#" class="hover:text-orange-500">Careers</a></li>
                            <li><a href="#" class="hover:text-orange-500">Blog</a></li>
                            <li><a href="#" class="hover:text-orange-500">Contact</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-bold text-gray-900 mb-4">Support</h4>
                        <ul class="space-y-2 text-sm text-gray-500">
                            <li><a href="#" class="hover:text-orange-500">Help Center</a></li>
                            <li><a href="#" class="hover:text-orange-500">Terms of Service</a></li>
                            <li><a href="#" class="hover:text-orange-500">Privacy Policy</a></li>
                            <li><a href="#" class="hover:text-orange-500">Cookie Policy</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-bold text-gray-900 mb-4">Follow Us</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-orange-500 transition">
                                <span class="sr-only">Facebook</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-orange-500 transition">
                                <span class="sr-only">Twitter</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-orange-500 transition">
                                <span class="sr-only">Instagram</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.468 2.37c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center">
                    <p class="text-sm text-gray-400">&copy; {{ date('Y') }} FoodExpress. All rights reserved.</p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-sm text-gray-400 hover:text-gray-600">Privacy</a>
                        <a href="#" class="text-sm text-gray-400 hover:text-gray-600">Terms</a>
                        <a href="#" class="text-sm text-gray-400 hover:text-gray-600">Sitemap</a>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>

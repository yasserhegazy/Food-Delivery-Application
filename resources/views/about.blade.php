<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'FoodExpress') }} - About Us</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased font-sans text-gray-900 bg-white">

    <!-- Navigation -->
    <nav x-data="{ open: false, scrolled: window.scrollY > 10 }" class="fixed w-full z-50 transition-all duration-300 bg-white/90 backdrop-blur-md shadow-sm" @scroll.window="scrolled = (window.scrollY > 10)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
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
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ url('/') }}" class="text-gray-700 hover:text-orange-500 font-medium transition">Home</a>
                    <a href="{{ url('/restaurants') }}" class="text-gray-700 hover:text-orange-500 font-medium transition">Restaurants</a>
                    <a href="{{ url('/about') }}" class="text-orange-500 font-medium transition">About</a>
                    <a href="{{ url('/contact') }}" class="text-gray-700 hover:text-orange-500 font-medium transition">Contact</a>
                    @if (Route::has('login'))
                        <div class="flex items-center gap-4 ml-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-orange-500 font-medium">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-500 font-medium">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-full font-medium transition shadow-lg shadow-orange-500/30">Sign Up</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
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
        <div x-show="open" @click.away="open = false" x-transition class="md:hidden bg-white border-t border-gray-100 shadow-xl absolute w-full left-0 top-16 z-40 rounded-b-2xl">
            <div class="px-4 pt-4 pb-6 space-y-2">
                <a href="{{ url('/') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition-colors">Home</a>
                <a href="{{ url('/restaurants') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition-colors">Restaurants</a>
                <a href="{{ url('/about') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-orange-500 bg-orange-50">About</a>
                <a href="{{ url('/contact') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition-colors">Contact</a>
                <div class="border-t border-gray-100 my-2 pt-2">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition-colors">Log in</a>
                        <a href="{{ route('register') }}" class="block w-full text-center mt-4 px-4 py-3 rounded-xl text-base font-bold text-white bg-orange-500 hover:bg-orange-600 shadow-lg shadow-orange-500/30 transition-all">Sign Up</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-orange-50 via-white to-red-50"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto">
                <div class="inline-flex items-center px-3 py-1 rounded-full bg-orange-100 text-orange-600 text-sm font-medium mb-6">
                    <span class="flex h-2 w-2 rounded-full bg-orange-500 mr-2"></span>
                    Our Story
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
                    About <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-red-600">FoodExpress</span>
                </h1>
                <p class="text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto">
                    We're on a mission to connect food lovers with the best local restaurants, delivering happiness one meal at a time.
                </p>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Mission</h2>
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                        At FoodExpress, we believe that great food should be accessible to everyone. Our platform bridges the gap between talented local chefs and hungry customers, creating a seamless experience that celebrates the joy of eating well.
                    </p>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        We're committed to supporting local restaurants, empowering delivery drivers, and ensuring every customer receives their meal fresh, fast, and with a smile.
                    </p>
                    <div class="mt-8 flex gap-4">
                        <a href="{{ url('/restaurants') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-full font-semibold transition shadow-lg shadow-orange-500/30">
                            Browse Restaurants
                        </a>
                        <a href="{{ url('/contact') }}" class="border-2 border-gray-200 hover:border-orange-500 text-gray-700 hover:text-orange-500 px-6 py-3 rounded-full font-semibold transition">
                            Get in Touch
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="rounded-2xl overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=600&h=400&fit=crop" alt="Delicious food spread" class="w-full h-80 object-cover">
                    </div>
                    <div class="absolute -bottom-6 -left-6 bg-orange-500 text-white p-6 rounded-2xl shadow-xl">
                        <p class="text-3xl font-bold">5+</p>
                        <p class="text-sm font-medium opacity-90">Years of Service</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Story</h2>
                <div class="w-20 h-1 bg-orange-500 mx-auto rounded-full mb-8"></div>
            </div>
            <div class="max-w-4xl mx-auto">
                <div class="grid md:grid-cols-2 gap-12">
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">The Beginning (2020)</h3>
                        <p class="text-gray-600 leading-relaxed">
                            FoodExpress started in a small apartment when three friends noticed how difficult it was for local restaurants to reach new customers. Armed with a laptop and a passion for great food, they built the first version of our platform.
                        </p>
                    </div>
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Growing Fast (2022)</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Within two years, we expanded to 15 cities and partnered with over 500 restaurants. Our commitment to quality and fast delivery earned us a loyal customer base and recognition as one of the top food delivery startups.
                        </p>
                    </div>
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Building Community (2024)</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Today, FoodExpress isn't just a delivery app — it's a community. We support local restaurant owners, provide flexible work for delivery drivers, and bring diverse cuisines to doorsteps everywhere.
                        </p>
                    </div>
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">The Future</h3>
                        <p class="text-gray-600 leading-relaxed">
                            We're constantly innovating — from AI-powered recommendations to eco-friendly packaging. Our vision is to make food delivery sustainable, affordable, and delightful for everyone.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 bg-gradient-to-r from-orange-500 to-red-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center text-white">
                <div>
                    <p class="text-4xl md:text-5xl font-extrabold mb-2">500+</p>
                    <p class="text-orange-100 font-medium">Restaurant Partners</p>
                </div>
                <div>
                    <p class="text-4xl md:text-5xl font-extrabold mb-2">25+</p>
                    <p class="text-orange-100 font-medium">Cities Served</p>
                </div>
                <div>
                    <p class="text-4xl md:text-5xl font-extrabold mb-2">1M+</p>
                    <p class="text-orange-100 font-medium">Orders Delivered</p>
                </div>
                <div>
                    <p class="text-4xl md:text-5xl font-extrabold mb-2">50K+</p>
                    <p class="text-orange-100 font-medium">Happy Customers</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Meet Our Team</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">The passionate people behind FoodExpress who work tirelessly to bring you the best food delivery experience.</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                    $team = [
                        ['name' => 'Sarah Chen', 'role' => 'CEO & Co-Founder', 'initials' => 'SC', 'color' => 'bg-orange-500', 'bio' => 'Former chef turned tech entrepreneur with a vision to transform food delivery.'],
                        ['name' => 'Marcus Johnson', 'role' => 'CTO & Co-Founder', 'initials' => 'MJ', 'color' => 'bg-red-500', 'bio' => 'Full-stack developer who built the first version of FoodExpress in a weekend hackathon.'],
                        ['name' => 'Aisha Patel', 'role' => 'Head of Operations', 'initials' => 'AP', 'color' => 'bg-amber-500', 'bio' => 'Logistics expert ensuring every delivery arrives on time, every single time.'],
                        ['name' => 'David Kim', 'role' => 'Head of Design', 'initials' => 'DK', 'color' => 'bg-rose-500', 'bio' => 'Award-winning designer creating intuitive experiences for millions of users.'],
                    ];
                @endphp
                @foreach($team as $member)
                    <div class="text-center group">
                        <div class="relative inline-block mb-6">
                            <div class="w-28 h-28 {{ $member['color'] }} rounded-full flex items-center justify-center text-white text-3xl font-bold mx-auto shadow-lg group-hover:shadow-xl transition-shadow">
                                {{ $member['initials'] }}
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $member['name'] }}</h3>
                        <p class="text-orange-500 font-medium text-sm mb-3">{{ $member['role'] }}</p>
                        <p class="text-gray-500 text-sm leading-relaxed">{{ $member['bio'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Values</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Everything we do is guided by these core principles.</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white rounded-2xl p-8 text-center shadow-sm border border-gray-100 hover:shadow-md hover:border-orange-200 transition-all">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Fresh Food</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">We partner only with restaurants that meet our strict quality and freshness standards.</p>
                </div>
                <div class="bg-white rounded-2xl p-8 text-center shadow-sm border border-gray-100 hover:shadow-md hover:border-orange-200 transition-all">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Fast Delivery</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Our optimized routing and dedicated drivers ensure your food arrives hot and on time.</p>
                </div>
                <div class="bg-white rounded-2xl p-8 text-center shadow-sm border border-gray-100 hover:shadow-md hover:border-orange-200 transition-all">
                    <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Customer First</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Your satisfaction is our priority. Our support team is always ready to help.</p>
                </div>
                <div class="bg-white rounded-2xl p-8 text-center shadow-sm border border-gray-100 hover:shadow-md hover:border-orange-200 transition-all">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Local Restaurants</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">We champion local businesses, helping them grow and reach new customers every day.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Ready to Order?</h2>
            <p class="text-lg text-gray-600 mb-8">Join thousands of food lovers who trust FoodExpress for their daily meals.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ url('/restaurants') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-full font-semibold text-lg transition shadow-lg shadow-orange-500/30">
                    Explore Restaurants
                </a>
                <a href="{{ url('/contact') }}" class="border-2 border-gray-200 hover:border-orange-500 text-gray-700 hover:text-orange-500 px-8 py-4 rounded-full font-semibold text-lg transition">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('partials.footer')

</body>
</html>

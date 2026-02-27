<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'FoodExpress') }} - Contact Us</title>
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
                    <a href="{{ url('/about') }}" class="text-gray-700 hover:text-orange-500 font-medium transition">About</a>
                    <a href="{{ url('/contact') }}" class="text-orange-500 font-medium transition">Contact</a>
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
                <a href="{{ url('/about') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition-colors">About</a>
                <a href="{{ url('/contact') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-orange-500 bg-orange-50">Contact</a>
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
    <section class="relative pt-32 pb-16 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-orange-50 via-white to-red-50"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto">
                <div class="inline-flex items-center px-3 py-1 rounded-full bg-orange-100 text-orange-600 text-sm font-medium mb-6">
                    <span class="flex h-2 w-2 rounded-full bg-orange-500 mr-2"></span>
                    We'd Love to Hear From You
                </div>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 leading-tight mb-6">
                    Contact <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-red-600">Us</span>
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Have a question, suggestion, or just want to say hello? We're here to help and would love to hear from you.
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Form + Sidebar -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-12">
                <!-- Contact Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Send Us a Message</h2>

                        @if(session('success'))
                            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-medium">{{ session('success') }}</span>
                            </div>
                        @endif

                        <form action="{{ url('/contact') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid sm:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition placeholder-gray-400"
                                        placeholder="John Doe">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition placeholder-gray-400"
                                        placeholder="john@example.com">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">Subject</label>
                                <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition placeholder-gray-400"
                                    placeholder="How can we help?">
                                @error('subject')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Message</label>
                                <textarea name="message" id="message" rows="5" required
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition placeholder-gray-400 resize-none"
                                    placeholder="Tell us more about your inquiry...">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="w-full sm:w-auto bg-orange-500 hover:bg-orange-600 text-white px-8 py-3.5 rounded-xl font-semibold transition shadow-lg shadow-orange-500/30 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <!-- Contact Info -->
                    <div class="bg-gray-50 rounded-2xl p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Get in Touch</h3>
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Email</p>
                                    <p class="text-sm text-gray-600">support@foodexpress.com</p>
                                    <p class="text-sm text-gray-600">hello@foodexpress.com</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Phone</p>
                                    <p class="text-sm text-gray-600">+1 (555) 123-4567</p>
                                    <p class="text-sm text-gray-600">Mon-Fri, 9am - 6pm EST</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Address</p>
                                    <p class="text-sm text-gray-600">123 Food Street, Suite 400</p>
                                    <p class="text-sm text-gray-600">San Francisco, CA 94105</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Map Placeholder -->
                    <div class="rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                        <img src="https://images.unsplash.com/photo-1449824913935-59a10b8d2000?w=400&h=250&fit=crop" alt="San Francisco cityscape" class="w-full h-48 object-cover">
                        <div class="bg-gray-50 px-6 py-4">
                            <p class="text-sm font-semibold text-gray-900">Our Headquarters</p>
                            <p class="text-xs text-gray-500">San Francisco, California</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
                <p class="text-lg text-gray-600">Quick answers to questions you may have.</p>
            </div>

            <div class="space-y-4" x-data="{ active: null }">
                @php
                    $faqs = [
                        [
                            'question' => 'How do I place an order?',
                            'answer' => 'Simply browse our restaurant listings, select your favorite dishes, add them to your cart, and proceed to checkout. You can pay online or choose cash on delivery.'
                        ],
                        [
                            'question' => 'What are the delivery fees?',
                            'answer' => 'Delivery fees vary based on the distance between the restaurant and your location. Most deliveries range from $2.99 to $5.99. Orders over $30 may qualify for free delivery!'
                        ],
                        [
                            'question' => 'How long does delivery take?',
                            'answer' => 'Average delivery time is 25-45 minutes depending on the restaurant, your location, and current demand. You can track your order in real-time once it\'s been placed.'
                        ],
                        [
                            'question' => 'Can I cancel or modify my order?',
                            'answer' => 'You can cancel or modify your order within 5 minutes of placing it. After the restaurant starts preparing your food, cancellations may not be possible. Contact our support team for assistance.'
                        ],
                        [
                            'question' => 'How do I become a restaurant partner?',
                            'answer' => 'We\'d love to have you on board! Visit our partner registration page or contact us at partners@foodexpress.com. Our team will guide you through the onboarding process.'
                        ],
                    ];
                @endphp

                @foreach($faqs as $index => $faq)
                    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
                        <button @click="active = active === {{ $index }} ? null : {{ $index }}"
                            class="w-full flex items-center justify-between px-6 py-5 text-left focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-inset rounded-2xl">
                            <span class="text-base font-semibold text-gray-900">{{ $faq['question'] }}</span>
                            <svg class="w-5 h-5 text-gray-400 transition-transform duration-200 flex-shrink-0 ml-4"
                                :class="{ 'rotate-180': active === {{ $index }} }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="active === {{ $index }}"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-1"
                            x-cloak>
                            <div class="px-6 pb-5 text-gray-600 leading-relaxed">
                                {{ $faq['answer'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('partials.footer')

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | FoodExpress</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-lg mx-auto px-6 py-16 text-center">
        <!-- Illustration -->
        <div class="mb-8">
            <div class="relative inline-block">
                <div class="w-40 h-40 bg-orange-100 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-24 h-24 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <div class="absolute -top-2 -right-2 w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg">
                    ?
                </div>
            </div>
        </div>

        <h1 class="text-7xl font-extrabold text-orange-500 mb-4">404</h1>
        <h2 class="text-2xl font-bold text-gray-900 mb-3">Page Not Found</h2>
        <p class="text-gray-600 mb-8 leading-relaxed">
            Oops! Looks like this page went out for delivery and never came back. 
            The page you're looking for doesn't exist or has been moved.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ url('/') }}" 
               class="inline-flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-3 rounded-xl transition-all shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Go Home
            </a>
            <a href="{{ url('/restaurants') }}" 
               class="inline-flex items-center justify-center gap-2 bg-white hover:bg-gray-50 text-gray-700 font-semibold px-6 py-3 rounded-xl transition-all border-2 border-gray-200 hover:border-orange-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Browse Restaurants
            </a>
        </div>
    </div>
</body>
</html>

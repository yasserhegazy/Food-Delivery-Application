<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Forbidden | FoodExpress</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-lg mx-auto px-6 py-16 text-center">
        <div class="mb-8">
            <div class="w-40 h-40 bg-red-100 rounded-full flex items-center justify-center mx-auto">
                <svg class="w-24 h-24 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v.01M12 12v-4m0 0a1 1 0 100-2 1 1 0 000 2zm-7 8h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>

        <h1 class="text-7xl font-extrabold text-red-500 mb-4">403</h1>
        <h2 class="text-2xl font-bold text-gray-900 mb-3">Access Forbidden</h2>
        <p class="text-gray-600 mb-8 leading-relaxed">
            Sorry, you don't have permission to access this page. 
            This area is restricted to authorized users only.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ url('/') }}" 
               class="inline-flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-3 rounded-xl transition-all shadow-lg shadow-orange-500/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Go Home
            </a>
            <button onclick="history.back()" 
                    class="inline-flex items-center justify-center gap-2 bg-white hover:bg-gray-50 text-gray-700 font-semibold px-6 py-3 rounded-xl transition-all border-2 border-gray-200 hover:border-orange-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Go Back
            </button>
        </div>
    </div>
</body>
</html>

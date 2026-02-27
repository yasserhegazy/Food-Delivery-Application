@props([
    'title' => 'FoodExpress',
    'description' => 'Order delicious food from the best local restaurants. Fast delivery, easy ordering, and a wide variety of cuisines at your fingertips.',
    'image' => asset('images/hero-food.png'),
    'url' => url()->current(),
    'type' => 'website',
])

<title>{{ config('app.name', 'FoodExpress') }} - {{ $title }}</title>
<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ $url }}">

<!-- Open Graph -->
<meta property="og:title" content="{{ $title }} - {{ config('app.name', 'FoodExpress') }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $image }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:type" content="{{ $type }}">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }} - {{ config('app.name', 'FoodExpress') }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $image }}">

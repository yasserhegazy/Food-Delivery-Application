@props(['restaurant'])

<a href="{{ route('restaurants.show', $restaurant->slug) }}" 
   class="group block bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
    
    <!-- Cover Image -->
    <div class="relative h-48 bg-gray-200 overflow-hidden">
        @if($restaurant->cover_image)
            <img src="{{ asset('storage/' . $restaurant->cover_image) }}" 
                 alt="{{ $restaurant->name }}" 
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
        @else
            <div class="w-full h-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center">
                <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
        @endif
        
        <!-- Status Badge -->
        @if(!$restaurant->is_active)
            <div class="absolute top-3 right-3 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                Closed
            </div>
        @elseif($restaurant->is_open)
            <div class="absolute top-3 right-3 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold flex items-center gap-1">
                <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                Open Now
            </div>
        @endif
        
        <!-- Logo -->
        @if($restaurant->logo)
            <div class="absolute -bottom-6 left-4 w-16 h-16 bg-white rounded-xl shadow-lg border-2 border-white overflow-hidden">
                <img src="{{ asset('storage/' . $restaurant->logo) }}" 
                     alt="{{ $restaurant->name }} logo" 
                     class="w-full h-full object-cover">
            </div>
        @endif
    </div>
    
    <!-- Content -->
    <div class="p-4 {{ $restaurant->logo ? 'pt-8' : 'pt-4' }}">
        <h3 class="text-lg font-bold text-gray-900 group-hover:text-orange-600 transition-colors">
            {{ $restaurant->name }}
        </h3>
        
        @if($restaurant->description)
            <p class="text-sm text-gray-600 mt-1 line-clamp-2">
                {{ $restaurant->description }}
            </p>
        @endif
        
        <!-- Meta Info -->
        <div class="flex items-center gap-4 mt-3 text-sm text-gray-500">
            <!-- Rating -->
            <div class="flex items-center gap-1">
                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <span class="font-medium text-gray-900">{{ number_format($restaurant->rating, 1) }}</span>
                <span>({{ $restaurant->total_reviews }})</span>
            </div>
            
            <!-- Delivery Time -->
            @if($restaurant->delivery_time)
                <div class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ $restaurant->delivery_time }} min</span>
                </div>
            @endif
            
            <!-- Delivery Fee -->
            <div class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ $restaurant->delivery_fee > 0 ? '$' . number_format($restaurant->delivery_fee, 2) : 'Free' }}</span>
            </div>
        </div>
    </div>
</a>

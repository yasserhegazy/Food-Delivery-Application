@props(['item'])

<div x-data="{ showModal: false }" class="group bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden animate-fade-in-up">
    <!-- Image -->
    <div class="relative h-48 bg-gray-200 overflow-hidden">
        @if($item->image)
            <img src="{{ $item->image_url }}" 
                 alt="{{ $item->name }}" 
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
        @else
            <div class="w-full h-full bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </div>
        @endif
        
        <!-- Badges -->
        <div class="absolute top-2 left-2 flex flex-col gap-2">
            @if($item->is_featured)
                <span class="bg-orange-500 text-white px-2 py-1 rounded-full text-xs font-semibold flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    Featured
                </span>
            @endif
            
            @if($item->has_discount)
                <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                    {{ round((($item->price - $item->discount_price) / $item->price) * 100) }}% OFF
                </span>
            @endif
        </div>
        
        @if(!$item->is_available)
            <div class="absolute inset-0 bg-gray-900 bg-opacity-60 flex items-center justify-center">
                <span class="bg-white text-gray-900 px-4 py-2 rounded-full font-semibold">
                    Unavailable
                </span>
            </div>
        @endif
    </div>
    
    <!-- Content -->
    <div class="p-4">
        <h4 class="font-bold text-gray-900 dark:text-white group-hover:text-orange-600 transition-colors">
            {{ $item->name }}
        </h4>
        
        @if($item->description)
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">
                {{ $item->description }}
            </p>
        @endif
        
        <!-- Price & Actions -->
        <div class="flex items-center justify-between mt-3">
            <div class="flex items-baseline gap-2">
                @if($item->has_discount)
                    <span class="text-lg font-bold text-orange-600">
                        ${{ number_format($item->final_price, 2) }}
                    </span>
                    <span class="text-sm text-gray-400 line-through">
                        ${{ number_format($item->price, 2) }}
                    </span>
                @else
                    <span class="text-lg font-bold text-gray-900 dark:text-white">
                        ${{ number_format($item->price, 2) }}
                    </span>
                @endif
            </div>
            
            @if($item->is_available)
                @auth
                    @if(auth()->user()->isCustomer())
                        <button @click="showModal = true"
                            type="button"
                            class="bg-orange-500 hover:bg-orange-600 text-white p-2 rounded-full transition-all transform hover:scale-110 shadow-lg shadow-orange-500/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </button>
                    @endif
                @else
                    <a href="{{ route('login') }}" 
                       class="bg-orange-500 hover:bg-orange-600 text-white p-2 rounded-full transition-all transform hover:scale-110 shadow-lg shadow-orange-500/30 inline-block">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </a>
                @endauth
            @endif
        </div>
        
        @if($item->preparation_time)
            <div class="flex items-center gap-1 mt-2 text-xs text-gray-500 dark:text-gray-400">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ $item->preparation_time }} min</span>
            </div>
        @endif
    </div>

    <!-- Add to Cart Modal -->
    @auth
        @if(auth()->user()->isCustomer() && $item->is_available)
            <div x-show="showModal" 
                 x-cloak
                 @click.away="showModal = false"
                 class="fixed inset-0 z-50 overflow-y-auto"
                 style="display: none;">
                <div class="flex items-center justify-center min-h-screen px-4">
                    <div class="fixed inset-0 bg-black opacity-50"></div>
                    
                    <div class="relative bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full p-6 shadow-2xl">
                        <button @click="showModal = false" 
                                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ $item->name }}</h3>
                        
                        @if($item->image)
                            <img src="{{ $item->image_url }}" 
                                 alt="{{ $item->name }}"
                                 class="w-full h-48 object-cover rounded-lg mb-4">
                        @endif
                        
                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $item->description }}</p>
                        
                        <div class="mb-6">
                            <span class="text-2xl font-bold text-orange-600">
                                ${{ number_format($item->final_price, 2) }}
                            </span>
                        </div>
                        
                        <x-add-to-cart-button :menuItem="$item" />
                    </div>
                </div>
            </div>
        @endif
    @endauth
</div>

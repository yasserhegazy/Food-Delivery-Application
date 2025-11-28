@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Restaurant Header -->
    <div class="relative h-64 bg-gray-200">
        @if($restaurant->cover_image)
            <img src="{{ asset('storage/' . $restaurant->cover_image) }}" 
                 alt="{{ $restaurant->name }}" 
                 class="w-full h-full object-cover">
        @else
            <div class="w-full h-full bg-gradient-to-br from-orange-400 to-orange-600"></div>
        @endif
        
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 relative z-10">
        <!-- Restaurant Info Card -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
            <div class="flex items-start gap-6">
                @if($restaurant->logo)
                    <img src="{{ asset('storage/' . $restaurant->logo) }}" 
                         alt="{{ $restaurant->name }} logo" 
                         class="w-24 h-24 rounded-xl shadow-lg object-cover flex-shrink-0">
                @endif

                <div class="flex-1">
                    <div class="flex items-start justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $restaurant->name }}</h1>
                            <p class="text-gray-600 mt-2">{{ $restaurant->description }}</p>
                        </div>

                        @if($restaurant->is_open)
                            <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold flex items-center gap-2">
                                <span class="w-2 h-2 bg-green-600 rounded-full animate-pulse"></span>
                                Open Now
                            </span>
                        @else
                            <span class="bg-red-100 text-red-800 px-4 py-2 rounded-full text-sm font-semibold">
                                Closed
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                        <div class="flex items-center gap-2 text-gray-600">
                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span class="font-semibold">{{ number_format($restaurant->rating, 1) }}</span>
                            <span class="text-sm">({{ $restaurant->total_reviews }})</span>
                        </div>

                        <div class="flex items-center gap-2 text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $restaurant->delivery_time }} min</span>
                        </div>

                        <div class="flex items-center gap-2 text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Min: ${{ number_format($restaurant->minimum_order, 2) }}</span>
                        </div>

                        <div class="flex items-center gap-2 text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <span>{{ $restaurant->delivery_fee > 0 ? '$' . number_format($restaurant->delivery_fee, 2) : 'Free' }} delivery</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Rating Section --}}
        @auth
            @if(auth()->user()->isCustomer())
                <div class="bg-white rounded-2xl shadow-sm p-6 mb-8">
                    @php
                        $userRating = $restaurant->ratings()->where('user_id', auth()->id())->first();
                    @endphp
                    
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">
                        {{ $userRating ? 'Your Rating' : 'Rate this Restaurant' }}
                    </h2>
                    
                    <x-rating-form :restaurant="$restaurant" :userRating="$userRating" />
                </div>
            @endif
        @endauth

        <!-- Menu Section with AJAX Tabs -->
        <div class="pb-12" x-data="menuManager({{ $restaurant->categories->first()->id ?? 'null' }}, {{ $restaurant->categories->first() && $restaurant->categories->first()->menuItems()->available()->count() > 12 ? 'true' : 'false' }})">
            @if($restaurant->categories->count() > 0)
                <!-- Category Tabs -->
                <div class="bg-white rounded-xl shadow-sm p-4 mb-6 sticky top-4 z-20">
                    <div class="flex items-center gap-4 overflow-x-auto pb-2 scrollbar-hide">
                        @foreach($restaurant->categories as $category)
                            <button 
                                @click="switchCategory({{ $category->id }})"
                                :class="activeCategory === {{ $category->id }} ? 'bg-orange-500 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                                class="px-6 py-2.5 rounded-full font-medium whitespace-nowrap transition-all duration-200">
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Menu Items Container -->
                <div class="min-h-[400px]">
                    @foreach($restaurant->categories as $index => $category)
                        <div x-show="activeCategory === {{ $category->id }}" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-4"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             style="display: none;">
                            
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h2>
                                <span class="text-sm text-gray-500">{{ $category->description }}</span>
                            </div>

                            {{-- Container for items --}}
                            <div id="category-content-{{ $category->id }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                                {{-- First category loaded by default server-side (limited to 12) --}}
                                @if($index === 0)
                                    @foreach($category->menuItems()->available()->ordered()->take(12)->get() as $item)
                                        <x-menu-item-card :item="$item" />
                                    @endforeach
                                @endif
                            </div>

                            {{-- Load More Button --}}
                            <div x-show="categoryStates[{{ $category->id }}]?.hasMore" class="flex justify-center pb-8">
                                <button 
                                    @click="loadMore({{ $category->id }})"
                                    :disabled="categoryStates[{{ $category->id }}]?.isLoadingMore"
                                    class="px-6 py-3 bg-white border border-gray-300 rounded-full text-gray-700 font-medium hover:bg-gray-50 hover:text-orange-600 transition flex items-center gap-2 shadow-sm">
                                    <span x-show="!categoryStates[{{ $category->id }}]?.isLoadingMore">Load More Items</span>
                                    <span x-show="categoryStates[{{ $category->id }}]?.isLoadingMore" class="flex items-center">
                                        <svg class="animate-spin h-5 w-5 mr-2 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Loading...
                                    </span>
                                </button>
                            </div>

                            {{-- Initial Loading State --}}
                            <div x-show="isLoading && !categoryStates[{{ $category->id }}]?.loaded" class="flex justify-center py-12">
                                <svg class="animate-spin h-10 w-10 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <x-empty-state 
                    title="No menu available"
                    message="This restaurant hasn't added any menu items yet. Please check back later!"
                    icon="document" />
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function menuManager(initialCategoryId, initialHasMore) {
    return {
        activeCategory: initialCategoryId,
        isLoading: false,
        categoryStates: {
            [initialCategoryId]: {
                loaded: true,
                page: 1,
                hasMore: initialHasMore,
                isLoadingMore: false
            }
        },

        async switchCategory(categoryId) {
            this.activeCategory = categoryId;

            // Initialize state if not exists
            if (!this.categoryStates[categoryId]) {
                this.categoryStates[categoryId] = {
                    loaded: false,
                    page: 0,
                    hasMore: false,
                    isLoadingMore: false
                };
            }

            // If already loaded, do nothing
            if (this.categoryStates[categoryId].loaded) {
                return;
            }

            // Fetch items (page 1)
            this.isLoading = true;
            await this.fetchItems(categoryId, 1);
            this.isLoading = false;
        },

        async loadMore(categoryId) {
            const state = this.categoryStates[categoryId];
            if (state.isLoadingMore || !state.hasMore) return;

            state.isLoadingMore = true;
            await this.fetchItems(categoryId, state.page + 1);
            state.isLoadingMore = false;
        },

        async fetchItems(categoryId, page) {
            try {
                const response = await fetch(`{{ route('restaurants.category-items', ['restaurant' => $restaurant->id, 'category' => ':categoryId']) }}?page=${page}`.replace(':categoryId', categoryId));
                const data = await response.json();

                if (data.success) {
                    const container = document.getElementById(`category-content-${categoryId}`);
                    
                    if (page === 1) {
                        container.innerHTML = data.html;
                    } else {
                        // Create a temporary container to hold new HTML
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = data.html;
                        
                        // Append children to main container
                        while (tempDiv.firstChild) {
                            container.appendChild(tempDiv.firstChild);
                        }
                    }
                    
                    // Update state
                    this.categoryStates[categoryId].loaded = true;
                    this.categoryStates[categoryId].page = page;
                    this.categoryStates[categoryId].hasMore = data.hasMore;

                    // Initialize Alpine components
                    this.$nextTick(() => {
                        if (window.Alpine) {
                            // We need to be careful not to re-init existing components if appending
                            // But initTree usually handles this safely or we can init specific new elements
                            // For simplicity, re-scanning the container is usually fine in v3
                            window.Alpine.initTree(container);
                        }
                    });
                }
            } catch (error) {
                console.error('Error loading category items:', error);
            }
        }
    }
}
</script>
@endpush
@endsection



<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 py-8" x-data="restaurantSearch()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Discover Restaurants</h1>
            <p class="mt-2 text-lg text-gray-600">Find your favorite meals from local restaurants</p>
        </div>

        
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <form @submit.prevent="performSearch" class="space-y-6">
                
                <div class="relative">
                    <input 
                        type="text" 
                        x-model="filters.search"
                        @input.debounce.300ms="performSearch"
                        placeholder="Search for restaurants, cuisines, or dishes..."
                        class="w-full px-6 py-4 text-lg border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all pl-14">
                    <svg class="w-6 h-6 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                
                <div class="lg:hidden">
                    <button 
                        type="button"
                        @click="showFilters = !showFilters"
                        class="w-full flex items-center justify-between px-4 py-3 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                        <span class="font-medium text-gray-700">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Filters
                        </span>
                        <span x-show="activeFilterCount > 0" class="bg-orange-500 text-white px-2 py-1 rounded-full text-sm" x-text="activeFilterCount"></span>
                    </button>
                </div>

                
                <div x-show="showFilters" x-transition class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cuisine Type</label>
                        <select 
                            x-model="filters.cuisine"
                            @change="performSearch"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">All Cuisines</option>
                            <?php $__currentLoopData = $cuisines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cuisine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cuisine); ?>"><?php echo e($cuisine); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                        <select 
                            x-model="filters.city"
                            @change="performSearch"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">All Cities</option>
                            <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($city); ?>"><?php echo e($city); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                        <select 
                            x-model="filters.price_range"
                            @change="performSearch"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">Any Price</option>
                            <option value="$">$ - Budget Friendly</option>
                            <option value="$$">$$ - Moderate</option>
                            <option value="$$$">$$$ - Upscale</option>
                            <option value="$$$$">$$$$ - Fine Dining</option>
                        </select>
                    </div>

                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Rating</label>
                        <select 
                            x-model="filters.min_rating"
                            @change="performSearch"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">Any Rating</option>
                            <option value="4.5">⭐ 4.5+ Stars</option>
                            <option value="4.0">⭐ 4.0+ Stars</option>
                            <option value="3.5">⭐ 3.5+ Stars</option>
                            <option value="3.0">⭐ 3.0+ Stars</option>
                        </select>
                    </div>

                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Fee</label>
                        <select 
                            x-model="filters.delivery_fee"
                            @change="performSearch"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">Any Fee</option>
                            <option value="free">Free Delivery</option>
                            <option value="5">Under $5</option>
                            <option value="10">Under $10</option>
                        </select>
                    </div>

                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Time</label>
                        <select 
                            x-model="filters.delivery_time"
                            @change="performSearch"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">Any Time</option>
                            <option value="15">Under 15 min</option>
                            <option value="30">Under 30 min</option>
                            <option value="45">Under 45 min</option>
                            <option value="60">Under 1 hour</option>
                        </select>
                    </div>

                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                        <select 
                            x-model="filters.sort"
                            @change="performSearch"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="rating">Highest Rated</option>
                            <option value="delivery_time">Fastest Delivery</option>
                            <option value="delivery_fee">Lowest Delivery Fee</option>
                            <option value="name">Name (A-Z)</option>
                        </select>
                    </div>

                    
                    <div class="flex items-end">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input 
                                type="checkbox" 
                                x-model="filters.open_now"
                                @change="performSearch"
                                class="w-5 h-5 text-orange-500 border-gray-300 rounded focus:ring-orange-500">
                            <span class="text-sm font-medium text-gray-700">Open Now</span>
                        </label>
                    </div>
                </div>

                
                <div x-show="activeFilterCount > 0" class="flex flex-wrap gap-2">
                    <template x-for="(value, key) in activeFilters" :key="key">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-orange-100 text-orange-800">
                            <span x-text="getFilterLabel(key, value)"></span>
                            <button 
                                type="button"
                                @click="removeFilter(key)"
                                class="ml-2 hover:text-orange-900">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </span>
                    </template>
                    <button 
                        type="button"
                        @click="clearAllFilters"
                        class="text-sm text-gray-600 hover:text-gray-900 underline">
                        Clear all
                    </button>
                </div>
            </form>
        </div>

        
        <div>
            
            <div class="mb-6 flex items-center justify-between">
                <div class="text-gray-600">
                    <span x-show="!loading">
                        Found <span x-text="totalResults"></span> restaurant<span x-show="totalResults !== 1">s</span>
                    </span>
                    <span x-show="loading" class="flex items-center">
                        <svg class="animate-spin h-5 w-5 mr-2 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Searching...
                    </span>
                </div>
            </div>

            
            <div x-show="!loading && restaurants.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <template x-for="restaurant in restaurants" :key="restaurant.id">
                    <a :href="`/restaurants/${restaurant.slug}`" class="group">
                        <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden transform group-hover:-translate-y-1">
                            
                            <div class="h-48 bg-gradient-to-br from-orange-400 to-orange-600 relative">
                                <template x-if="restaurant.cover_image">
                                    <img :src="`/storage/${restaurant.cover_image}`" :alt="restaurant.name" class="w-full h-full object-cover">
                                </template>
                                <div class="absolute top-4 right-4 bg-white px-3 py-1 rounded-full text-sm font-semibold flex items-center gap-1">
                                    <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <span x-text="restaurant.rating"></span>
                                </div>
                            </div>

                            
                            <div class="p-5">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-orange-600 transition" x-text="restaurant.name"></h3>
                                </div>
                                
                                <p class="text-gray-600 text-sm mb-3 line-clamp-2" x-text="restaurant.description"></p>
                                
                                <div class="flex items-center gap-4 text-sm text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span x-text="`${restaurant.delivery_time} min`"></span>
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        <span x-text="restaurant.delivery_fee > 0 ? `$${restaurant.delivery_fee}` : 'Free'"></span>
                                    </span>
                                </div>

                                <div class="mt-3 flex items-center justify-between">
                                    <span class="inline-block px-3 py-1 bg-orange-50 text-orange-700 rounded-full text-xs font-medium" x-text="restaurant.cuisine_type"></span>
                                    <span class="text-xs text-gray-500" x-text="restaurant.city"></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </template>
            </div>

            
            <div x-show="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <template x-for="i in 6" :key="i">
                    <div class="bg-white rounded-xl shadow-md overflow-hidden animate-pulse">
                        <div class="h-48 bg-gray-300"></div>
                        <div class="p-5 space-y-3">
                            <div class="h-6 bg-gray-300 rounded w-3/4"></div>
                            <div class="h-4 bg-gray-200 rounded w-full"></div>
                            <div class="h-4 bg-gray-200 rounded w-2/3"></div>
                            <div class="flex gap-4">
                                <div class="h-4 bg-gray-200 rounded w-20"></div>
                                <div class="h-4 bg-gray-200 rounded w-20"></div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            
            <div x-show="!loading && restaurants.length === 0" class="text-center py-16">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No restaurants found</h3>
                <p class="text-gray-600 mb-6">Try adjusting your search or filters to find what you're looking for.</p>
                <button 
                    @click="clearAllFilters"
                    class="px-6 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition">
                    Clear all filters
                </button>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function restaurantSearch() {
    return {
        filters: {
            search: '<?php echo e(request("search")); ?>',
            cuisine: '<?php echo e(request("cuisine")); ?>',
            city: '<?php echo e(request("city")); ?>',
            price_range: '<?php echo e(request("price_range")); ?>',
            min_rating: '<?php echo e(request("min_rating")); ?>',
            delivery_fee: '<?php echo e(request("delivery_fee")); ?>',
            delivery_time: '<?php echo e(request("delivery_time")); ?>',
            sort: '<?php echo e(request("sort", "rating")); ?>',
            open_now: <?php echo e(request("open_now") ? 'true' : 'false'); ?>

        },
        restaurants: <?php echo json_encode($restaurants->items(), 15, 512) ?>,
        totalResults: <?php echo e($restaurants->total()); ?>,
        loading: false,
        showFilters: window.innerWidth >= 1024, // Show filters by default on desktop

        get activeFilters() {
            const active = {};
            for (const [key, value] of Object.entries(this.filters)) {
                if (value && value !== '' && value !== false && key !== 'sort') {
                    active[key] = value;
                }
            }
            return active;
        },

        get activeFilterCount() {
            return Object.keys(this.activeFilters).length;
        },

        async performSearch() {
            this.loading = true;
            
            // Build query string
            const params = new URLSearchParams();
            for (const [key, value] of Object.entries(this.filters)) {
                if (value && value !== '' && value !== false) {
                    params.append(key, value);
                }
            }

            // Update URL without reload
            const newUrl = `${window.location.pathname}?${params.toString()}`;
            window.history.pushState({}, '', newUrl);

            try {
                const response = await fetch(`<?php echo e(route('restaurants.search')); ?>?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                this.restaurants = data.data.data;
                this.totalResults = data.total;
            } catch (error) {
                console.error('Search error:', error);
            } finally {
                this.loading = false;
            }
        },

        removeFilter(key) {
            if (key === 'open_now') {
                this.filters[key] = false;
            } else {
                this.filters[key] = '';
            }
            this.performSearch();
        },

        clearAllFilters() {
            this.filters = {
                search: '',
                cuisine: '',
                city: '',
                price_range: '',
                min_rating: '',
                delivery_fee: '',
                delivery_time: '',
                sort: 'rating',
                open_now: false
            };
            this.performSearch();
        },

        getFilterLabel(key, value) {
            const labels = {
                search: `Search: "${value}"`,
                cuisine: `Cuisine: ${value}`,
                city: `City: ${value}`,
                price_range: `Price: ${value}`,
                min_rating: `Rating: ${value}+`,
                delivery_fee: value === 'free' ? 'Free Delivery' : `Delivery: Under $${value}`,
                delivery_time: `Delivery: Under ${value} min`,
                open_now: 'Open Now'
            };
            return labels[key] || value;
        }
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel again\food-delivery\resources\views/restaurants/index.blade.php ENDPATH**/ ?>
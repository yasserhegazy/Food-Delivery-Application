@props(['restaurant', 'userRating' => null])

<div x-data="{
    rating: {{ $userRating->rating ?? 0 }},
    review: '{{ $userRating->review ?? '' }}',
    hoveredRating: 0,
    loading: false,
    
    async submitRating() {
        if (this.rating === 0) {
            this.$dispatch('notify', { 
                type: 'error', 
                message: 'Please select a rating' 
            });
            return;
        }
        
        this.loading = true;
        
        try {
            const url = @json($userRating ? route('customer.ratings.update', $userRating) : route('customer.restaurants.rate', $restaurant));
            const method = @json($userRating ? 'PATCH' : 'POST');
            
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    rating: this.rating,
                    review: this.review
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                this.$dispatch('notify', { 
                    type: 'success', 
                    message: data.message 
                });
                
                // Reload page to show updated rating
                setTimeout(() => window.location.reload(), 1000);
            } else {
                this.$dispatch('notify', { 
                    type: 'error', 
                    message: data.message 
                });
            }
        } catch (error) {
            console.error('Error submitting rating:', error);
            this.$dispatch('notify', { 
                type: 'error', 
                message: 'Failed to submit rating' 
            });
        } finally {
            this.loading = false;
        }
    }
}" class="space-y-4">
    
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Your Rating</label>
        <div class="flex items-center gap-2">
            @for($i = 1; $i <= 5; $i++)
                <button @click="rating = {{ $i }}"
                        @mouseenter="hoveredRating = {{ $i }}"
                        @mouseleave="hoveredRating = 0"
                        type="button"
                        class="focus:outline-none transition-transform hover:scale-110">
                    <svg class="w-8 h-8"
                         :class="(hoveredRating >= {{ $i }} || (hoveredRating === 0 && rating >= {{ $i }})) ? 'text-yellow-400 fill-current' : 'text-gray-300'"
                         fill="none" 
                         stroke="currentColor" 
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </button>
            @endfor
            <span x-show="rating > 0" 
                  x-text="rating + ' star' + (rating > 1 ? 's' : '')"
                  class="ml-2 text-sm text-gray-600"></span>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Review (Optional)</label>
        <textarea x-model="review"
                  rows="3"
                  placeholder="Share your experience with this restaurant..."
                  class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200"></textarea>
    </div>

    <div class="flex items-center gap-3">
        <button @click="submitRating()" 
                :disabled="loading || rating === 0"
                type="button"
                class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-6 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed">
            <span x-text="loading ? 'Submitting...' : '{{ $userRating ? 'Update Rating' : 'Submit Rating' }}'"></span>
        </button>
        
        @if($userRating)
        <button @click="if(confirm('Are you sure you want to delete your rating?')) {
                    fetch('{{ route('customer.ratings.destroy', $userRating) }}', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        }
                    }).then(() => window.location.reload());
                }"
                type="button"
                class="text-red-600 hover:text-red-700 font-medium">
            Delete Rating
        </button>
        @endif
    </div>
</div>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['restaurant', 'userRating' => null]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['restaurant', 'userRating' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div x-data="ratingForm(<?php echo e($userRating?->rating ?? 0); ?>, <?php echo e(json_encode($userRating?->review ?? '')); ?>)" class="space-y-4">
    
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Your Rating</label>
        <div class="flex items-center gap-2">
            <?php for($i = 1; $i <= 5; $i++): ?>
                <button @click="rating = <?php echo e($i); ?>"
                        @mouseenter="hoveredRating = <?php echo e($i); ?>"
                        @mouseleave="hoveredRating = 0"
                        type="button"
                        class="focus:outline-none transition-transform hover:scale-110">
                    <svg class="w-8 h-8"
                         :class="(hoveredRating >= <?php echo e($i); ?> || (hoveredRating === 0 && rating >= <?php echo e($i); ?>)) ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300 fill-gray-300'"
                         viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </button>
            <?php endfor; ?>
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
            <span x-text="loading ? 'Submitting...' : '<?php echo e($userRating ? 'Update Rating' : 'Submit Rating'); ?>'"></span>
        </button>
        
        <?php if($userRating): ?>
        <button @click="deleteRating()"
                type="button"
                class="text-red-600 hover:text-red-700 font-medium">
            Delete Rating
        </button>
        <?php endif; ?>
    </div>
</div>

<script>
function ratingForm(initialRating, initialReview) {
    return {
        rating: initialRating,
        review: initialReview,
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
                const url = <?php echo json_encode($userRating ? route('customer.ratings.update', $userRating) : route('customer.restaurants.rate', $restaurant)) ?>;
                const method = <?php echo json_encode($userRating ? 'PATCH' : 'POST', 15, 512) ?>;
                
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
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
        },
        
        async deleteRating() {
            if (!confirm('Are you sure you want to delete your rating?')) {
                return;
            }
            
            try {
                const response = await fetch(<?php echo json_encode(route('customer.ratings.destroy', $userRating ?? 0), 512) ?>, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Accept': 'application/json',
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.$dispatch('notify', { 
                        type: 'success', 
                        message: data.message 
                    });
                    
                    setTimeout(() => window.location.reload(), 1000);
                }
            } catch (error) {
                console.error('Error deleting rating:', error);
            }
        }
    }
}
</script>
<?php /**PATH D:\laravel again\food-delivery\resources\views/components/rating-form.blade.php ENDPATH**/ ?>
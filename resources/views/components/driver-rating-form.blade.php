@props(['order'])

@if($order->status === 'delivered' && is_null($order->driver_rating) && !is_null($order->driver_id))
<div x-data="{ rating: 0, hoverRating: 0 }" class="bg-white rounded-lg border border-orange-200 p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4">Rate Your Delivery</h3>

    <form method="POST" action="{{ route('customer.orders.rate-driver', $order) }}">
        @csrf

        {{-- Star Rating --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">How was your delivery experience?</label>
            <div class="flex gap-1">
                @for($i = 1; $i <= 5; $i++)
                    <button
                        type="button"
                        @click="rating = {{ $i }}"
                        @mouseenter="hoverRating = {{ $i }}"
                        @mouseleave="hoverRating = 0"
                        class="focus:outline-none transition-colors duration-150"
                    >
                        <svg
                            class="w-8 h-8"
                            :class="(hoverRating || rating) >= {{ $i }} ? 'text-orange-400' : 'text-gray-300'"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </button>
                @endfor
            </div>
            <input type="hidden" name="driver_rating" :value="rating">
            @error('driver_rating')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Review Text Area --}}
        <div class="mb-4">
            <label for="driver_review" class="block text-sm font-medium text-gray-700 mb-2">Leave a review (optional)</label>
            <textarea
                name="driver_review"
                id="driver_review"
                rows="3"
                maxlength="500"
                placeholder="How was your delivery experience?"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-500 focus:border-orange-500"
            >{{ old('driver_review') }}</textarea>
            @error('driver_review')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit Button --}}
        <button
            type="submit"
            x-bind:disabled="rating === 0"
            class="w-full bg-orange-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-orange-600 transition-colors duration-150 disabled:opacity-50 disabled:cursor-not-allowed"
        >
            Submit Rating
        </button>
    </form>
</div>
@endif

@props(['menuItem', 'size' => 'default'])

<div x-data="{
    quantity: 1,
    specialInstructions: '',
    loading: false,
    showInstructions: false,
    
    async addToCart() {
        this.loading = true;
        
        try {
            const response = await fetch('{{ route('customer.cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    menu_item_id: {{ $menuItem->id }},
                    quantity: this.quantity,
                    special_instructions: this.specialInstructions
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Update cart count in navigation
                window.dispatchEvent(new CustomEvent('cart-updated', { detail: data.cart_count }));
                
                // Show success message
                this.$dispatch('notify', { 
                    type: 'success', 
                    message: data.message 
                });
                
                // Reset form
                this.quantity = 1;
                this.specialInstructions = '';
                this.showInstructions = false;
            } else {
                this.$dispatch('notify', { 
                    type: 'error', 
                    message: data.message 
                });
            }
        } catch (error) {
            console.error('Error adding to cart:', error);
            this.$dispatch('notify', { 
                type: 'error', 
                message: 'Failed to add item to cart' 
            });
        } finally {
            this.loading = false;
        }
    }
}" class="space-y-3">
    
    {{-- Quantity Selector --}}
    <div class="flex items-center gap-3">
        <label class="text-sm font-medium text-gray-700">Quantity:</label>
        <div class="flex items-center border border-gray-300 rounded-lg">
            <button @click="quantity = Math.max(1, quantity - 1)" 
                    type="button"
                    class="px-3 py-1 hover:bg-gray-100 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                </svg>
            </button>
            <input type="number" 
                   x-model="quantity" 
                   min="1" 
                   max="99"
                   class="w-16 text-center border-0 focus:ring-0 py-1">
            <button @click="quantity = Math.min(99, quantity + 1)" 
                    type="button"
                    class="px-3 py-1 hover:bg-gray-100 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Special Instructions Toggle --}}
    <button @click="showInstructions = !showInstructions" 
            type="button"
            class="text-sm text-orange-600 hover:text-orange-700 flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
        Add special instructions
    </button>

    {{-- Special Instructions Input --}}
    <div x-show="showInstructions" 
         x-transition
         class="space-y-2">
        <textarea x-model="specialInstructions"
                  placeholder="e.g., No onions, extra spicy..."
                  rows="2"
                  class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200 text-sm"></textarea>
    </div>

    {{-- Add to Cart Button --}}
    <button @click="addToCart()" 
            :disabled="loading"
            type="button"
            class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-6 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
            :class="{ 'opacity-50 cursor-not-allowed': loading }">
        <svg x-show="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        <svg x-show="loading" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span x-text="loading ? 'Adding...' : 'Add to Cart'"></span>
    </button>
</div>

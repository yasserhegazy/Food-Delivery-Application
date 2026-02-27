@props(['count' => 0])

<div class="relative">
    <a href="{{ route('customer.cart.index') }}" class="flex items-center gap-2 text-gray-700 hover:text-orange-600 transition" aria-label="Shopping cart{{ $count > 0 ? ', ' . $count . ' items' : '' }}">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        
        <span x-show="$root.cartCount > 0" 
              x-text="$root.cartCount"
              aria-hidden="true"
              class="absolute -top-2 -right-2 bg-orange-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
        </span>
    </a>
</div>

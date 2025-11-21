@props([
    'variant' => 'primary',
    'type' => 'button',
    'loading' => false,
    'icon' => null,
])

@php
    $baseClasses = 'px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed';
    
    $variantClasses = [
        'primary' => 'bg-orange-500 hover:bg-orange-600 text-white shadow-md hover:shadow-lg',
        'secondary' => 'bg-gray-200 hover:bg-gray-300 text-gray-800',
        'danger' => 'bg-red-500 hover:bg-red-600 text-white shadow-md hover:shadow-lg',
        'outline' => 'border-2 border-orange-500 text-orange-500 hover:bg-orange-50',
    ];
    
    $classes = $baseClasses . ' ' . ($variantClasses[$variant] ?? $variantClasses['primary']);
@endphp

<button 
    type="{{ $type }}"
    {{ $attributes->merge(['class' => $classes]) }}
    {{ $loading ? 'disabled' : '' }}
>
    @if($loading)
        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @elseif($icon)
        {!! $icon !!}
    @endif
    
    {{ $slot }}
</button>

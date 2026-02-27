@props(['id', 'title' => '', 'size' => 'md'])

@php
    $sizeClasses = [
        'sm' => 'max-w-md',
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
        'full' => 'max-w-full mx-4'
    ];
    $maxWidth = $sizeClasses[$size] ?? $sizeClasses['md'];
    $modalTitleId = 'modal-title-' . $id;
@endphp

<div 
    x-data="{ open: false }"
    @open-modal.window="if ($event.detail === '{{ $id }}') { open = true; $nextTick(() => $refs.modalContent?.focus()) }"
    @close-modal.window="if ($event.detail === '{{ $id }}') open = false"
    @keydown.escape.window="open = false"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;">
    
    <!-- Backdrop -->
    <div 
        x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="open = false"
        class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity">
    </div>

    <!-- Modal Content -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div 
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            @click.stop
            x-ref="modalContent"
            @keydown.tab="
                const focusable = $el.querySelectorAll('a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex=\'-1\'])');
                const first = focusable[0];
                const last = focusable[focusable.length - 1];
                if ($event.shiftKey && document.activeElement === first) { last.focus(); $event.preventDefault(); }
                else if (!$event.shiftKey && document.activeElement === last) { first.focus(); $event.preventDefault(); }
            "
            role="dialog"
            aria-modal="true"
            @if($title) aria-labelledby="{{ $modalTitleId }}" @endif
            class="relative w-full {{ $maxWidth }} transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all">
            
            <!-- Header -->
            @if($title)
                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                    <h3 id="{{ $modalTitleId }}" class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
                    <button 
                        @click="open = false"
                        aria-label="Close dialog"
                        class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            @endif
            
            <!-- Body -->
            <div class="px-6 py-4">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

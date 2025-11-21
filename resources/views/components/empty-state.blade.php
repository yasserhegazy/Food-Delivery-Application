@props(['title', 'message', 'icon' => 'inbox', 'actionUrl' => null, 'actionText' => null])

@php
    $icons = [
        'inbox' => 'M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4',
        'search' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
        'document' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        'folder' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z',
    ];
    $iconPath = $icons[$icon] ?? $icons['inbox'];
@endphp

<div class="text-center py-12 px-4">
    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"></path>
        </svg>
    </div>
    
    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $title }}</h3>
    <p class="text-gray-600 max-w-md mx-auto mb-6">{{ $message }}</p>
    
    @if($actionUrl && $actionText)
        <a href="{{ $actionUrl }}" 
           class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-full font-medium transition-all transform hover:-translate-y-0.5 shadow-lg shadow-orange-500/30">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            {{ $actionText }}
        </a>
    @endif
</div>

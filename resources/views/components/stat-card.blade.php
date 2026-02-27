@props(['title', 'value', 'icon', 'color' => 'orange', 'trend' => null])

@php
    $colorClasses = [
        'orange' => 'bg-orange-100 text-orange-600',
        'blue' => 'bg-blue-100 text-blue-600',
        'green' => 'bg-green-100 text-green-600',
        'purple' => 'bg-purple-100 text-purple-600',
        'red' => 'bg-red-100 text-red-600',
    ];
    $bgColor = $colorClasses[$color] ?? $colorClasses['orange'];
@endphp

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">{{ $title }}</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $value }}</p>
            
            @if($trend)
                <div class="flex items-center gap-1 mt-2">
                    @if($trend > 0)
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        <span class="text-sm font-medium text-green-600">+{{ $trend }}%</span>
                    @else
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                        </svg>
                        <span class="text-sm font-medium text-red-600">{{ $trend }}%</span>
                    @endif
                    <span class="text-xs text-gray-500 dark:text-gray-400">vs last month</span>
                </div>
            @endif
        </div>
        
        <div class="w-12 h-12 {{ $bgColor }} rounded-xl flex items-center justify-center flex-shrink-0">
            {!! $icon !!}
        </div>
    </div>
</div>

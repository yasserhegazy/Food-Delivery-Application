<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl shadow-sm overflow-hidden']) }}>
    <!-- Image area -->
    <div class="skeleton-shimmer h-48 bg-gray-200">
        {{ $image ?? '' }}
    </div>

    <div class="p-4 space-y-3">
        <!-- Title -->
        <div class="skeleton-shimmer h-5 bg-gray-200 rounded w-3/4">
            {{ $title ?? '' }}
        </div>

        <!-- Description lines -->
        <div class="space-y-2">
            <div class="skeleton-shimmer h-3 bg-gray-200 rounded w-full">
                {{ $description ?? '' }}
            </div>
            <div class="skeleton-shimmer h-3 bg-gray-200 rounded w-5/6"></div>
        </div>

        <!-- Meta row -->
        <div class="flex items-center gap-4 pt-1">
            <div class="skeleton-shimmer h-4 bg-gray-200 rounded w-16"></div>
            <div class="skeleton-shimmer h-4 bg-gray-200 rounded w-20"></div>
            <div class="skeleton-shimmer h-4 bg-gray-200 rounded w-14"></div>
        </div>
    </div>
</div>

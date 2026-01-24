<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title', 'value', 'icon', 'color' => 'orange', 'trend' => null]));

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

foreach (array_filter((['title', 'value', 'icon', 'color' => 'orange', 'trend' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $colorClasses = [
        'orange' => 'bg-orange-100 text-orange-600',
        'blue' => 'bg-blue-100 text-blue-600',
        'green' => 'bg-green-100 text-green-600',
        'purple' => 'bg-purple-100 text-purple-600',
        'red' => 'bg-red-100 text-red-600',
    ];
    $bgColor = $colorClasses[$color] ?? $colorClasses['orange'];
?>

<div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-600 mb-1"><?php echo e($title); ?></p>
            <p class="text-3xl font-bold text-gray-900"><?php echo e($value); ?></p>
            
            <?php if($trend): ?>
                <div class="flex items-center gap-1 mt-2">
                    <?php if($trend > 0): ?>
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        <span class="text-sm font-medium text-green-600">+<?php echo e($trend); ?>%</span>
                    <?php else: ?>
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                        </svg>
                        <span class="text-sm font-medium text-red-600"><?php echo e($trend); ?>%</span>
                    <?php endif; ?>
                    <span class="text-xs text-gray-500">vs last month</span>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="w-12 h-12 <?php echo e($bgColor); ?> rounded-xl flex items-center justify-center flex-shrink-0">
            <?php echo $icon; ?>

        </div>
    </div>
</div>
<?php /**PATH D:\laravel again\food-delivery\resources\views/components/stat-card.blade.php ENDPATH**/ ?>
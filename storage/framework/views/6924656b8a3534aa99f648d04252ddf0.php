<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['status' => 'active']));

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

foreach (array_filter((['status' => 'active']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
$classes = match($status) {
    'active', true, 1 => 'bg-green-100 text-green-800',
    'inactive', false, 0 => 'bg-red-100 text-red-800',
    default => 'bg-gray-100 text-gray-800'
};

$label = match($status) {
    'active', true, 1 => 'Active',
    'inactive', false, 0 => 'Inactive',
    default => ucfirst($status)
};
?>

<span <?php echo e($attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$classes}"])); ?>>
    <?php echo e($slot->isEmpty() ? $label : $slot); ?>

</span>
<?php /**PATH D:\laravel again\food-delivery\resources\views/components/status-badge.blade.php ENDPATH**/ ?>
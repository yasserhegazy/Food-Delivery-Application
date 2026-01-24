<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['role']));

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

foreach (array_filter((['role']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
$config = match($role) {
    'admin' => ['class' => 'bg-purple-100 text-purple-800', 'label' => 'Admin'],
    'restaurant_owner' => ['class' => 'bg-orange-100 text-orange-800', 'label' => 'Restaurant Owner'],
    'driver' => ['class' => 'bg-green-100 text-green-800', 'label' => 'Driver'],
    'customer' => ['class' => 'bg-blue-100 text-blue-800', 'label' => 'Customer'],
    default => ['class' => 'bg-gray-100 text-gray-800', 'label' => ucfirst($role)]
};
?>

<span <?php echo e($attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$config['class']}"])); ?>>
    <?php echo e($slot->isEmpty() ? $config['label'] : $slot); ?>

</span>
<?php /**PATH D:\laravel again\food-delivery\resources\views/components/role-badge.blade.php ENDPATH**/ ?>
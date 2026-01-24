<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['name', 'label' => null, 'checked' => false, 'disabled' => false]));

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

foreach (array_filter((['name', 'label' => null, 'checked' => false, 'disabled' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="flex items-center justify-between">
    <?php if($label): ?>
        <label for="<?php echo e($name); ?>" class="text-sm font-medium text-gray-700"><?php echo e($label); ?></label>
    <?php endif; ?>
    
    <button 
        type="button"
        role="switch"
        :aria-checked="checked"
        @click="checked = !checked"
        x-data="{ checked: <?php echo e($checked ? 'true' : 'false'); ?> }"
        :class="{ 'bg-orange-500': checked, 'bg-gray-200': !checked }"
        <?php echo e($disabled ? 'disabled' : ''); ?>

        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
        
        <span 
            :class="{ 'translate-x-5': checked, 'translate-x-0': !checked }"
            class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out">
        </span>
        
        <input 
            type="hidden" 
            name="<?php echo e($name); ?>" 
            :value="checked ? '1' : '0'"
            x-ref="input">
    </button>
</div>
<?php /**PATH D:\laravel again\food-delivery\resources\views/components/toggle-switch.blade.php ENDPATH**/ ?>
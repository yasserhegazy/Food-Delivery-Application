<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['item']));

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

foreach (array_filter((['item']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div x-data="{ showModal: false }" class="group bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
    <!-- Image -->
    <div class="relative h-48 bg-gray-200 overflow-hidden">
        <?php if($item->image): ?>
            <img src="<?php echo e(asset('storage/' . $item->image)); ?>" 
                 alt="<?php echo e($item->name); ?>" 
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
        <?php else: ?>
            <div class="w-full h-full bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </div>
        <?php endif; ?>
        
        <!-- Badges -->
        <div class="absolute top-2 left-2 flex flex-col gap-2">
            <?php if($item->is_featured): ?>
                <span class="bg-orange-500 text-white px-2 py-1 rounded-full text-xs font-semibold flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    Featured
                </span>
            <?php endif; ?>
            
            <?php if($item->has_discount): ?>
                <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                    <?php echo e(round((($item->price - $item->discount_price) / $item->price) * 100)); ?>% OFF
                </span>
            <?php endif; ?>
        </div>
        
        <?php if(!$item->is_available): ?>
            <div class="absolute inset-0 bg-gray-900 bg-opacity-60 flex items-center justify-center">
                <span class="bg-white text-gray-900 px-4 py-2 rounded-full font-semibold">
                    Unavailable
                </span>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Content -->
    <div class="p-4">
        <h4 class="font-bold text-gray-900 group-hover:text-orange-600 transition-colors">
            <?php echo e($item->name); ?>

        </h4>
        
        <?php if($item->description): ?>
            <p class="text-sm text-gray-600 mt-1 line-clamp-2">
                <?php echo e($item->description); ?>

            </p>
        <?php endif; ?>
        
        <!-- Price & Actions -->
        <div class="flex items-center justify-between mt-3">
            <div class="flex items-baseline gap-2">
                <?php if($item->has_discount): ?>
                    <span class="text-lg font-bold text-orange-600">
                        $<?php echo e(number_format($item->final_price, 2)); ?>

                    </span>
                    <span class="text-sm text-gray-400 line-through">
                        $<?php echo e(number_format($item->price, 2)); ?>

                    </span>
                <?php else: ?>
                    <span class="text-lg font-bold text-gray-900">
                        $<?php echo e(number_format($item->price, 2)); ?>

                    </span>
                <?php endif; ?>
            </div>
            
            <?php if($item->is_available): ?>
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->isCustomer()): ?>
                        <button @click="showModal = true"
                            type="button"
                            class="bg-orange-500 hover:bg-orange-600 text-white p-2 rounded-full transition-all transform hover:scale-110 shadow-lg shadow-orange-500/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </button>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" 
                       class="bg-orange-500 hover:bg-orange-600 text-white p-2 rounded-full transition-all transform hover:scale-110 shadow-lg shadow-orange-500/30 inline-block">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        
        <?php if($item->preparation_time): ?>
            <div class="flex items-center gap-1 mt-2 text-xs text-gray-500">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span><?php echo e($item->preparation_time); ?> min</span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Add to Cart Modal -->
    <?php if(auth()->guard()->check()): ?>
        <?php if(auth()->user()->isCustomer() && $item->is_available): ?>
            <div x-show="showModal" 
                 x-cloak
                 @click.away="showModal = false"
                 class="fixed inset-0 z-50 overflow-y-auto"
                 style="display: none;">
                <div class="flex items-center justify-center min-h-screen px-4">
                    <div class="fixed inset-0 bg-black opacity-50"></div>
                    
                    <div class="relative bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl">
                        <button @click="showModal = false" 
                                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        
                        <h3 class="text-2xl font-bold text-gray-900 mb-4"><?php echo e($item->name); ?></h3>
                        
                        <?php if($item->image): ?>
                            <img src="<?php echo e(asset('storage/' . $item->image)); ?>" 
                                 alt="<?php echo e($item->name); ?>"
                                 class="w-full h-48 object-cover rounded-lg mb-4">
                        <?php endif; ?>
                        
                        <p class="text-gray-600 mb-4"><?php echo e($item->description); ?></p>
                        
                        <div class="mb-6">
                            <span class="text-2xl font-bold text-orange-600">
                                $<?php echo e(number_format($item->final_price, 2)); ?>

                            </span>
                        </div>
                        
                        <?php if (isset($component)) { $__componentOriginal0ebc6ef07b571ddf6bdd9d88111343c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0ebc6ef07b571ddf6bdd9d88111343c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.add-to-cart-button','data' => ['menuItem' => $item]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('add-to-cart-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['menuItem' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0ebc6ef07b571ddf6bdd9d88111343c0)): ?>
<?php $attributes = $__attributesOriginal0ebc6ef07b571ddf6bdd9d88111343c0; ?>
<?php unset($__attributesOriginal0ebc6ef07b571ddf6bdd9d88111343c0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0ebc6ef07b571ddf6bdd9d88111343c0)): ?>
<?php $component = $__componentOriginal0ebc6ef07b571ddf6bdd9d88111343c0; ?>
<?php unset($__componentOriginal0ebc6ef07b571ddf6bdd9d88111343c0); ?>
<?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php /**PATH D:\laravel again\food-delivery\resources\views/components/menu-item-card.blade.php ENDPATH**/ ?>
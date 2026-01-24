

<?php $__env->startSection('title', 'Shopping Cart'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

    <?php if($cartItems->count() > 0): ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $restaurantId => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $restaurant = $items->first()->menuItem->category->restaurant;
                        $restaurantTotal = $items->sum(fn($item) => $item->subtotal);
                    ?>
                    
                    <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        
                        <div class="flex items-center justify-between mb-4 pb-4 border-b">
                            <div class="flex items-center gap-3">
                                <?php if($restaurant->logo): ?>
                                    <img src="<?php echo e(asset('storage/' . $restaurant->logo)); ?>" 
                                         alt="<?php echo e($restaurant->name); ?>"
                                         class="w-12 h-12 rounded-lg object-cover">
                                <?php endif; ?>
                                <div>
                                    <h3 class="font-bold text-lg"><?php echo e($restaurant->name); ?></h3>
                                    <p class="text-sm text-gray-600"><?php echo e($items->count()); ?> item<?php echo e($items->count() > 1 ? 's' : ''); ?></p>
                                </div>
                            </div>
                            <span class="text-lg font-bold text-orange-600">
                                $<?php echo e(number_format($restaurantTotal, 2)); ?>

                            </span>
                        </div>

                        
                        <div class="space-y-4">
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div x-data="{
                                    quantity: <?php echo e($item->quantity); ?>,
                                    loading: false,
                                    
                                    async updateQuantity(newQuantity) {
                                        this.loading = true;
                                        try {
                                            const response = await fetch('<?php echo e(route('customer.cart.update', $item->id)); ?>', {
                                                method: 'PATCH',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                                                    'Accept': 'application/json',
                                                },
                                                body: JSON.stringify({ quantity: newQuantity })
                                            });
                                            
                                            const data = await response.json();
                                            if (data.success) {
                                                if (newQuantity === 0) {
                                                    window.location.reload();
                                                } else {
                                                    this.quantity = newQuantity;
                                                    window.location.reload();
                                                }
                                            }
                                        } catch (error) {
                                            console.error('Error updating cart:', error);
                                        } finally {
                                            this.loading = false;
                                        }
                                    },
                                    
                                    async removeItem() {
                                        if (!confirm('Remove this item from cart?')) return;
                                        
                                        this.loading = true;
                                        try {
                                            const response = await fetch('<?php echo e(route('customer.cart.remove', $item->id)); ?>', {
                                                method: 'DELETE',
                                                headers: {
                                                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                                                    'Accept': 'application/json',
                                                }
                                            });
                                            
                                            const data = await response.json();
                                            if (data.success) {
                                                window.location.reload();
                                            }
                                        } catch (error) {
                                            console.error('Error removing item:', error);
                                        } finally {
                                            this.loading = false;
                                        }
                                    }
                                }" class="flex gap-4 p-4 bg-gray-50 rounded-lg">
                                    
                                    <?php if($item->menuItem->image): ?>
                                        <img src="<?php echo e(asset('storage/' . $item->menuItem->image)); ?>" 
                                             alt="<?php echo e($item->menuItem->name); ?>"
                                             class="w-20 h-20 rounded-lg object-cover flex-shrink-0">
                                    <?php else: ?>
                                        <div class="w-20 h-20 rounded-lg bg-gray-200 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                            </svg>
                                        </div>
                                    <?php endif; ?>

                                    
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900"><?php echo e($item->menuItem->name); ?></h4>
                                        <p class="text-sm text-gray-600">$<?php echo e(number_format($item->price, 2)); ?> each</p>
                                        
                                        <?php if($item->special_instructions): ?>
                                            <p class="text-xs text-gray-500 mt-1">
                                                <span class="font-medium">Note:</span> <?php echo e($item->special_instructions); ?>

                                            </p>
                                        <?php endif; ?>

                                        
                                        <div class="flex items-center gap-3 mt-2">
                                            <div class="flex items-center border border-gray-300 rounded-lg">
                                                <button @click="updateQuantity(Math.max(0, quantity - 1))" 
                                                        :disabled="loading"
                                                        class="px-3 py-1 hover:bg-gray-100 transition disabled:opacity-50">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                    </svg>
                                                </button>
                                                <span class="px-4 py-1 font-medium" x-text="quantity"></span>
                                                <button @click="updateQuantity(Math.min(99, quantity + 1))" 
                                                        :disabled="loading"
                                                        class="px-3 py-1 hover:bg-gray-100 transition disabled:opacity-50">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                    </svg>
                                                </button>
                                            </div>

                                            <button @click="removeItem()" 
                                                    :disabled="loading"
                                                    class="text-red-600 hover:text-red-700 text-sm font-medium disabled:opacity-50">
                                                Remove
                                            </button>
                                        </div>
                                    </div>

                                    
                                    <div class="text-right">
                                        <p class="font-bold text-gray-900">$<?php echo e(number_format($item->subtotal, 2)); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $attributes = $__attributesOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__attributesOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $component = $__componentOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__componentOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <div class="lg:col-span-1">
                <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['title' => 'Order Summary','class' => 'sticky top-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Order Summary','class' => 'sticky top-4']); ?>
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal (<?php echo e($cartCount); ?> items)</span>
                            <span>$<?php echo e(number_format($cartTotal, 2)); ?></span>
                        </div>
                        
                        <?php
                            $deliveryFee = $cartItems->sum(function($items) {
                                return $items->first()->menuItem->category->restaurant->delivery_fee;
                            });
                        ?>
                        
                        <div class="flex justify-between text-gray-600">
                            <span>Delivery Fee</span>
                            <span>$<?php echo e(number_format($deliveryFee, 2)); ?></span>
                        </div>
                        
                        <div class="border-t pt-3 flex justify-between text-lg font-bold">
                            <span>Total</span>
                            <span class="text-orange-600">$<?php echo e(number_format($cartTotal + $deliveryFee, 2)); ?></span>
                        </div>
                    </div>

                    <div class="mt-6 space-y-3">
                        <a href="<?php echo e(route('customer.checkout.index')); ?>" class="block">
                            <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['variant' => 'primary','class' => 'w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'primary','class' => 'w-full']); ?>
                                Proceed to Checkout
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
                        </a>
                        
                        <form action="<?php echo e(route('customer.cart.clear')); ?>" method="POST" onsubmit="return confirm('Are you sure you want to clear your cart?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" 
                                    
                                    class="w-full text-red-600 hover:text-red-700 font-medium text-sm">
                                Clear Cart
                            </button>
                        </form>
                    </div>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $attributes = $__attributesOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__attributesOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $component = $__componentOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__componentOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        
        <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
            <div class="text-center py-12">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Your cart is empty</h3>
                <p class="text-gray-600 mb-6">Add some delicious items to get started!</p>
                <a href="<?php echo e(route('restaurants.index')); ?>">
                    <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['variant' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'primary']); ?>
                        Browse Restaurants
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
                </a>
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $attributes = $__attributesOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__attributesOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $component = $__componentOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__componentOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel again\food-delivery\resources\views/customer/cart/index.blade.php ENDPATH**/ ?>
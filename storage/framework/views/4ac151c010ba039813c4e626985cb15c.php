<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Food Delivery')); ?> - <?php echo $__env->yieldContent('title', 'Dashboard'); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 font-sans antialiased" x-data="{
    notification: { show: false, type: '', message: '' },
    cartCount: <?php echo e(auth()->check() && auth()->user()->isCustomer() ? app(\App\Services\CartService::class)->getCartCount() : 0); ?>

}" 
@notify.window="notification = { show: true, type: $event.detail.type, message: $event.detail.message }; setTimeout(() => notification.show = false, 3000)"
@cart-updated.window="cartCount = $event.detail">
    
    
    <div x-show="notification.show" 
         x-transition
         class="fixed top-4 right-4 z-50 max-w-sm">
        <div :class="{
            'bg-green-500': notification.type === 'success',
            'bg-red-500': notification.type === 'error',
            'bg-blue-500': notification.type === 'info'
        }" class="text-white px-6 py-4 rounded-lg shadow-lg">
            <p x-text="notification.message"></p>
        </div>
    </div>
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-2">
                            <svg class="w-8 h-8 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                            </svg>
                            <span class="text-xl font-bold text-gray-800">FoodDelivery</span>
                        </a>
                        
                        <!-- Navigation Links -->
                        <div class="hidden md:flex md:ml-10 md:space-x-8">
                            <?php if(auth()->user()->isCustomer()): ?>
                                <a href="<?php echo e(route('customer.dashboard')); ?>" class="inline-flex items-center px-1 pt-1 text-sm font-medium <?php echo e(request()->routeIs('customer.dashboard') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300'); ?>">
                                    Home
                                </a>
                                <a href="<?php echo e(route('restaurants.index')); ?>" class="inline-flex items-center px-1 pt-1 text-sm font-medium <?php echo e(request()->routeIs('restaurants.*') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300'); ?>">
                                    Browse Restaurants
                                </a>
                                <a href="<?php echo e(route('customer.orders.index')); ?>" class="inline-flex items-center px-1 pt-1 text-sm font-medium <?php echo e(request()->routeIs('customer.orders.*') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300'); ?>">
                                    My Orders
                                </a>
                            <?php elseif(auth()->user()->isRestaurantOwner()): ?>
                                <a href="<?php echo e(route('restaurant.dashboard')); ?>" class="inline-flex items-center px-1 pt-1 text-sm font-medium <?php echo e(request()->routeIs('restaurant.dashboard') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300'); ?>">
                                    Dashboard
                                </a>
                                <a href="<?php echo e(route('restaurant.menu.index')); ?>" class="inline-flex items-center px-1 pt-1 text-sm font-medium <?php echo e(request()->routeIs('restaurant.menu.*') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300'); ?>">
                                    Menu
                                </a>
                                <a href="<?php echo e(route('restaurant.categories.index')); ?>" class="inline-flex items-center px-1 pt-1 text-sm font-medium <?php echo e(request()->routeIs('restaurant.categories.*') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300'); ?>">
                                    Categories
                                </a>
                                <a href="<?php echo e(route('restaurant.orders.index')); ?>" class="inline-flex items-center px-1 pt-1 text-sm font-medium <?php echo e(request()->routeIs('restaurant.orders.*') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300'); ?>">
                                    Orders
                                </a>
                                <a href="<?php echo e(route('restaurant.profile.edit')); ?>" class="inline-flex items-center px-1 pt-1 text-sm font-medium <?php echo e(request()->routeIs('restaurant.profile.*') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300'); ?>">
                                    Profile
                                </a>
                            <?php elseif(auth()->user()->isDriver()): ?>
                                <a href="<?php echo e(route('driver.deliveries.available')); ?>" class="inline-flex items-center px-1 pt-1 text-sm font-medium <?php echo e(request()->routeIs('driver.deliveries.available') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300'); ?>">
                                    Available Deliveries
                                </a>
                                <a href="<?php echo e(route('driver.deliveries.my')); ?>" class="inline-flex items-center px-1 pt-1 text-sm font-medium <?php echo e(request()->routeIs('driver.deliveries.my') || request()->routeIs('driver.deliveries.show') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300'); ?>">
                                    My Deliveries
                                </a>
                            <?php elseif(auth()->user()->isAdmin()): ?>
                                <a href="<?php echo e(route('admin.dashboard')); ?>" class="inline-flex items-center px-1 pt-1 text-sm font-medium <?php echo e(request()->routeIs('admin.dashboard') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300'); ?>">
                                    Dashboard
                                </a>
                                <a href="<?php echo e(route('admin.users.index')); ?>" class="inline-flex items-center px-1 pt-1 text-sm font-medium <?php echo e(request()->routeIs('admin.users.*') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300'); ?>">
                                    Users
                                </a>
                                <a href="<?php echo e(route('admin.restaurants.index')); ?>" class="inline-flex items-center px-1 pt-1 text-sm font-medium <?php echo e(request()->routeIs('admin.restaurants.*') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300'); ?>">
                                    Restaurants
                                </a>
                                <a href="<?php echo e(route('admin.categories.index')); ?>" class="inline-flex items-center px-1 pt-1 text-sm font-medium <?php echo e(request()->routeIs('admin.categories.*') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300'); ?>">
                                    Categories
                                </a>
                                <a href="<?php echo e(route('admin.menu-items.index')); ?>" class="inline-flex items-center px-1 pt-1 text-sm font-medium <?php echo e(request()->routeIs('admin.menu-items.*') ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300'); ?>">
                                    Menu Items
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="flex items-center gap-4">
                        <?php if(auth()->guard()->check()): ?>
                            
                            <?php if (isset($component)) { $__componentOriginal6541145ad4a57bfb6e6f221ba77eb386 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6541145ad4a57bfb6e6f221ba77eb386 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.notification-bell','data' => ['count' => auth()->user()->unreadNotifications()->count()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('notification-bell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['count' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(auth()->user()->unreadNotifications()->count())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6541145ad4a57bfb6e6f221ba77eb386)): ?>
<?php $attributes = $__attributesOriginal6541145ad4a57bfb6e6f221ba77eb386; ?>
<?php unset($__attributesOriginal6541145ad4a57bfb6e6f221ba77eb386); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6541145ad4a57bfb6e6f221ba77eb386)): ?>
<?php $component = $__componentOriginal6541145ad4a57bfb6e6f221ba77eb386; ?>
<?php unset($__componentOriginal6541145ad4a57bfb6e6f221ba77eb386); ?>
<?php endif; ?>
                            
                            <?php if(auth()->user()->isCustomer()): ?>
                                <?php if (isset($component)) { $__componentOriginalff467597409d3d5104c229cfe35ec26e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalff467597409d3d5104c229cfe35ec26e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cart-icon','data' => ['count' => app(\App\Services\CartService::class)->getCartCount()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cart-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['count' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(app(\App\Services\CartService::class)->getCartCount())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalff467597409d3d5104c229cfe35ec26e)): ?>
<?php $attributes = $__attributesOriginalff467597409d3d5104c229cfe35ec26e; ?>
<?php unset($__attributesOriginalff467597409d3d5104c229cfe35ec26e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalff467597409d3d5104c229cfe35ec26e)): ?>
<?php $component = $__componentOriginalff467597409d3d5104c229cfe35ec26e; ?>
<?php unset($__componentOriginalff467597409d3d5104c229cfe35ec26e); ?>
<?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-gray-900">
                                <div class="w-8 h-8 rounded-full bg-orange-500 flex items-center justify-center text-white font-semibold">
                                    <?php echo e(substr(auth()->user()->name, 0, 1)); ?>

                                </div>
                                <span class="hidden md:block"><?php echo e(auth()->user()->name); ?></span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Flash Messages -->
        <?php if(session('success')): ?>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'success','dismissible' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'success','dismissible' => true]); ?>
                    <?php echo e(session('success')); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'error','dismissible' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'error','dismissible' => true]); ?>
                    <?php echo e(session('error')); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Page Content -->
        <main class="py-8">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <p class="text-center text-sm text-gray-500">
                    &copy; <?php echo e(date('Y')); ?> FoodDelivery. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\laravel again\food-delivery\resources\views/layouts/app.blade.php ENDPATH**/ ?>
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['count' => 0]));

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

foreach (array_filter((['count' => 0]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div x-data="{
    open: false,
    unreadCount: <?php echo e($count); ?>,
    notifications: [],
    
    async fetchNotifications() {
        try {
            const response = await fetch('<?php echo e(route('notifications.index')); ?>');
            const html = await response.text();
            // Extract notifications from response (simplified)
        } catch (error) {
            console.error('Failed to fetch notifications:', error);
        }
    },
    
    async markAsRead(id) {
        try {
            await fetch(`/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Content-Type': 'application/json'
                }
            });
            this.unreadCount = Math.max(0, this.unreadCount - 1);
        } catch (error) {
            console.error('Failed to mark notification as read:', error);
        }
    },
    
    async markAllAsRead() {
        try {
            await fetch('<?php echo e(route('notifications.readAll')); ?>', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Content-Type': 'application/json'
                }
            });
            this.unreadCount = 0;
            this.open = false;
        } catch (error) {
            console.error('Failed to mark all as read:', error);
        }
    }
}" class="relative">
    
    <button @click="open = !open" class="relative p-2 text-gray-600 hover:text-gray-900 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        
        
        <span x-show="unreadCount > 0" 
              x-text="unreadCount" 
              class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
        </span>
    </button>

    
    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50"
         style="display: none;">
        
        
        <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
            <button @click="markAllAsRead()" class="text-xs text-orange-600 hover:text-orange-700">
                Mark all as read
            </button>
        </div>

        
        <div class="max-h-96 overflow-y-auto">
            <?php $__empty_1 = true; $__currentLoopData = auth()->user()->notifications()->take(5)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e($notification->data['action_url'] ?? '#'); ?>" 
                   @click="markAsRead('<?php echo e($notification->id); ?>')"
                   class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100 <?php echo e($notification->read_at ? 'bg-white' : 'bg-blue-50'); ?>">
                    <div class="flex items-start">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">
                                <?php echo e($notification->data['title'] ?? 'Notification'); ?>

                            </p>
                            <p class="text-sm text-gray-600 mt-1">
                                <?php echo e($notification->data['message'] ?? ''); ?>

                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                <?php echo e($notification->created_at->diffForHumans()); ?>

                            </p>
                        </div>
                        <?php if(!$notification->read_at): ?>
                            <div class="ml-2 mt-1">
                                <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="px-4 py-8 text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <p class="text-sm">No notifications</p>
                </div>
            <?php endif; ?>
        </div>

        
        <?php if(auth()->user()->notifications()->count() > 0): ?>
            <div class="px-4 py-3 border-t border-gray-200">
                <a href="<?php echo e(route('notifications.index')); ?>" class="text-sm text-orange-600 hover:text-orange-700 font-medium">
                    View all notifications
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH D:\laravel again\food-delivery\resources\views/components/notification-bell.blade.php ENDPATH**/ ?>
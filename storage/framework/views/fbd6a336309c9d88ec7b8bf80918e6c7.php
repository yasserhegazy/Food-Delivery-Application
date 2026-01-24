<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['name', 'label', 'current' => null, 'accept' => 'image/*', 'maxSize' => '2MB']));

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

foreach (array_filter((['name', 'label', 'current' => null, 'accept' => 'image/*', 'maxSize' => '2MB']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div x-data="{ 
    preview: '<?php echo e($current); ?>',
    dragging: false,
    handleFiles(files) {
        if (files.length > 0) {
            const file = files[0];
            const reader = new FileReader();
            reader.onload = (e) => {
                this.preview = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
}" class="space-y-2">
    <?php if($label): ?>
        <label class="block text-sm font-medium text-gray-700"><?php echo e($label); ?></label>
    <?php endif; ?>
    
    <div 
        @dragover.prevent="dragging = true"
        @dragleave.prevent="dragging = false"
        @drop.prevent="dragging = false; handleFiles($event.dataTransfer.files); $refs.fileInput.files = $event.dataTransfer.files"
        :class="{ 'border-orange-500 bg-orange-50': dragging }"
        class="relative border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-orange-400 transition-colors cursor-pointer group">
        
        <input 
            type="file" 
            name="<?php echo e($name); ?>" 
            id="<?php echo e($name); ?>"
            accept="<?php echo e($accept); ?>"
            x-ref="fileInput"
            @change="handleFiles($event.target.files)"
            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
        
        <div x-show="!preview" class="space-y-2">
            <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-orange-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <div class="text-sm text-gray-600">
                <span class="font-medium text-orange-600 group-hover:text-orange-700">Click to upload</span> or drag and drop
            </div>
            <p class="text-xs text-gray-500">PNG, JPG, GIF up to <?php echo e($maxSize); ?></p>
        </div>
        
        <div x-show="preview" x-cloak class="relative">
            <img :src="preview" alt="Preview" class="mx-auto max-h-48 rounded-lg shadow-md">
            <button 
                type="button"
                @click.stop="preview = null; $refs.fileInput.value = ''"
                class="absolute top-2 right-2 bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
    
    <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="text-sm text-red-600 flex items-center gap-1">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <?php echo e($message); ?>

        </p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
<?php /**PATH D:\laravel again\food-delivery\resources\views/components/image-upload.blade.php ENDPATH**/ ?>
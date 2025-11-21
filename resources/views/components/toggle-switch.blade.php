@props(['name', 'label' => null, 'checked' => false, 'disabled' => false])

<div class="flex items-center justify-between">
    @if($label)
        <label for="{{ $name }}" class="text-sm font-medium text-gray-700">{{ $label }}</label>
    @endif
    
    <button 
        type="button"
        role="switch"
        :aria-checked="checked"
        @click="checked = !checked"
        x-data="{ checked: {{ $checked ? 'true' : 'false' }} }"
        :class="{ 'bg-orange-500': checked, 'bg-gray-200': !checked }"
        {{ $disabled ? 'disabled' : '' }}
        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
        
        <span 
            :class="{ 'translate-x-5': checked, 'translate-x-0': !checked }"
            class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out">
        </span>
        
        <input 
            type="hidden" 
            name="{{ $name }}" 
            :value="checked ? '1' : '0'"
            x-ref="input">
    </button>
</div>

@props(['status' => 'active'])

@php
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
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$classes}"]) }}>
    {{ $slot->isEmpty() ? $label : $slot }}
</span>

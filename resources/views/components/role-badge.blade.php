@props(['role'])

@php
$config = match($role) {
    'admin' => ['class' => 'bg-purple-100 text-purple-800', 'label' => 'Admin'],
    'restaurant_owner' => ['class' => 'bg-orange-100 text-orange-800', 'label' => 'Restaurant Owner'],
    'driver' => ['class' => 'bg-green-100 text-green-800', 'label' => 'Driver'],
    'customer' => ['class' => 'bg-blue-100 text-blue-800', 'label' => 'Customer'],
    default => ['class' => 'bg-gray-100 text-gray-800', 'label' => ucfirst($role)]
};
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$config['class']}"]) }}>
    {{ $slot->isEmpty() ? $config['label'] : $slot }}
</span>

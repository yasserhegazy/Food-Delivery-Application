@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Menu Items</h1>
                <p class="mt-2 text-gray-600">Manage your restaurant's menu</p>
            </div>
            <a href="{{ route('restaurant.menu.create') }}">
                <x-button variant="primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Menu Item
                </x-button>
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
            <form method="GET" class="flex items-end gap-4">
                <div class="flex-1">
                    <x-input 
                        name="search" 
                        label="Search" 
                        placeholder="Search menu items..."
                        :value="request('search')" />
                </div>
                <div class="w-64">
                    <x-select 
                        name="category_id" 
                        label="Category"
                        :options="$categories->pluck('name', 'id')->toArray()"
                        :selected="request('category_id')"
                        placeholder="All categories" />
                </div>
                <x-button type="submit" variant="secondary">Filter</x-button>
                @if(request()->hasAny(['search', 'category_id']))
                    <a href="{{ route('restaurant.menu.index') }}" class="text-gray-600 hover:text-gray-900">Clear</a>
                @endif
            </form>
        </div>

        @if($menuItems->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($menuItems as $item)
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition">
                        <!-- Image -->
                        <div class="relative h-48 bg-gray-200">
                            @if($item->image)
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Badges -->
                            <div class="absolute top-2 left-2 flex flex-col gap-2">
                                @if($item->is_featured)
                                    <span class="bg-orange-500 text-white px-2 py-1 rounded-full text-xs font-semibold">Featured</span>
                                @endif
                                @if($item->has_discount)
                                    <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">Sale</span>
                                @endif
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900">{{ $item->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $item->category->name }}</p>
                                </div>
                                <button 
                                    onclick="toggleAvailability({{ $item->id }})"
                                    class="availability-toggle"
                                    data-item-id="{{ $item->id }}">
                                    @if($item->is_available)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Available
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Unavailable
                                        </span>
                                    @endif
                                </button>
                            </div>

                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $item->description }}</p>

                            <div class="flex items-center justify-between">
                                <div>
                                    @if($item->has_discount)
                                        <span class="text-lg font-bold text-orange-600">${{ number_format($item->final_price, 2) }}</span>
                                        <span class="text-sm text-gray-400 line-through ml-2">${{ number_format($item->price, 2) }}</span>
                                    @else
                                        <span class="text-lg font-bold text-gray-900">${{ number_format($item->price, 2) }}</span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2">
                                    <a href="{{ route('restaurant.menu.edit', $item) }}" class="text-orange-600 hover:text-orange-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('restaurant.menu.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $menuItems->links() }}
        @else
            <x-empty-state 
                title="No menu items yet"
                message="Start building your menu by adding your first item."
                icon="document"
                :actionUrl="route('restaurant.menu.create')"
                actionText="Add Menu Item" />
        @endif
    </div>
</div>

@push('scripts')
<script>
function toggleAvailability(itemId) {
    fetch(`/restaurant/menu/${itemId}/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>
@endpush
@endsection

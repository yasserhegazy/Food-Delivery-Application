@extends('layouts.app')

@section('title', 'Admin Dashboard Analytics')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header with Date Filter --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Analytics</h1>
            <p class="text-gray-600 mt-1">Platform performance and insights</p>
        </div>
        
        <div>
            <form method="GET" action="{{ route('admin.dashboard') }}" class="flex gap-2">
                <select name="period" onchange="this.form.submit()" class="rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500">
                    <option value="7" {{ $period == '7' ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="30" {{ $period == '30' ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="90" {{ $period == '90' ? 'selected' : '' }}>Last 90 Days</option>
                    <option value="year" {{ $period == 'year' ? 'selected' : '' }}>This Year</option>
                </select>
            </form>
        </div>
    </div>

    {{-- Key Metrics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Total Revenue --}}
        <x-card>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">${{ number_format($stats['total_revenue'], 2) }}</p>
                    <p class="text-sm mt-1 {{ $stats['revenue_change'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $stats['revenue_change'] >= 0 ? '+' : '' }}{{ $stats['revenue_change'] }}% from previous period
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </x-card>

        {{-- Total Orders --}}
        <x-card>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_orders']) }}</p>
                    <p class="text-sm mt-1 {{ $stats['orders_change'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $stats['orders_change'] >= 0 ? '+' : '' }}{{ $stats['orders_change'] }}% from previous period
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </x-card>

        {{-- Total Users --}}
        <x-card>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_users']) }}</p>
                    <p class="text-sm mt-1 text-gray-500">All platform users</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </x-card>

        {{-- Avg Order Value --}}
        <x-card>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Avg Order Value</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">${{ number_format($stats['avg_order_value'], 2) }}</p>
                    <p class="text-sm mt-1 text-gray-500">Per order average</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
        </x-card>
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Revenue Chart --}}
        <x-card title="Revenue Trend">
            <canvas id="revenueChart" height="300"></canvas>
        </x-card>

        {{-- Order Status Chart --}}
        <x-card title="Order Status Breakdown">
            <canvas id="orderStatusChart" height="300"></canvas>
        </x-card>
    </div>

    {{-- Popular Restaurants Table --}}
    @if($popularRestaurants->count() > 0)
    <x-card title="Popular Restaurants" class="mb-8">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Restaurant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Orders</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Revenue</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg Order</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($popularRestaurants as $restaurant)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ $restaurant->name }}</div>
                            <div class="text-sm text-gray-500">{{ $restaurant->city }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $restaurant->orders_count }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                            ${{ number_format($restaurant->total_revenue, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${{ $restaurant->orders_count > 0 ? number_format($restaurant->total_revenue / $restaurant->orders_count, 2) : '0.00' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>
    @endif

    {{-- Popular Menu Items Table --}}
    @if($popularMenuItems->count() > 0)
    <x-card title="Popular Menu Items">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Restaurant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Sold</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($popularMenuItems as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ $item->name }}</div>
                            <div class="text-sm text-gray-500">${{ number_format($item->price, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $item->category->restaurant->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                            {{ $item->total_sold }} units
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                            ${{ number_format($item->total_revenue, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>
    @endif
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: @json($revenueByPeriod->pluck('date')),
            datasets: [{
                label: 'Revenue ($)',
                data: @json($revenueByPeriod->pluck('revenue')),
                borderColor: 'rgb(249, 115, 22)',
                backgroundColor: 'rgba(249, 115, 22, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Order Status Chart
    const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
    const orderStats = @json($orderStatistics);
    new Chart(orderStatusCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(orderStats).map(status => status.replace('_', ' ').toUpperCase()),
            datasets: [{
                data: Object.values(orderStats),
                backgroundColor: [
                    'rgb(59, 130, 246)',   // blue
                    'rgb(16, 185, 129)',   // green
                    'rgb(249, 115, 22)',   // orange
                    'rgb(139, 92, 246)',   // purple
                    'rgb(236, 72, 153)',   // pink
                    'rgb(34, 197, 94)',    // lime
                    'rgb(239, 68, 68)'     // red
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
</script>
@endsection

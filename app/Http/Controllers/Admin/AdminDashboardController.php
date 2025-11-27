<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Display admin dashboard with analytics.
     */
    public function index(Request $request)
    {
        // Get date range from request or default to last 30 days
        $period = $request->get('period', '30');
        $endDate = Carbon::now();
        
        $startDate = match($period) {
            '7' => Carbon::now()->subDays(7),
            '30' => Carbon::now()->subDays(30),
            '90' => Carbon::now()->subDays(90),
            'year' => Carbon::now()->startOfYear(),
            default => Carbon::now()->subDays(30),
        };

        // Calculate previous period start date
        $previousStartDate = match($period) {
            '7' => $startDate->copy()->subDays(7),
            '30' => $startDate->copy()->subDays(30),
            '90' => $startDate->copy()->subDays(90),
            'year' => Carbon::now()->subYear()->startOfYear(),
            default => $startDate->copy()->subDays(30),
        };

        // Calculate key metrics
        $totalRevenue = $this->getTotalRevenue($startDate, $endDate);
        $previousRevenue = $this->getTotalRevenue($previousStartDate, $startDate);
        $revenueChange = $previousRevenue > 0 ? (($totalRevenue - $previousRevenue) / $previousRevenue) * 100 : 0;

        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        $previousOrders = Order::whereBetween('created_at', [$previousStartDate, $startDate])->count();
        $ordersChange = $previousOrders > 0 ? (($totalOrders - $previousOrders) / $previousOrders) * 100 : 0;

        $stats = [
            'total_revenue' => $totalRevenue,
            'revenue_change' => round($revenueChange, 1),
            'total_orders' => $totalOrders,
            'orders_change' => round($ordersChange, 1),
            'total_users' => User::count(),
            'total_restaurants' => Restaurant::count(),
            'avg_order_value' => $totalOrders > 0 ? $totalRevenue / $totalOrders : 0,
        ];

        // Get analytics data
        $revenueByPeriod = $this->getRevenueByPeriod($startDate, $endDate);
        $orderStatistics = $this->getOrderStatistics($startDate, $endDate);
        $popularRestaurants = $this->getPopularRestaurants($startDate, $endDate);
        $popularMenuItems = $this->getPopularMenuItems($startDate, $endDate);
        $userGrowth = $this->getUserGrowth($startDate, $endDate);

        return view('admin.dashboard', compact(
            'stats',
            'revenueByPeriod',
            'orderStatistics',
            'popularRestaurants',
            'popularMenuItems',
            'userGrowth',
            'period'
        ));
    }

    /**
     * Get total revenue for a period.
     */
    private function getTotalRevenue($startDate, $endDate)
    {
        return Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['delivered'])
            ->sum('total_amount');
    }

    /**
     * Get order statistics by status.
     */
    private function getOrderStatistics($startDate, $endDate)
    {
        return Order::whereBetween('created_at', [$startDate, $endDate])
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
    }

    /**
     * Get revenue by period (daily).
     */
    private function getRevenueByPeriod($startDate, $endDate)
    {
        return Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['delivered'])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Get popular restaurants.
     */
    private function getPopularRestaurants($startDate, $endDate, $limit = 5)
    {
        return Restaurant::withCount(['orders' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->with(['orders' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->whereIn('status', ['delivered']);
            }])
            ->having('orders_count', '>', 0)
            ->orderBy('orders_count', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($restaurant) {
                $restaurant->total_revenue = $restaurant->orders->sum('total_amount');
                return $restaurant;
            });
    }

    /**
     * Get popular menu items.
     */
    private function getPopularMenuItems($startDate, $endDate, $limit = 10)
    {
        return MenuItem::join('order_items', 'menu_items.id', '=', 'order_items.menu_item_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select(
                'menu_items.id',
                'menu_items.category_id',
                'menu_items.name',
                'menu_items.price',
                'menu_items.description',
                'menu_items.image',
                'menu_items.is_available',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue')
            )
            ->with('category.restaurant')
            ->groupBy(
                'menu_items.id',
                'menu_items.category_id',
                'menu_items.name',
                'menu_items.price',
                'menu_items.description',
                'menu_items.image',
                'menu_items.is_available'
            )
            ->orderBy('total_sold', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get user growth data.
     */
    private function getUserGrowth($startDate, $endDate)
    {
        return User::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }
}

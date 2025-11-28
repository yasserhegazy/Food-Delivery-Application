<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Restaurant\RestaurantDashboardController;
use App\Http\Controllers\Driver\DriverDashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Public restaurant routes
Route::get('/restaurants', [App\Http\Controllers\PublicRestaurantController::class, 'index'])->name('restaurants.index');
Route::get('/restaurants/search', [App\Http\Controllers\PublicRestaurantController::class, 'search'])->name('restaurants.search');
Route::get('/restaurants/suggestions', [App\Http\Controllers\PublicRestaurantController::class, 'suggestions'])->name('restaurants.suggestions');
Route::get('/restaurants/filters', [App\Http\Controllers\PublicRestaurantController::class, 'filters'])->name('restaurants.filters');
Route::get('/restaurants/{restaurant}/categories/{category}', [App\Http\Controllers\PublicRestaurantController::class, 'categoryItems'])->name('restaurants.category-items');
Route::get('/restaurants/{slug}', [App\Http\Controllers\PublicRestaurantController::class, 'show'])->name('restaurants.show');


// Guest routes (authentication)
Route::middleware('guest')->group(function () {

    
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Main dashboard route (redirects to role-specific dashboard)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Notification routes (all authenticated users)
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::get('/notifications/unread-count', [App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('notifications.unreadCount');
    
    // Customer routes
    Route::middleware(CheckRole::class . ':customer')->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
        
        // Cart routes
        Route::get('/cart', [App\Http\Controllers\Customer\CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [App\Http\Controllers\Customer\CartController::class, 'add'])->name('cart.add');
        Route::delete('/cart/clear', [App\Http\Controllers\Customer\CartController::class, 'clear'])->name('cart.clear');
        Route::patch('/cart/{item}', [App\Http\Controllers\Customer\CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{item}', [App\Http\Controllers\Customer\CartController::class, 'remove'])->name('cart.remove');
        
        // Rating routes
        Route::post('/restaurants/{restaurant}/rate', [App\Http\Controllers\Customer\RatingController::class, 'store'])->name('restaurants.rate');
        Route::patch('/ratings/{rating}', [App\Http\Controllers\Customer\RatingController::class, 'update'])->name('ratings.update');
        Route::delete('/ratings/{rating}', [App\Http\Controllers\Customer\RatingController::class, 'destroy'])->name('ratings.destroy');

        // Address routes
        Route::resource('addresses', App\Http\Controllers\Customer\AddressController::class);

        // Checkout routes
        Route::get('/checkout', [App\Http\Controllers\Customer\CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [App\Http\Controllers\Customer\CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/checkout/success/{order}', [App\Http\Controllers\Customer\CheckoutController::class, 'success'])->name('checkout.success');

        // Order routes
        Route::get('/orders', [App\Http\Controllers\Customer\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [App\Http\Controllers\Customer\OrderController::class, 'show'])->name('orders.show');
    });
    
    // Restaurant owner routes
    Route::middleware(CheckRole::class . ':restaurant_owner')->prefix('restaurant')->name('restaurant.')->group(function () {
        Route::get('/dashboard', [RestaurantDashboardController::class, 'index'])->name('dashboard');
        
        // Restaurant Profile
        Route::get('/profile/edit', [App\Http\Controllers\Restaurant\RestaurantProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [App\Http\Controllers\Restaurant\RestaurantProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/logo', [App\Http\Controllers\Restaurant\RestaurantProfileController::class, 'uploadLogo'])->name('profile.logo');
        Route::post('/profile/cover', [App\Http\Controllers\Restaurant\RestaurantProfileController::class, 'uploadCover'])->name('profile.cover');
        
        // Categories
        Route::resource('categories', App\Http\Controllers\Restaurant\CategoryController::class);
        Route::post('/categories/reorder', [App\Http\Controllers\Restaurant\CategoryController::class, 'reorder'])->name('categories.reorder');
        
        // Menu Items
        // Menu Items
        Route::resource('menu', App\Http\Controllers\Restaurant\MenuItemController::class);
        Route::post('/menu/{menuItem}/toggle', [App\Http\Controllers\Restaurant\MenuItemController::class, 'toggleAvailability'])->name('menu.toggle');

        // Orders
        Route::get('/orders', [App\Http\Controllers\Restaurant\RestaurantOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [App\Http\Controllers\Restaurant\RestaurantOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [App\Http\Controllers\Restaurant\RestaurantOrderController::class, 'updateStatus'])->name('orders.status');
    });
    
    // Driver routes
    Route::middleware(CheckRole::class . ':driver')->prefix('driver')->name('driver.')->group(function () {
        Route::get('/dashboard', [DriverDashboardController::class, 'index'])->name('dashboard');
        Route::get('/deliveries/available', [DriverDashboardController::class, 'availableDeliveries'])->name('deliveries.available');
        Route::get('/deliveries/my-deliveries', [DriverDashboardController::class, 'myDeliveries'])->name('deliveries.my');
        Route::post('/deliveries/{order}/accept', [DriverDashboardController::class, 'acceptDelivery'])->name('deliveries.accept');
        Route::patch('/deliveries/{order}/status', [DriverDashboardController::class, 'updateDeliveryStatus'])->name('deliveries.status');
        Route::get('/deliveries/{order}', [DriverDashboardController::class, 'show'])->name('deliveries.show');
    });
    
    // Admin routes
    Route::middleware(CheckRole::class . ':admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // User Management (Full CRUD)
        Route::resource('users', App\Http\Controllers\Admin\UserController::class)->except(['create', 'store']);
        Route::post('/users/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
        
        // Restaurant Viewing (Read-only)
        Route::get('/restaurants', [App\Http\Controllers\Admin\RestaurantController::class, 'index'])->name('restaurants.index');
        Route::get('/restaurants/{restaurant}', [App\Http\Controllers\Admin\RestaurantController::class, 'show'])->name('restaurants.show');
        
        // Category Viewing (Read-only)
        Route::get('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories.index');
        
        // Menu Items Viewing (Read-only)
        Route::get('/menu-items', [App\Http\Controllers\Admin\MenuItemController::class, 'index'])->name('menu-items.index');
    });
});

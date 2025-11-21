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
    
    // Customer routes
    Route::middleware(CheckRole::class . ':customer')->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
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
        Route::resource('menu', App\Http\Controllers\Restaurant\MenuItemController::class);
        Route::post('/menu/{menuItem}/toggle', [App\Http\Controllers\Restaurant\MenuItemController::class, 'toggleAvailability'])->name('menu.toggle');
    });
    
    // Driver routes
    Route::middleware(CheckRole::class . ':driver')->prefix('driver')->name('driver.')->group(function () {
        Route::get('/dashboard', [DriverDashboardController::class, 'index'])->name('dashboard');
    });
    
    // Admin routes
    Route::middleware(CheckRole::class . ':admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    });
});

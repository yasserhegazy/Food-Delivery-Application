# 🍔 Food Delivery Application

A comprehensive full-stack food delivery platform built with Laravel and modern web technologies. This application enables customers to order food from multiple restaurants, track deliveries in real-time, and provides powerful analytics for administrators.

![Laravel](https://img.shields.io/badge/Laravel-12.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange?style=flat-square&logo=mysql)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?style=flat-square&logo=tailwind-css)

## 📋 Table of Contents

-   [Features](#-features)
-   [Tech Stack](#-tech-stack)
-   [Installation](#-installation)
-   [Database Setup](#-database-setup)
-   [Seeding Data](#-seeding-data)
-   [User Roles](#-user-roles)
-   [Project Structure](#-project-structure)
-   [Key Features by Role](#-key-features-by-role)
-   [API Endpoints](#-api-endpoints)
-   [Screenshots](#-screenshots)
-   [Contributing](#-contributing)
-   [License](#-license)

## ✨ Features

### For Customers

-   🔍 Browse restaurants by cuisine, location, and ratings
-   🛒 Shopping cart with real-time updates
-   📍 Multiple delivery addresses management
-   💳 Secure checkout process
-   📦 Order tracking with real-time status updates
-   🔔 In-app notifications for order updates
-   ⭐ Rate and review restaurants
-   📜 Order history

### For Restaurant Owners

-   🏪 Restaurant profile management
-   📋 Menu and category management
-   🖼️ Menu item images
-   📊 Order management dashboard
-   🔄 Real-time order status updates
-   📈 Sales analytics
-   🔔 Notifications for new orders

### For Drivers

-   🚗 Available delivery requests
-   📍 Delivery address details
-   ✅ Accept/complete deliveries
-   📊 Delivery history
-   🔔 Notifications for new delivery opportunities

### For Administrators

-   📊 Comprehensive analytics dashboard
-   📈 Revenue tracking with charts
-   👥 User management
-   🏪 Restaurant approval and management
-   📉 Order statistics
-   🎯 Popular items and restaurants tracking
-   📅 Date range filtering (7/30/90 days, year)

## 🛠️ Tech Stack

### Backend

-   **Framework**: Laravel 12.x
-   **Language**: PHP 8.2+
-   **Database**: MySQL 8.0+
-   **Authentication**: Laravel Breeze
-   **Notifications**: Laravel Database Notifications

### Frontend

-   **CSS Framework**: TailwindCSS 3.x
-   **JavaScript**: Alpine.js
-   **Charts**: Chart.js
-   **Icons**: Heroicons

### Development Tools

-   **Package Manager**: Composer, NPM
-   **Build Tool**: Vite
-   **Version Control**: Git

## 📥 Installation

### Prerequisites

-   PHP 8.2 or higher
-   Composer
-   Node.js & NPM
-   MySQL 8.0 or higher
-   Git

### Step 1: Clone the Repository

```bash
git clone https://github.com/yasserhegazy/Food-Delivery-Application.git
cd Food-Delivery-Application
```

### Step 2: Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### Step 3: Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Configure Database

Edit `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=food_delivery
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Step 5: Run Migrations

```bash
php artisan migrate
```

### Step 6: Seed Database

```bash
# Seed with dummy data (recommended for testing)
php artisan db:seed --class=DummyDataSeeder

# Or seed all seeders
php artisan db:seed
```

### Step 7: Create Storage Link

```bash
php artisan storage:link
```

### Step 8: Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### Step 9: Start Development Server

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## 🗄️ Database Setup

### Migrations

The application includes migrations for:

-   Users (with roles)
-   Restaurants
-   Categories
-   Menu Items
-   Addresses
-   Orders & Order Items
-   Restaurant Ratings
-   Notifications

### Seeders

#### DummyDataSeeder

Generates comprehensive test data:

-   **95 Users** (50 customers, 15 drivers, 20 restaurant owners, 1 admin)
-   **25 Restaurants** with varied cuisines
-   **248 Categories** across restaurants
-   **6,000+ Menu Items** with realistic prices
-   **200+ Addresses** for customers
-   **500-1000 Orders** spread over 90 days
-   **2,000+ Order Items**
-   **100-200 Restaurant Ratings**

```bash
php artisan db:seed --class=DummyDataSeeder
```

#### AdminUserSeeder

Creates a default admin account:

```
Email: admin@fooddelivery.com
Password: password
```

```bash
php artisan db:seed --class=AdminUserSeeder
```

## 👥 User Roles

### 1. Customer

-   Browse and order from restaurants
-   Manage delivery addresses
-   Track orders
-   Rate restaurants

### 2. Restaurant Owner

-   Manage restaurant profile
-   Create and update menu items
-   Process orders
-   View analytics

### 3. Driver

-   View available deliveries
-   Accept delivery requests
-   Update delivery status

### 4. Admin

-   Full platform access
-   User management
-   Analytics dashboard
-   Restaurant approval

## 📁 Project Structure

```
food-delivery/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   └── AdminDashboardController.php
│   │   │   ├── Customer/
│   │   │   │   ├── CheckoutController.php
│   │   │   │   └── RestaurantController.php
│   │   │   ├── Driver/
│   │   │   │   └── DriverDashboardController.php
│   │   │   ├── Restaurant/
│   │   │   │   ├── MenuItemController.php
│   │   │   │   └── RestaurantOrderController.php
│   │   │   └── NotificationController.php
│   │   └── Middleware/
│   │       └── CheckRole.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Restaurant.php
│   │   ├── Category.php
│   │   ├── MenuItem.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   ├── Address.php
│   │   └── RestaurantRating.php
│   ├── Notifications/
│   │   ├── OrderPlaced.php
│   │   ├── OrderStatusChanged.php
│   │   └── NewDeliveryAvailable.php
│   └── Services/
│       └── CartService.php
├── database/
│   ├── factories/
│   │   ├── RestaurantFactory.php
│   │   ├── CategoryFactory.php
│   │   ├── MenuItemFactory.php
│   │   ├── AddressFactory.php
│   │   └── RestaurantRatingFactory.php
│   ├── migrations/
│   └── seeders/
│       ├── DummyDataSeeder.php
│       └── AdminUserSeeder.php
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   │   └── dashboard.blade.php
│   │   ├── customer/
│   │   ├── driver/
│   │   ├── restaurant/
│   │   ├── components/
│   │   │   ├── notification-bell.blade.php
│   │   │   └── cart-icon.blade.php
│   │   └── notifications/
│   │       └── index.blade.php
│   └── css/
│       └── app.css
└── routes/
    └── web.php
```

## 🎯 Key Features by Role

### Customer Features

| Feature           | Description                         |
| ----------------- | ----------------------------------- |
| Restaurant Browse | Filter by cuisine, city, rating     |
| Menu View         | Browse categories and items         |
| Shopping Cart     | Add/remove items, update quantities |
| Checkout          | Select address, place order         |
| Order Tracking    | Real-time status updates            |
| Notifications     | Order status changes                |
| Ratings           | Rate restaurants after delivery     |

### Restaurant Owner Features

| Feature            | Description                              |
| ------------------ | ---------------------------------------- |
| Profile Management | Update restaurant details                |
| Menu Management    | CRUD operations for categories and items |
| Order Dashboard    | View and manage incoming orders          |
| Status Updates     | Update order preparation status          |
| Analytics          | View sales and popular items             |

### Driver Features

| Feature           | Description                  |
| ----------------- | ---------------------------- |
| Available Orders  | View ready-for-pickup orders |
| Accept Delivery   | Claim delivery assignments   |
| Complete Delivery | Mark orders as delivered     |
| History           | View past deliveries         |

### Admin Features

| Feature             | Description                            |
| ------------------- | -------------------------------------- |
| Analytics Dashboard | Revenue, orders, user growth           |
| Charts              | Revenue trends, order status breakdown |
| Popular Items       | Top restaurants and menu items         |
| User Management     | Manage all platform users              |
| Date Filtering      | 7/30/90 days, year-to-date             |

## 🔌 API Endpoints

### Authentication

```
POST   /register
POST   /login
POST   /logout
```

### Customer

```
GET    /restaurants
GET    /restaurants/{slug}
POST   /cart/add
POST   /cart/remove
GET    /checkout
POST   /checkout
GET    /orders
GET    /orders/{id}
```

### Restaurant Owner

```
GET    /restaurant/dashboard
GET    /restaurant/menu
POST   /restaurant/menu-items
PUT    /restaurant/menu-items/{id}
DELETE /restaurant/menu-items/{id}
GET    /restaurant/orders
POST   /restaurant/orders/{id}/status
```

### Driver

```
GET    /driver/dashboard
GET    /driver/available-deliveries
POST   /driver/accept/{orderId}
POST   /driver/complete/{orderId}
```

### Admin

```
GET    /admin/dashboard
GET    /admin/users
GET    /admin/restaurants
POST   /admin/restaurants/{id}/approve
```

### Notifications

```
GET    /notifications
POST   /notifications/{id}/read
POST   /notifications/read-all
GET    /notifications/unread-count
```

## 📸 Screenshots

### Customer Dashboard

Browse restaurants, view menus, and place orders with an intuitive interface.

### Restaurant Dashboard

Manage menu items, process orders, and track performance.

### Admin Analytics

Comprehensive analytics with Chart.js visualizations showing revenue trends, order statistics, and popular items.

### Notifications

Real-time in-app notifications for order updates and delivery status changes.

## 🚀 Deployment

### Production Checklist

-   [ ] Set `APP_ENV=production` in `.env`
-   [ ] Set `APP_DEBUG=false` in `.env`
-   [ ] Configure production database
-   [ ] Run `php artisan config:cache`
-   [ ] Run `php artisan route:cache`
-   [ ] Run `php artisan view:cache`
-   [ ] Run `npm run build`
-   [ ] Set up SSL certificate
-   [ ] Configure queue workers
-   [ ] Set up cron jobs for scheduled tasks

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 👨‍💻 Author

**Yasser Hegazy**

-   GitHub: [@yasserhegazy](https://github.com/yasserhegazy)

## 🙏 Acknowledgments

-   Laravel Framework
-   TailwindCSS
-   Chart.js
-   Alpine.js
-   All contributors and supporters

---

**Note**: This is a learning/portfolio project. For production use, ensure proper security measures, testing, and optimization.

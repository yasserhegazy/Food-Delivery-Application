# 🍔 Food Delivery Application

**A production-ready, full-stack food delivery platform with multi-role access, real-time order tracking, and comprehensive analytics — built with Laravel 12 and modern web technologies.**

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)](https://alpinejs.dev)
[![Tests](https://img.shields.io/badge/Tests-26_passing-brightgreen?style=for-the-badge&logo=testinglibrary&logoColor=white)](#-testing)
[![License](https://img.shields.io/badge/License-MIT-blue?style=for-the-badge)](LICENSE)

---

## 📋 Table of Contents

- [Demo Screenshots](#-demo-screenshots)
- [Feature Highlights](#-feature-highlights)
- [Tech Stack](#-tech-stack)
- [Architecture Overview](#-architecture-overview)
- [Quick Start](#-quick-start)
- [Full Installation Guide](#-full-installation-guide)
- [Database & Seeding](#-database--seeding)
- [Testing](#-testing)
- [New Features](#-new-features)
- [Project Structure](#-project-structure)
- [API Routes Reference](#-api-routes-reference)
- [Deployment Checklist](#-deployment-checklist)
- [Technical Highlights](#-technical-highlights)
- [Contributing](#-contributing)
- [License](#-license)

---

## 📸 Demo Screenshots

> **Note:** Add your own screenshots to a `screenshots/` directory to showcase the app visually.

| View | Screenshot |
|------|-----------|
| 🏠 Customer Dashboard | ![Customer Dashboard](screenshots/customer-dashboard.png) |
| 🍽️ Restaurant Menu | ![Restaurant Menu](screenshots/restaurant-menu.png) |
| 🛒 Cart & Checkout | ![Cart & Checkout](screenshots/cart-checkout.png) |
| 📊 Admin Analytics | ![Admin Dashboard](screenshots/admin-dashboard.png) |
| 🚗 Driver Deliveries | ![Driver Dashboard](screenshots/driver-dashboard.png) |
| 🌙 Dark Mode | ![Dark Mode](screenshots/dark-mode.png) |

---

## ✨ Feature Highlights

### 🛍️ Customer Experience
- 🔍 Browse restaurants by cuisine, city, and rating with **live search & autocomplete suggestions**
- 🛒 Real-time shopping cart powered by Alpine.js
- 📍 Multiple delivery address management (CRUD)
- 💳 Secure checkout with promo code support
- 📦 **Order timeline** — visual step-by-step tracking from placed → delivered
- ❤️ **Favorite restaurants** — save and quickly reorder
- 🎟️ **Promo codes** — percentage & fixed-amount discounts with validation
- ⭐ Rate restaurants and **rate delivery drivers**
- 👤 **Customer profile** with avatar uploads
- 📜 Full order history with filtering
- 🌙 **Dark mode toggle** — system-wide theme switching

### 🏪 Restaurant Owner Tools
- 🖼️ Restaurant profile with logo & cover image uploads
- 📋 Full menu management — categories, items, images, availability toggle
- 🔄 **Category reordering** for menu customization
- 📊 Order management dashboard with real-time status updates
- 📈 Sales analytics and popular item tracking
- 🔔 Instant notifications for new orders

### 🚗 Driver Dashboard
- 📍 Available delivery requests with address details
- ✅ Accept, pick up, and complete deliveries
- ⭐ **Driver rating system** — customers rate delivery experience
- 📊 Delivery history and earnings tracking

### 🛡️ Admin Panel
- 📊 Comprehensive analytics with **Chart.js visualizations**
- 📈 Revenue tracking (7 / 30 / 90 days, year-to-date)
- 👥 Full user management (view, edit, toggle status)
- 🏪 Restaurant & category & menu item oversight
- 🎯 Top restaurants and popular items tracking

---

## 🛠️ Tech Stack

| Layer | Technology | Why |
|-------|-----------|-----|
| **Framework** | Laravel 12.x | Mature PHP framework with elegant ORM, migrations, queues, and built-in testing |
| **Language** | PHP 8.2+ | Modern type system, enums, fibers, and named arguments |
| **Database** | MySQL 8.0+ | Reliable relational DB with JSON support and full-text indexing |
| **Auth** | Laravel Breeze | Lightweight authentication scaffolding with session-based auth |
| **Frontend** | TailwindCSS 3.x | Utility-first CSS for rapid, consistent UI development |
| **Interactivity** | Alpine.js 3.x | Lightweight reactive framework — perfect for cart updates, toggles, and modals without a heavy SPA |
| **Charts** | Chart.js | Canvas-based charting for admin analytics dashboards |
| **Build** | Vite | Blazing-fast HMR and asset bundling for development and production |
| **Icons** | Heroicons | Consistent SVG icon set designed for Tailwind projects |

---

## 🏗️ Architecture Overview

```
┌─────────────────────────────────────────────────────────┐
│                      Browser (Client)                    │
│         TailwindCSS  ·  Alpine.js  ·  Chart.js          │
└──────────────────────────┬──────────────────────────────┘
                           │  HTTP / AJAX
┌──────────────────────────▼──────────────────────────────┐
│                    Laravel 12 Application                │
│                                                          │
│  ┌──────────┐  ┌──────────────┐  ┌───────────────────┐  │
│  │  Routes   │→│  Middleware   │→│    Controllers     │  │
│  │ (web.php) │  │ CheckRole    │  │ Admin / Customer / │  │
│  │          │  │ CheckPerm    │  │ Restaurant / Driver│  │
│  └──────────┘  └──────────────┘  └────────┬──────────┘  │
│                                            │             │
│       ┌────────────────────────────────────┼──────┐      │
│       │                                    │      │      │
│  ┌────▼─────┐  ┌──────────────┐  ┌────────▼───┐  │      │
│  │  Form     │  │   Policies   │  │  Services  │  │      │
│  │ Requests  │  │ (Auth Gates) │  │ CartService│  │      │
│  │ (11 total)│  │ Order/Addr/  │  │ SearchSvc  │  │      │
│  └──────────┘  │ Restaurant   │  └────────────┘  │      │
│                └──────────────┘                   │      │
│       ┌──────────────────────────────────────────┘      │
│       │                                                  │
│  ┌────▼──────┐  ┌──────────────┐  ┌───────────────────┐ │
│  │  Eloquent  │  │Notifications │  │    Blade Views    │ │
│  │  Models    │  │ OrderPlaced  │  │ 24+ components    │ │
│  │ (14 total) │  │ StatusChange │  │ Layouts / Partials│ │
│  └─────┬─────┘  │ NewDelivery  │  └───────────────────┘ │
│        │        └──────────────┘                         │
└────────┼─────────────────────────────────────────────────┘
         │
┌────────▼────────────────────────────────────────────────┐
│                    MySQL 8.0+                            │
│  Users · Restaurants · Categories · MenuItems · Orders   │
│  Favorites · PromoCodes · OrderStatusHistories · Roles   │
│  Permissions · Ratings · CartItems · Addresses           │
│  + Performance indexes on hot columns                    │
└─────────────────────────────────────────────────────────┘
```

**Key architectural decisions:**

- **MVC + Service Layer** — Business logic extracted into `CartService` and `SearchService`, keeping controllers thin
- **Role-Based Access Control** — Custom `CheckRole` and `CheckPermission` middleware with a `roles` / `permissions` / `role_permission` pivot schema
- **Authorization Policies** — `OrderPolicy`, `AddressPolicy`, and `RestaurantPolicy` enforce ownership checks at the model level
- **Form Request Validation** — 11 dedicated request classes (`ApplyPromoCodeRequest`, `StoreOrderRequest`, `MenuItemRequest`, etc.) keep validation out of controllers
- **Notification System** — Laravel database notifications for order events (`OrderPlaced`, `OrderStatusChanged`, `NewDeliveryAvailable`)
- **Factory & Seeder Pattern** — 6 factories + 10 seeders generate realistic test data at scale

---

## ⚡ Quick Start

Get up and running in 5 commands:

```bash
git clone https://github.com/yasserhegazy/Food-Delivery-Application.git
cd Food-Delivery-Application

# Install everything & configure
composer install && npm install
cp .env.example .env && php artisan key:generate

# Set your DB credentials in .env, then:
php artisan migrate --seed && php artisan storage:link

# Launch
npm run dev &
php artisan serve
```

Open **http://localhost:8000** — login with `admin@fooddelivery.com` / `password`.

---

## 📥 Full Installation Guide

### Prerequisites

| Requirement | Version |
|------------|---------|
| PHP | 8.2+ |
| Composer | 2.x |
| Node.js & NPM | 18+ |
| MySQL | 8.0+ |
| Git | 2.x |

### Step 1 — Clone & Install

```bash
git clone https://github.com/yasserhegazy/Food-Delivery-Application.git
cd Food-Delivery-Application

composer install
npm install
```

### Step 2 — Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=food_delivery
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Step 3 — Database & Storage

```bash
php artisan migrate
php artisan db:seed --class=DummyDataSeeder
php artisan storage:link
```

### Step 4 — Build & Serve

```bash
# Development (with HMR)
npm run dev

# In a separate terminal
php artisan serve
```

For production builds:

```bash
npm run build
```

Visit **http://localhost:8000** in your browser.

---

## 🗄️ Database & Seeding

### Schema Overview

The application includes **23 migrations** covering:

| Table | Purpose |
|-------|---------|
| `users` | All users with role associations |
| `roles` / `permissions` / `role_permission` | RBAC system |
| `restaurants` | Restaurant profiles with cuisine & search indexes |
| `categories` | Menu categories per restaurant |
| `menu_items` | Individual food items with pricing |
| `cart_items` | Persistent shopping cart |
| `addresses` | Customer delivery addresses |
| `orders` / `order_items` | Order records and line items |
| `order_status_histories` | **Order timeline** tracking every status change |
| `favorites` | Customer ↔ Restaurant favorites |
| `promo_codes` | Discount codes with usage limits and expiry |
| `restaurant_ratings` | Customer reviews |
| `notifications` | In-app notification store |

### Seeders

| Seeder | What it generates |
|--------|------------------|
| **DummyDataSeeder** | 95 users, 25 restaurants, 248 categories, 6,000+ menu items, 200+ addresses, 500–1,000 orders, 2,000+ order items, 100–200 ratings |
| **AdminUserSeeder** | Default admin (`admin@fooddelivery.com` / `password`) |
| **RolePermissionSeeder** | Roles and permissions setup |
| **PromoCodeSeeder** | Sample promotional codes |
| Individual seeders | `RestaurantSeeder`, `CategorySeeder`, `MenuItemSeeder`, `CustomerUserSeeder`, `DriverSeeder` |

```bash
# Full seed (recommended)
php artisan db:seed --class=DummyDataSeeder

# Just the admin account
php artisan db:seed --class=AdminUserSeeder

# All seeders
php artisan db:seed
```

### Default Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | `admin@fooddelivery.com` | `password` |

> 💡 The `DummyDataSeeder` also creates 50 customers, 15 drivers, and 20 restaurant owners with random credentials.

---

## 🧪 Testing

The project includes a **26-test suite** covering authentication, cart operations, checkout flow, order management, and restaurant menu CRUD.

```bash
# Run the full test suite
php artisan test

# Run with verbose output
php artisan test --verbose

# Run a specific test file
php artisan test tests/Feature/Customer/CartTest.php

# Run by filter
php artisan test --filter=CheckoutTest
```

### Test Coverage

| Test File | Tests | Covers |
|-----------|-------|--------|
| `Auth/LoginTest` | 4 | Login validation, redirect, authentication |
| `Auth/RegistrationTest` | 4 | Registration flow, validation, role assignment |
| `Customer/CartTest` | 4 | Add to cart, update quantity, remove, clear |
| `Customer/CheckoutTest` | 4 | Checkout page, order placement, address validation |
| `Customer/OrderTest` | 3 | Order listing, order details, authorization |
| `Restaurant/MenuItemTest` | 5 | CRUD operations, image uploads, validation |
| `Feature/ExampleTest` | 1 | Application bootstrap |
| `Unit/ExampleTest` | 1 | Basic unit test |

---

## 🆕 New Features

### ❤️ Favorites System
Customers can favorite restaurants for quick access. One-click toggle with a dedicated favorites page showing all saved restaurants.

### 🎟️ Promo Codes
Full promo code engine supporting:
- **Percentage** and **fixed-amount** discounts
- Minimum order amount requirements
- Maximum discount caps
- Usage limits and expiration dates
- Real-time validation via `ApplyPromoCodeRequest`

### 📦 Order Timeline
A visual `<x-order-timeline>` Blade component that renders every status change with timestamps — from order placed through preparation, pickup, and delivery.

### ⭐ Driver Ratings
After delivery, customers can rate their driver. The `driver_rating` field on orders captures delivery experience separately from restaurant ratings.

### 🌙 Dark Mode
A `<x-dark-mode-toggle>` component provides system-wide dark/light theme switching, persisted via local storage and applied with Tailwind's `dark:` variant classes.

### 👤 Customer Profile
Customers can edit personal details, upload an avatar via `ProfileController`, and manage their delivery addresses — all from a dedicated profile page.

### 🔍 Advanced Search
The `SearchService` powers restaurant search with:
- Text search across name and description
- Cuisine and city filters
- Rating-based sorting
- **Cached filter options** for performance

---

## 📁 Project Structure

```
Food-Delivery-Application/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── AdminDashboardController.php
│   │   │   │   ├── CategoryController.php
│   │   │   │   ├── MenuItemController.php
│   │   │   │   ├── RestaurantController.php
│   │   │   │   └── UserController.php
│   │   │   ├── Customer/
│   │   │   │   ├── AddressController.php
│   │   │   │   ├── CartController.php
│   │   │   │   ├── CheckoutController.php
│   │   │   │   ├── CustomerDashboardController.php
│   │   │   │   ├── FavoriteController.php       # ← NEW
│   │   │   │   ├── OrderController.php
│   │   │   │   ├── ProfileController.php        # ← NEW
│   │   │   │   ├── PromoCodeController.php      # ← NEW
│   │   │   │   └── RatingController.php
│   │   │   ├── Driver/
│   │   │   │   └── DriverDashboardController.php
│   │   │   ├── Restaurant/
│   │   │   │   ├── CategoryController.php
│   │   │   │   ├── MenuItemController.php
│   │   │   │   ├── RestaurantDashboardController.php
│   │   │   │   ├── RestaurantOrderController.php
│   │   │   │   └── RestaurantProfileController.php
│   │   │   ├── AuthController.php
│   │   │   ├── ContactController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── HomeController.php
│   │   │   ├── NotificationController.php
│   │   │   └── PublicRestaurantController.php
│   │   ├── Middleware/
│   │   │   ├── CheckPermission.php
│   │   │   └── CheckRole.php
│   │   └── Requests/                            # 11 Form Requests
│   │       ├── ApplyPromoCodeRequest.php
│   │       ├── CategoryRequest.php
│   │       ├── LoginRequest.php
│   │       ├── MenuItemRequest.php
│   │       ├── RegisterRequest.php
│   │       ├── RestaurantRequest.php
│   │       ├── StoreAddressRequest.php
│   │       ├── StoreMenuItemRequest.php
│   │       ├── StoreOrderRequest.php
│   │       ├── UpdateMenuItemRequest.php
│   │       └── UpdateRestaurantProfileRequest.php
│   ├── Models/                                  # 14 Eloquent Models
│   │   ├── Address.php
│   │   ├── CartItem.php
│   │   ├── Category.php
│   │   ├── Favorite.php                         # ← NEW
│   │   ├── MenuItem.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   ├── OrderStatusHistory.php               # ← NEW
│   │   ├── Permission.php
│   │   ├── PromoCode.php                        # ← NEW
│   │   ├── Restaurant.php
│   │   ├── RestaurantRating.php
│   │   ├── Role.php
│   │   └── User.php
│   ├── Notifications/
│   │   ├── NewDeliveryAvailable.php
│   │   ├── OrderPlaced.php
│   │   └── OrderStatusChanged.php
│   ├── Policies/
│   │   ├── AddressPolicy.php
│   │   ├── OrderPolicy.php
│   │   └── RestaurantPolicy.php
│   ├── Providers/
│   └── Services/
│       ├── CartService.php
│       └── SearchService.php
├── database/
│   ├── factories/                               # 6 Model Factories
│   ├── migrations/                              # 23 Migrations
│   └── seeders/                                 # 10 Seeders
├── resources/views/
│   ├── admin/
│   ├── customer/
│   │   ├── addresses/
│   │   ├── cart/
│   │   ├── checkout/
│   │   ├── favorites/                           # ← NEW
│   │   ├── orders/
│   │   ├── profile/                             # ← NEW
│   │   └── dashboard.blade.php
│   ├── components/                              # 24 Blade Components
│   │   ├── dark-mode-toggle.blade.php           # ← NEW
│   │   ├── driver-rating-form.blade.php         # ← NEW
│   │   ├── order-timeline.blade.php             # ← NEW
│   │   ├── skeleton-card.blade.php              # ← NEW
│   │   └── ... (20 more)
│   ├── driver/
│   ├── layouts/
│   ├── notifications/
│   └── restaurant/
├── routes/web.php                               # ~150 lines, 4 role groups
├── tests/
│   ├── Feature/                                 # 26 tests across 7 files
│   └── Unit/
└── ...config, public, storage, vendor
```

---

## 🔌 API Routes Reference

### Public

```
GET    /                              Home page
GET    /restaurants                   Browse all restaurants
GET    /restaurants/search            Search with filters
GET    /restaurants/suggestions       Autocomplete suggestions
GET    /restaurants/filters           Available filter options
GET    /restaurants/{slug}            Restaurant detail page
GET    /restaurants/{restaurant}/categories/{category}   Category items
```

### Authentication

```
GET|POST  /login                     Login
GET|POST  /register                  Register
POST      /logout                    Logout
```

### Customer (`/customer/*`)

```
GET    /dashboard                    Customer home
GET    /cart                         View cart
POST   /cart/add                     Add item
PATCH  /cart/{item}                  Update quantity
DELETE /cart/{item}                  Remove item
DELETE /cart/clear                   Clear cart
GET    /checkout                     Checkout page
POST   /checkout                     Place order
GET    /checkout/success/{order}     Confirmation
GET    /orders                       Order history
GET    /orders/{order}               Order detail + timeline
POST   /promo/apply                  Apply promo code
POST   /promo/remove                 Remove promo code
GET    /favorites                    Favorite restaurants
POST   /favorites/{restaurant}/toggle Toggle favorite
GET    /profile                      Edit profile
PUT    /profile                      Update profile
POST   /profile/avatar               Upload avatar
CRUD   /addresses                    Manage addresses
POST   /restaurants/{restaurant}/rate Rate restaurant
POST   /orders/{order}/rate-driver   Rate driver
```

### Restaurant Owner (`/restaurant/*`)

```
GET    /dashboard                    Restaurant home
GET    /profile/edit                 Edit profile
PUT    /profile                      Update profile
POST   /profile/logo                 Upload logo
POST   /profile/cover                Upload cover image
CRUD   /categories                   Manage categories
POST   /categories/reorder           Reorder categories
CRUD   /menu                         Manage menu items
POST   /menu/{menu}/toggle           Toggle item availability
GET    /orders                       View orders
GET    /orders/{order}               Order detail
PATCH  /orders/{order}/status        Update order status
```

### Driver (`/driver/*`)

```
GET    /dashboard                    Driver home
GET    /deliveries/available         Available deliveries
GET    /deliveries/my-deliveries     My deliveries
POST   /deliveries/{order}/accept    Accept delivery
PATCH  /deliveries/{order}/status    Update delivery status
GET    /deliveries/{order}           Delivery detail
```

### Admin (`/admin/*`)

```
GET    /dashboard                    Analytics dashboard
GET    /users                        User list
GET    /users/{user}                 User detail
GET    /users/{user}/edit            Edit user
PUT    /users/{user}                 Update user
DELETE /users/{user}                 Delete user
POST   /users/{user}/toggle-status   Enable/disable user
GET    /restaurants                   All restaurants
GET    /restaurants/{restaurant}     Restaurant detail
GET    /categories                   All categories
GET    /menu-items                   All menu items
```

### Notifications (all authenticated users)

```
GET    /notifications                List notifications
POST   /notifications/{id}/read      Mark as read
POST   /notifications/read-all       Mark all as read
GET    /notifications/unread-count   Unread count (AJAX)
```

---

## 🚀 Deployment Checklist

- [ ] Set `APP_ENV=production` and `APP_DEBUG=false` in `.env`
- [ ] Configure production MySQL credentials
- [ ] Run `composer install --optimize-autoloader --no-dev`
- [ ] Run `npm run build`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Run `php artisan storage:link`
- [ ] Set up SSL/TLS certificate
- [ ] Configure queue workers (`php artisan queue:work`)
- [ ] Set up cron for `php artisan schedule:run`
- [ ] Verify file permissions on `storage/` and `bootstrap/cache/`
- [ ] Set up database backups
- [ ] Configure logging (daily rotation recommended)

---

## 💡 Technical Highlights

> *Sections like this demonstrate depth of understanding to hiring managers and reviewers.*

### 🔐 Authorization & Security
- **3 Eloquent Policies** (`OrderPolicy`, `AddressPolicy`, `RestaurantPolicy`) enforce model-level ownership — users can only view/modify their own resources
- **11 Form Request classes** validate and sanitize all user input before it reaches controllers
- **Role + Permission middleware** — `CheckRole` and `CheckPermission` gate every route group

### ⚡ Performance Optimizations
- **Eager loading** (`with()`) on all relationship-heavy queries to eliminate N+1 problems
- **Database indexes** — dedicated migration (`add_performance_indexes`) adds composite indexes on `orders.status`, `orders.user_id`, `orders.restaurant_id`, and more
- **Search indexes** on `restaurants.cuisine` and full-text columns for fast filtering
- **Cached filter options** in `SearchService` to avoid repeated aggregate queries

### 🧩 Design Patterns
- **Service Layer** — `CartService` and `SearchService` encapsulate complex business logic
- **Form Request Pattern** — validation separated from controllers into dedicated request classes
- **Factory + Seeder** — 6 factories and 10 seeders for deterministic, scalable test data generation
- **Blade Component Architecture** — 24 reusable components (`<x-order-timeline>`, `<x-dark-mode-toggle>`, `<x-skeleton-card>`, etc.) for consistent UI
- **Notification System** — Laravel's built-in database notifications with polymorphic `notifiable` support

### 📐 What I Learned Building This
- Designing a **multi-tenant role-based system** from scratch with proper authorization gates
- Implementing **promo code logic** with edge cases: usage limits, expiry, minimum amounts, and max discount caps
- Building **reusable Blade components** that work across light/dark themes
- Writing **feature tests** that cover authentication, cart state, checkout flow, and CRUD operations
- Optimizing database queries with **indexes and eager loading** to handle 6,000+ menu items efficiently

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. **Fork** the repository
2. **Create** a feature branch (`git checkout -b feature/amazing-feature`)
3. **Commit** your changes (`git commit -m 'Add amazing feature'`)
4. **Push** to the branch (`git push origin feature/amazing-feature`)
5. **Open** a Pull Request

Please ensure:
- All existing tests pass (`php artisan test`)
- New features include appropriate tests
- Code follows existing conventions

---

## 📝 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

---

## 👨‍💻 Author

**Yasser Hegazy**

- GitHub: [@yasserhegazy](https://github.com/yasserhegazy)

---

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) — The PHP framework for web artisans
- [TailwindCSS](https://tailwindcss.com) — Utility-first CSS framework
- [Alpine.js](https://alpinejs.dev) — Lightweight JavaScript framework
- [Chart.js](https://www.chartjs.org) — Flexible charting library
- [Heroicons](https://heroicons.com) — Beautiful hand-crafted SVG icons


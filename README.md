# Bees Cavern Web Application

**Version:** 1.0.0  
**Author:** Pol Moreno Queraltó  
**Last Updated:** January 2026

---

## Table of Contents
- [Project Overview](#project-overview)
- [Architecture](#architecture)
- [Project Structure](#project-structure)
- [Technologies Used](#technologies-used)
- [Database Schema](#database-schema)
- [Installation & Setup](#installation--setup)
- [Development Guide](#development-guide)
- [API Documentation](#api-documentation)
- [User Features](#user-features)
- [Admin Features](#admin-features)

---

## Project Overview

**Bees Cavern** is a full-stack restaurant management web application that provides two distinct interfaces:

1. **Public User Interface** (PHP + Server-Side Rendering)
   - Product browsing and ordering
   - User authentication and profile management
   - Shopping cart and order history
   - Membership system with exclusive benefits

2. **Admin Dashboard** (JavaScript + RESTful API)
   - Single Page Application (SPA) architecture
   - Real-time data management via fetch
   - Complete CRUD operations for all entities
   - System logs and analytics

---

## Architecture

### Dual Architecture Approach

The application implements **two separate architectural patterns** based on user role:

#### 1. **Public/Client Side** - Traditional MVC with PHP
- **Pattern:** Server-Side Rendering (SSR)
- **Flow:** Request → Router → Controller → Model/DAO → View → Response
- **Tech Stack:** Pure PHP, PDO, Bootstrap 5
- **Benefits:** SEO-friendly, fast initial load, no JavaScript dependencies

#### 2. **Admin Side** - SPA with RESTful API
- **Pattern:** Single Page Application + REST API
- **Flow:** SPA → Fetch Request → API Router → API Controller → JSON Response
- **Tech Stack:** Vanilla JavaScript, Fetch API, PHP REST API
- **Benefits:** Dynamic UI, better UX, real-time updates

```
┌─────────────────────────────────────────────────────────┐
│                    PUBLIC REQUEST                        │
│  User → index.php → Controller → DAO → View (PHP)      │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│                    ADMIN REQUEST                         │
│  Admin SPA → api.php → APIController → JSON Response   │
└─────────────────────────────────────────────────────────┘
```

---

## Project Structure

```
primerProjecteMoreno/
│
├── app/                          # Application logic
│   ├── controller/              # Business logic controllers
│   │   ├── API/                # API Controllers (JSON responses)
│   │   │   ├── APIUserController.php
│   │   │   ├── APIProductController.php
│   │   │   ├── APIOrderController.php
│   │   │   ├── APIIngredientController.php
│   │   │   ├── APIDiscountController.php
│   │   │   └── APIBCLogsController.php
│   │   ├── GeneralController.php      # Home, membership pages
│   │   ├── AuthController.php         # Login, register, logout
│   │   ├── UserController.php         # User profile, orders
│   │   ├── ProductController.php      # Product catalog
│   │   ├── OrderController.php        # Shopping cart, checkout
│   │   ├── AdminController.php        # Admin dashboard entry
│   │   └── ErrorController.php        # Error handling
│   │
│   ├── model/                   # Data entities
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── Ingredient.php
│   │   ├── Orders.php
│   │   ├── OrderLine.php
│   │   ├── Discount.php
│   │   ├── BCLogs.php
│   │   ├── ProductRating.php
│   │   └── ...
│   │
│   ├── DAO/                     # Data Access Objects (DB queries)
│   │   ├── UserDAO.php
│   │   ├── ProductDAO.php
│   │   ├── IngredientDAO.php
│   │   ├── OrdersDAO.php
│   │   ├── DiscountDAO.php
│   │   ├── BCLogsDAO.php
│   │   └── ...
│   │
│   ├── util/                    # Utility classes
│   │   ├── DatabasePDO.php     # Database connection manager
│   │   ├── SessionUtils.php    # Session management
│   │   ├── AuthUtils.php       # Authentication helpers
│   │   ├── ShopCartUtils.php   # Shopping cart logic
│   │   └── JsonUtils.php       # JSON response utilities
│   │
│   └── view/                    # PHP views (SSR)
│       ├── main.php            # Master template
│       ├── general/            # Public pages (home, membership)
│       ├── auth/               # Login, register
│       ├── product/            # Product catalog, details
│       ├── order/              # Cart, checkout
│       ├── user/               # User profile, order history
│       ├── admin/              # Admin SPA HTML entry
│       ├── partials/           # Reusable components
│       └── errors/             # Error pages
│
├── public/                      # Web root (document root)
│   ├── index.php               # Front controller (PHP routing)
│   ├── api.php                 # REST API router
│   │
│   ├── admin/                  # Admin SPA assets
│   │   ├── html/              # Admin page templates
│   │   │   ├── discounts.html
│   │   │   ├── ingredients.html
│   │   │   ├── products.html
│   │   │   ├── orders.html
│   │   │   ├── users.html
│   │   │   └── logs.html
│   │   ├── js/                # Admin JavaScript modules
│   │   │   ├── admin-main.js
│   │   │   ├── api-service.js
│   │   │   ├── discount-manager.js
│   │   │   ├── ingredient-manager.js
│   │   │   ├── product-manager.js
│   │   │   ├── order-manager.js
│   │   │   ├── user-manager.js
│   │   │   └── log-viewer.js
│   │   └── css/
│   │       └── admin-styles.css
│   │
│   ├── assets/                 # Public assets
│   │   ├── img/               # Images (products, logos, icons)
│   │   └── fonts/             # Custom fonts (Karla, Sting)
│   │
│   ├── css/                    # Public stylesheets
│   │   ├── styles.css         # Main stylesheet
│   │   ├── auth-styles.css
│   │   ├── products-styles.css
│   │   └── ...
│   │
│   ├── js/                     # Public JavaScript
│   │   ├── auth-utils.js
│   │   ├── general-utils.js
│   │   └── lucide-init.js     # Icon library
│   │
│   └── vendor/                 # Third-party libraries
│       └── lucide.js          # Lucide icons
│
├── db/                          # Database scripts
│   ├── script1_creation_db_cavern_bees_v.3.0.sql  # Schema
│   ├── script2_triggers.sql                        # Triggers
│   ├── script3_dml_products.sql                    # Product data
│   └── script4_dml_users.sql                       # User data
│
├── logs/                        # Application logs
├── documentation/               # Additional docs
├── .gitignore
├── package.json                # NPM dependencies (Lucide)
└── README.md                   # This file
```

---

## Technologies Used

### Backend
- **PHP 8.x** - Server-side logic
- **MySQL 8.0** - Relational database
- **PDO** - Database abstraction layer
- **RESTful API** - Admin data communication

### Frontend (Public)
- **HTML5 / CSS3**
- **Bootstrap 5** - Responsive UI framework
- **Lucide Icons** - Icon library
- **Vanilla JavaScript** - Client-side interactions

### Frontend (Admin)
- **Single Page Application (SPA)**
- **Fetch API** - Fetch requests
- **Vanilla JavaScript** - No frameworks
- **Dynamic DOM manipulation**

### Development Tools
- **XAMPP** - Local development environment
- **Git** - Version control
- **VS Code** - IDE

---

## Database Schema

### Core Entities

#### Users & Authentication
- `user_type` - User types (basic, membership, vip, brentford_player, brentford_staff)
- `user` - User accounts with authentication
- `discount` - User type discounts and promo codes

#### Products & Menu
- `product` - Menu items (appetiser, main, dessert, drink)
- `ingredient` - Recipe ingredients with nutritional info
- `product_ingredient` - Many-to-many relationship
- `allergen` - Allergen information
- `ingredient_allergen` - Ingredient allergen mapping
- `macronutrient` - Nutritional values
- `product_rating` - User reviews and ratings

#### Orders & Shopping
- `orders` - Customer orders
- `order_line` - Order items
- `order_line_ingredient` - Custom ingredient selections

#### System
- `bc_logs` - CRUD operation logs for audit trail

### Key Features
- **Triggers** - Auto-calculate product prices based on ingredients
- **Foreign Keys** - Referential integrity
- **JSON Fields** - Flexible data (addresses, images)
- **ENUM Types** - Controlled vocabularies

---

## Installation & Setup

### Prerequisites
- PHP 8.0+
- MySQL 8.0+
- Apache web server
- Composer (optional)

### Step 1: Clone Repository
```bash
git clone https://github.com/polmorenofp23/primerProjecteMoreno.git
cd primerProjecteMoreno
```

### Step 2: Database Setup
```bash
# Create database and import schema
mysql -u root -p < db/script1_creation_db_cavern_bees_v.3.0.sql
mysql -u root -p < db/script2_triggers.sql
mysql -u root -p < db/script3_dml_products.sql
mysql -u root -p < db/script4_dml_users.sql
```

### Step 3: Configure Database Connection
Edit `app/util/DatabasePDO.php`:
```php
private $host = 'localhost';
private $db_name = 'bees_cavern_db';
private $username = 'root';
private $password = 'your_password';
```

### Step 4: Install Dependencies
```bash
npm install  # Installs Lucide icons
```

### Step 5: Configure Web Server
Point your web server document root to `/public` directory.

**Apache (.htaccess example):**
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

### Step 6: Test Installation
- Public site: `http://localhost/primerProjecteMoreno/public/`
- Admin login: `http://localhost/primerProjecteMoreno/public/?controller=Auth&action=showLogin`
  - Username: `polmoreno`
  - Password: `Asdqwe!23`

---

## Development Guide

### Routing System

#### Public Routes (PHP Controllers)
```
?controller=General&action=home          # Home page
?controller=Product&action=index         # Product catalog
?controller=Product&action=show&id=5     # Product details
?controller=Order&action=addToCart       # Add to cart
?controller=User&action=profile          # User profile
?controller=Auth&action=showLogin        # Login page
```

#### API Routes (JSON Responses)
```
GET    /api.php?resource=user             # List users
GET    /api.php?resource=user&id=5        # Get user
POST   /api.php?resource=user             # Create user
PUT    /api.php?resource=user&id=5        # Update user
DELETE /api.php?resource=user&id=5        # Delete user

Resources: user, product, ingredient, order, discount, logs
```

### Creating a New Controller (Public)

1. Create controller file: `app/controller/MyController.php`
```php
<?php
require_once MODEL_PATH . 'MyModel.php';
require_once DAO_PATH . 'MyDAO.php';

class MyController {
    public function index() {
        $view = 'my/index.php';
        $myDAO = new MyDAO();
        $items = $myDAO->getAll();
        include_once VIEW_PATH . 'main.php';
    }
}
```

2. Create view: `app/view/my/index.php`
3. Access: `?controller=My&action=index`

### Creating a New API Controller

1. Create API controller: `app/controller/API/APIMyController.php`
```php
<?php
require_once DAO_PATH . 'MyDAO.php';
require_once UTIL_PATH . 'JsonUtils.php';

class APIMyController {
    private $dao;

    public function __construct() {
        $this->dao = new MyDAO();
    }

    public function index() {
        $items = $this->dao->getAll();
        JsonUtils::sendJsonResponse(200, $items);
    }
}
```

2. Access: `GET /api.php?resource=my`

### Adding Admin SPA Page

1. Create HTML template: `public/admin/html/mypage.html`
2. Create JS module: `public/admin/js/my-manager.js`
3. Add to admin navigation in `public/admin/html/index.html`

---

## API Documentation

### Authentication
Most API endpoints require admin authentication via session.

### Response Format
```json
{
  "code": 200,
  "data": { ... },
  "message": "Success"
}
```

### Endpoints

#### Users
```
GET    /api.php?resource=user              # List all users
GET    /api.php?resource=user&id=5         # Get user by ID
POST   /api.php?resource=user              # Create user
PUT    /api.php?resource=user&id=5         # Update user
DELETE /api.php?resource=user&id=5         # Delete user
```

#### Products
```
GET    /api.php?resource=product           # List all products
GET    /api.php?resource=product&id=10     # Get product details
POST   /api.php?resource=product           # Create product
PUT    /api.php?resource=product&id=10     # Update product
DELETE /api.php?resource=product&id=10     # Delete product
```

#### Ingredients
```
GET    /api.php?resource=ingredient        # List ingredients
POST   /api.php?resource=ingredient        # Create ingredient
PUT    /api.php?resource=ingredient&id=20  # Update ingredient
DELETE /api.php?resource=ingredient&id=20  # Delete ingredient
```

#### Orders
```
GET    /api.php?resource=order             # List all orders
GET    /api.php?resource=order&id=100      # Get order details
PATCH  /api.php?resource=order&id=100      # Update order status
```

#### Discounts
```
GET    /api.php?resource=discount          # List discounts
POST   /api.php?resource=discount          # Create discount
PUT    /api.php?resource=discount&id=3     # Update discount
DELETE /api.php?resource=discount&id=3     # Delete discount
```

#### System Logs
```
GET    /api.php?resource=logs              # View system logs
```

---

## User Features

### Public Pages
- **Home** - Hero carousel, featured products, promotions
- **Menu** - Product catalog with category filters
- **Product Details** - Ingredients, allergens, ratings
- **Membership** - Exclusive benefits program (FREE)

### Authentication
- **Register** - Create new account
- **Login** - User authentication
- **Session Management** - Persistent login

### User Dashboard
- **Profile** - Edit personal information
- **Order History** - View past orders
- **Favorites** - Save favorite products
- **Shopping Cart** - Add/remove items
- **Membership Upgrade** - Become a member

### Membership Benefits
- **20% Discount** - Automatic discount on all orders
- **Early Access** - New product notifications
- **Priority Service** - Fast-track orders
- **Lifetime Access** - No expiration

---

## Admin Features

### Dashboard Overview
- Active orders summary
- Total products/ingredients
- User statistics
- Recent system logs

### Management Modules

#### Product Management
- CRUD operations for menu items
- Ingredient assignment
- Price calculation (auto-trigger)
- Image management
- Availability toggle

#### Ingredient Management
- CRUD operations for ingredients
- Allergen assignment
- Nutritional information
- Country of origin
- Price per 100g

#### User Management
- View all users
- User type management
- Account status control
- Order history per user

#### Discount Management
- Create promo codes
- User type discounts
- Active/inactive status
- Percentage configuration

#### Order Management
- View all orders
- Update order status
- Order details view
- Customer information

#### System Logs
- CRUD operation tracking
- User actions audit
- Timestamp records
- Resource type filtering

---

## Security Features

- **Password Hashing** - bcrypt with cost 10
- **Session Management** - Secure session handling
- **SQL Injection Prevention** - Prepared statements with PDO
- **XSS Protection** - Output escaping in views
- **CSRF Protection** - Form tokens (recommended to implement)
- **Role-Based Access Control** - Admin/User separation
- **API Authentication** - Session-based for admin

---

## Deployment Notes

### Production Checklist
- [ ] Update database credentials
- [ ] Enable error logging (disable display_errors)
- [ ] Configure proper file permissions
- [ ] Set up HTTPS/SSL
- [ ] Enable Apache mod_rewrite
- [ ] Configure CORS properly
- [ ] Set up database backups
- [ ] Review and secure API endpoints

### Environment Variables
Consider using environment variables for:
- Database credentials
- API keys
- Debug mode flags
- Base URLs

---

## Default Users

### Admin Account
- **Username:** `polmoreno`
- **Password:** `1234`
- **Email:** `pol.moreno@beescavern.com`
- **Role:** admin (VIP)

### Test Users
All test users have password: `1234`
- `johndoe` - Basic user
- `janesmith` - Basic user
- `sarahwilliams` - Membership user
- `davidbrown` - Membership user
- `ivantoney` - Brentford player (100% discount)
- `bryanmbeumo` - Brentford player
- `yoanewissa` - Brentford player
- `thomasfrank` - Brentford staff (50% discount)
- `philgiles` - Brentford staff

---

### Planned Features
- [ ] Email notifications for orders
- [ ] Payment gateway integration
- [ ] Advanced product search/filters
- [ ] Customer reviews with moderation
- [ ] Multi-language support
- [ ] Mobile app (Progressive Web App)
- [ ] Admin analytics dashboard
- [ ] Export data to CSV/PDF

---

## License

This project is for educational purposes.  
© 2026 Pol Moreno Queraltó

---

## Contact & Support

**Developer:** Pol Moreno Queraltó  
**Repository:** [GitHub](https://github.com/polmorenofp23/primerProjecteMoreno)
**Trello:** Link to the Trello of the organitzation (https://trello.com/invite/b/690cb82bfc0f3cb3568572ed/ATTI699403a33c0e1f3237e639a01a298261158EDC0D/projecte-web-bees-cavern)

For bug reports, feature requests, or questions, please open an issue on GitHub.

---

**Last Updated:** January 7, 2026  
**Version:** 1.0.0
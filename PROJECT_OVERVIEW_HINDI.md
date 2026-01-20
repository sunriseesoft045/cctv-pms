# CCTV PMS - आपके प्रोजेक्ट की पूरी जानकारी

## 📌 प्रोजेक्ट क्या है?

**CCTV PMS** एक **Laravel 10** पर बना एक **एंटरप्राइज-लेवल Property Management System** है। यह सिस्टम:

- **खरीद (Purchases)** - सामान खरीदना और ट्रैक करना
- **बिक्री (Sales)** - सामान बेचना और रिकॉर्ड करना  
- **भुगतान (Payments)** - पैसे की लेनदेन
- **इनवेंटरी (Inventory)** - स्टॉक मैनेजमेंट
- **फाइनेंशियल रिपोर्ट्स** - आय और खर्च की रिपोर्ट
- **एडमिन पैनल** - पूरे सिस्टम को कंट्रोल करना

---

## 🏗️ टेक्नोलॉजी स्टैक (Technology Stack)

### बैकएंड (Backend)
```
✅ Laravel 10          - PHP Web Framework
✅ PHP 8.2+           - Programming Language
✅ SQLite/MySQL       - Database
✅ Eloquent ORM       - Database Management
✅ Blade Templates    - HTML Templates
```

### फ्रंटएंड (Frontend)
```
✅ Bootstrap 5        - UI Framework
✅ HTML5             - Structure
✅ CSS3              - Styling
✅ JavaScript        - Interactivity
✅ Font Awesome      - Icons
```

### Tools & Services
```
✅ Vite              - Asset Building
✅ Tailwind CSS      - Utility Classes
✅ Composer          - PHP Dependencies
✅ npm               - JavaScript Dependencies
```

---

## 📂 प्रोजेक्ट स्ट्रक्चर

```
cctv-pms/
│
├── 📁 app/
│   ├── 📁 Http/
│   │   ├── Controllers/        👈 सभी Business Logic
│   │   │   ├── PurchaseController.php
│   │   │   ├── SalesController.php
│   │   │   ├── PaymentController.php
│   │   │   ├── InventoryController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── AdminAuthController.php
│   │   │   └── ... (और भी Controllers)
│   │   ├── Middleware/         👈 Security & Access Control
│   │   │   ├── Authenticate.php
│   │   │   ├── Authorization.php
│   │   │   └── ... (और Middleware)
│   │   └── Kernel.php
│   │
│   ├── 📁 Models/              👈 Database Models
│   │   ├── User.php            - यूजर्स
│   │   ├── Purchase.php        - खरीद
│   │   ├── Sale.php            - बिक्री
│   │   ├── Payment.php         - भुगतान
│   │   ├── Product.php         - सामान
│   │   ├── FinancialReport.php - रिपोर्ट्स
│   │   ├── SystemSetting.php   - सेटिंग्स
│   │   ├── CompanyProfile.php  - कंपनी की जानकारी
│   │   └── Camera.php          - कैमरे
│   │
│   └── 📁 Providers/           👈 Application Services
│       └── AppServiceProvider.php
│
├── 📁 database/
│   ├── 📁 migrations/          👈 Database Tables
│   │   ├── 2026_01_19_120100_create_purchases_table.php
│   │   ├── 2026_01_19_120200_create_sales_table.php
│   │   ├── 2026_01_19_120300_create_payments_table.php
│   │   ├── 2026_01_19_120000_create_products_table.php
│   │   ├── 2026_01_19_103051_create_financial_reports_table.php
│   │   ├── 2026_01_19_103051_create_company_profiles_table.php
│   │   └── ... (और Tables)
│   │
│   ├── 📁 seeders/             👈 Dummy Data
│   │   ├── DatabaseSeeder.php
│   │   ├── AdminSeeder.php
│   │   └── MasterAdminSeeder.php
│   │
│   └── 📁 factories/           👈 Test Data Factories
│       └── UserFactory.php
│
├── 📁 resources/
│   ├── 📁 views/               👈 HTML Templates (Blade)
│   │   ├── 📁 admin/           - Admin पैनल
│   │   ├── 📁 user/            - User पैनल
│   │   │   ├── 📁 layouts/     - Layout Templates
│   │   │   ├── 📁 purchases/   - खरीद की Pages
│   │   │   ├── 📁 sales/       - बिक्री की Pages
│   │   │   ├── 📁 payments/    - भुगतान की Pages
│   │   │   └── 📁 inventory/   - स्टॉक की Pages
│   │   └── welcome.blade.php
│   │
│   ├── 📁 css/                 👈 Stylesheets
│   │   └── app.css
│   │
│   └── 📁 js/                  👈 JavaScript
│       ├── app.js
│       └── bootstrap.js
│
├── 📁 routes/
│   ├── web.php                 👈 सभी Routes/URLs
│   └── console.php
│
├── 📁 storage/                 👈 Temporary Files
│   ├── 📁 app/
│   ├── 📁 logs/
│   └── 📁 framework/
│
├── 📁 tests/                   👈 Testing Files
│   ├── Feature/
│   └── Unit/
│
├── 📁 bootstrap/               👈 Application Bootstrap
│   ├── app.php
│   ├── providers.php
│   └── cache/
│
├── 📁 config/                  👈 Configuration Files
│   ├── app.php
│   ├── database.php
│   ├── auth.php
│   ├── session.php
│   └── ... (और configs)
│
├── .env                        👈 Environment Variables
├── .env.example
├── composer.json               👈 PHP Dependencies
├── package.json                👈 Node Dependencies
├── vite.config.js              👈 Vite Configuration
├── artisan                     👈 Laravel CLI Tool
├── README.md
├── SETUP_GUIDE.md
└── phpunit.xml
```

---

## 👥 यूजर रोल्स (User Roles)

### 1. **Master Admin** 👑
```
✅ सबसे ज्यादा अधिकार
✅ सिस्टम सेटिंग्स बदल सकता है
✅ कंपनी की जानकारी रख सकता है
✅ फाइनेंशियल रिपोर्ट्स देख सकता है
✅ Admin को हटा/जोड़ सकता है
```

### 2. **Admin** 🔑
```
✅ खरीद/बिक्री को Approve करता है
✅ सभी Purchases/Sales देख सकता है
✅ रिपोर्ट्स देख सकता है
✅ Dashboard को Monitor करता है
```

### 3. **User** 👤
```
✅ Purchases (खरीद) कर सकता है
✅ Sales (बिक्री) कर सकता है
✅ Payments (भुगतान) रिकॉर्ड कर सकता है
✅ Inventory (स्टॉक) को Manage कर सकता है
✅ अपनी ही खरीद/बिक्री देख सकता है
```

---

## 🎯 मुख्य Features

### 1. **Authentication & Authorization** 🔐
- User Login/Logout
- Role-Based Access Control (RBAC)
- Session Management
- Admin Authentication
- Middleware Protection

### 2. **Purchases Management** 🛒
```
Features:
├── ✅ नई खरीद जोड़ना (Create)
├── ✅ खरीद देखना (Read/List)
├── ✅ खरीद बदलना (Update)
├── ✅ खरीद हटाना (Delete)
├── ✅ Admin को Approve के लिए भेजना
└── ✅ Status Tracking (Pending/Approved)
```

### 3. **Sales Management** 📊
```
Features:
├── ✅ नई बिक्री जोड़ना
├── ✅ बिक्री की List देखना
├── ✅ बिक्री Edit करना
├── ✅ बिक्री Delete करना
├── ✅ Approval Status Track करना
└── ✅ Total Amount Calculate करना
```

### 4. **Payment Management** 💰
```
Features:
├── ✅ तीन तरीके से Payment (Cash/UPI/Bank)
├── ✅ Sale से Link किया गया
├── ✅ Payment History
├── ✅ Amount Tracking
└── ✅ User-wise Reports
```

### 5. **Inventory Management** 📦
```
Features:
├── ✅ Products की List
├── ✅ SKU (Unique Code)
├── ✅ Stock Management
├── ✅ Price Tracking
├── ✅ Purchase/Sale Count
└── ✅ Stock Status Badges (Low/Good/Out)
```

### 6. **Admin Panel** 🎛️
```
Features:
├── ✅ Dashboard with Statistics
├── ✅ User Management
├── ✅ Purchase/Sale Approvals
├── ✅ Financial Reports
├── ✅ System Settings
├── ✅ Company Profile Management
└── ✅ Export Reports (CSV)
```

---

## 📊 Database Tables

### Products Table
```sql
CREATE TABLE products (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    sku VARCHAR(100) UNIQUE,
    price DECIMAL(12,2),
    stock INT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Purchases Table
```sql
CREATE TABLE purchases (
    id BIGINT PRIMARY KEY,
    product_id BIGINT (Foreign Key),
    quantity INT,
    cost DECIMAL(12,2),
    created_by BIGINT (Foreign Key - User),
    status ENUM('pending', 'approved'),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Sales Table
```sql
CREATE TABLE sales (
    id BIGINT PRIMARY KEY,
    product_id BIGINT (Foreign Key),
    quantity INT,
    price DECIMAL(12,2),
    created_by BIGINT (Foreign Key - User),
    status ENUM('pending', 'approved'),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Payments Table
```sql
CREATE TABLE payments (
    id BIGINT PRIMARY KEY,
    sale_id BIGINT (Foreign Key),
    amount DECIMAL(12,2),
    method ENUM('cash', 'upi', 'bank'),
    created_by BIGINT (Foreign Key - User),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

## 🚀 कैसे शुरू करें?

### Step 1: Installation
```bash
cd c:\xampp\htdocs\cctv-pms

# सभी Dependencies Install करें
composer install
npm install

# Database Setup
php artisan migrate
php artisan db:seed

# Key Generate करें
php artisan key:generate
```

### Step 2: Server शुरू करें
```bash
# Terminal 1: PHP Server
php artisan serve

# Terminal 2: Frontend Build
npm run dev
```

### Step 3: ब्राउजर में खोलें
```
http://localhost:8000
```

### Step 3: Login करें
```
Master Admin:
Email: master@admin.com
Password: password

Admin:
Email: admin@admin.com
Password: password

User:
Email: user@example.com
Password: password
```

---

## 📚 Routes/URLs

### Public Routes
```
GET  /                 - Home/Redirect
GET  /login            - Login Page
POST /login            - Login Process
POST /logout           - Logout
```

### User Routes (Authenticated)
```
GET    /user/dashboard              - User Dashboard
GET    /user/purchases              - Purchases List
GET    /user/purchases/create       - Add Purchase Form
POST   /user/purchases              - Save Purchase
GET    /user/purchases/{id}/edit    - Edit Purchase Form
PUT    /user/purchases/{id}         - Update Purchase
DELETE /user/purchases/{id}         - Delete Purchase

GET    /user/sales                  - Sales List
GET    /user/sales/create           - Add Sale Form
POST   /user/sales                  - Save Sale
GET    /user/sales/{id}/edit        - Edit Sale Form
PUT    /user/sales/{id}             - Update Sale
DELETE /user/sales/{id}             - Delete Sale

GET    /user/payments               - Payments List
GET    /user/payments/create        - Add Payment Form
POST   /user/payments               - Save Payment
GET    /user/payments/{id}/edit     - Edit Payment Form
PUT    /user/payments/{id}          - Update Payment
DELETE /user/payments/{id}          - Delete Payment

GET    /user/inventory              - Inventory List
GET    /user/inventory/create       - Add Product Form
POST   /user/inventory              - Save Product
GET    /user/inventory/{id}         - View Product
GET    /user/inventory/{id}/edit    - Edit Product Form
PUT    /user/inventory/{id}         - Update Product
DELETE /user/inventory/{id}         - Delete Product
```

### Admin Routes
```
GET  /admin/dashboard              - Admin Dashboard
GET  /admin/approvals              - Pending Approvals
POST /admin/approvals/purchase/{id}/approve - Approve Purchase
POST /admin/approvals/purchase/{id}/reject  - Reject Purchase
POST /admin/approvals/sale/{id}/approve     - Approve Sale
POST /admin/approvals/sale/{id}/reject      - Reject Sale
GET  /admin/reports                - All Reports
GET  /admin/reports/{id}           - View Report
GET  /admin/reports/export/csv     - Export as CSV
GET  /admin/products               - Manage Products
POST /admin/products               - Create Product
PUT  /admin/products/{id}          - Update Product
DELETE /admin/products/{id}        - Delete Product
GET  /admin/admins                 - Manage Admins
POST /admin/admins                 - Create Admin
PUT  /admin/admins/{id}            - Update Admin
DELETE /admin/admins/{id}          - Delete Admin
```

### Master Admin Routes
```
GET  /admin/system-settings        - System Settings
PUT  /admin/system-settings        - Update Settings
GET  /admin/company-profile        - Company Info
PUT  /admin/company-profile/{id}   - Update Company
GET  /admin/financial              - Financial Reports
GET  /admin/financial/create       - Add Report
POST /admin/financial              - Save Report
GET  /admin/financial/{id}         - View Report
GET  /admin/financial/{id}/edit    - Edit Report
PUT  /admin/financial/{id}         - Update Report
DELETE /admin/financial/{id}       - Delete Report
```

---

## 🎨 Views/Pages

### User Panel
```
📄 dashboard.blade.php           - Dashboard Page
📁 purchases/
   ├── index.blade.php           - List of Purchases
   ├── create.blade.php          - Add Purchase Form
   └── edit.blade.php            - Edit Purchase Form

📁 sales/
   ├── index.blade.php           - List of Sales
   ├── create.blade.php          - Add Sale Form
   └── edit.blade.php            - Edit Sale Form

📁 payments/
   ├── index.blade.php           - List of Payments
   ├── create.blade.php          - Add Payment Form
   └── edit.blade.php            - Edit Payment Form

📁 inventory/
   ├── index.blade.php           - Inventory List
   ├── create.blade.php          - Add Product Form
   ├── edit.blade.php            - Edit Product Form
   └── show.blade.php            - View Product Details

📁 layouts/
   ├── app.blade.php             - Main Layout
   ├── sidebar.blade.php         - Sidebar Navigation
   └── header.blade.php          - Header/Navigation
```

### Admin Panel
```
📄 admin/dashboard.blade.php      - Admin Dashboard
📄 admin/approvals.blade.php      - Pending Approvals
📄 admin/reports.blade.php        - Reports List
📄 admin/admins.blade.php         - User Management
📄 admin/products.blade.php       - Product Management
```

---

## 🔧 कैसे काम करता है?

### एक Purchase का Complete Flow:

1. **User Purchase Create करता है**
   ```
   User → Purchase Form भरता है → Database में Store होता है
   ```

2. **Status = Pending**
   ```
   Purchase को "Pending" Status के साथ Save किया जाता है
   ```

3. **Admin को दिखता है**
   ```
   Admin Panel → Approvals Section → Purchase दिखता है
   ```

4. **Admin Approve करता है**
   ```
   Admin → Approve Button → Status = Approved
   ```

5. **User को दिखता है**
   ```
   User Purchase List में Approved Badge दिखता है
   ```

---

## 🛡️ Security Features

```
✅ Password Hashing         - bcrypt encryption
✅ CSRF Protection          - @csrf tokens
✅ SQL Injection Protection - Eloquent ORM
✅ Role-Based Access        - Middleware checks
✅ Session Management       - Secure cookies
✅ Authorization Checks     - User verification
✅ Input Validation         - Form validation
✅ Output Escaping          - XSS prevention
```

---

## 📋 Controllers की जिम्मेदारी

| Controller | काम |
|-----------|------|
| `PurchaseController` | Purchases को CRUD करना |
| `SalesController` | Sales को CRUD करना |
| `PaymentController` | Payments को CRUD करना |
| `InventoryController` | Products को CRUD करना |
| `DashboardController` | Statistics दिखाना |
| `AdminAuthController` | Admin Login/Logout |
| `ApprovalController` | Approvals को Handle करना |
| `ReportsController` | Reports Generate करना |
| `SystemSettingsController` | Settings को Update करना |
| `CompanyProfileController` | Company Info रखना |

---

## 🧪 Testing

```bash
# सभी Tests चलाएं
php artisan test

# Specific Test चलाएं
php artisan test tests/Feature/ExampleTest.php

# Code Quality Check
./vendor/bin/pint
```

---

## 📝 Commands

```bash
# Database
php artisan migrate              # Tables बनाएं
php artisan migrate:fresh        # सभी Delete करके नए बनाएं
php artisan migrate:rollback     # पिछले Migration को Undo करें
php artisan db:seed              # Dummy Data डालें

# Cache
php artisan cache:clear          # Cache Clear करें
php artisan config:cache         # Config को Cache करें

# Maintenance
php artisan serve                # Server शुरू करें
php artisan tinker              # Interactive Shell

# Generate
php artisan make:controller      # Controller बनाएं
php artisan make:model           # Model बनाएं
php artisan make:migration       # Migration बनाएं
php artisan make:seeder          # Seeder बनाएं
```

---

## 🐛 Debugging

### Debug Mode Enable करें
```bash
# .env file में
APP_DEBUG=true
```

### Logs देखें
```bash
# Laravel Logs
tail -f storage/logs/laravel.log

# Web UI
php artisan pail
```

---

## 🚀 Deploy करने से पहले

```
✅ .env file check करें
✅ Database migrations चलाएं
✅ npm run build करें (Production)
✅ php artisan config:cache करें
✅ Cache clear करें
✅ Logs permissions सही करें
✅ Storage permissions सही करें
✅ Database backup लें
```

---

## 📞 Troubleshooting

### Problem: Migrations काम नहीं कर रहे
```bash
php artisan migrate:fresh
php artisan migrate --force
```

### Problem: CSS/JS नहीं दिख रहे
```bash
npm run build
php artisan config:cache
php artisan cache:clear
```

### Problem: Database में Data नहीं दिख रहा
```bash
php artisan db:seed
php artisan db:seed --class=MasterAdminSeeder
```

### Problem: Login नहीं हो रहा
```
1. Check करें कि Database migrate हो गया है
2. Check करें कि Seeder चल गया है
3. Check करें कि .env correct है
4. Check करें कि APP_KEY generate हो गई है
```

---

## 📌 महत्वपूर्ण Notes

1. **हमेशा Backup लें** - Database को regularly backup करें
2. **Production में DEBUG=false रखें** - Security के लिए
3. **Strong Passwords Use करें** - Secure रहें
4. **Regular Updates** - Laravel को updated रखें
5. **Code में Comments रखें** - Team collaboration के लिए

---

## 🎓 सीखने के लिए Resources

- Laravel Documentation: https://laravel.com/docs
- PHP Official: https://www.php.net
- Bootstrap: https://getbootstrap.com
- Laravel Blade: https://laravel.com/docs/blade
- Eloquent ORM: https://laravel.com/docs/eloquent

---

## ✅ Project Complete - सब कुछ तैयार है!

आपका CCTV PMS Project पूरी तरह से तैयार है। अब आप:
- Users को Purchases/Sales create करने दे सकते हो
- Admin को Approvals देने दे सकते हो
- Reports देख सकते हो
- सभी Data को Manage कर सकते हो

**Happy Coding! 🚀**
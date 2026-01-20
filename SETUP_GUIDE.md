# CCTV PMS - Master Admin Authentication & Management System
## Complete Setup & Deployment Guide

---

## 📋 Table of Contents
1. [System Overview](#system-overview)
2. [Prerequisites](#prerequisites)
3. [Installation Instructions](#installation-instructions)
4. [Database Schema](#database-schema)
5. [User Roles & Permissions](#user-roles--permissions)
6. [Key Features](#key-features)
7. [Testing Guide](#testing-guide)
8. [Troubleshooting](#troubleshooting)
9. [Security Notes](#security-notes)
10. [API/Routes Reference](#apia-routes-reference)

---

## System Overview

**CCTV PMS (Closed-Circuit Television Property Management System)** is a comprehensive Laravel 10 application featuring:

- **Enterprise-Grade Security**: Role-Based Access Control (RBAC) with three distinct roles
- **Master Admin System**: Complete administrative control over the application
- **Financial Management**: Track income and expenses with detailed reporting
- **Company Profile Management**: Maintain organization information and branding
- **System Settings**: Configure application-wide preferences
- **User Management**: Create and manage admin accounts
- **Professional UI**: Beautiful Bootstrap 5-based admin panel with responsive design

**Technology Stack:**
- **Framework:** Laravel 10
- **Database:** SQLite
- **Frontend:** Bootstrap 5, HTML5, CSS3, JavaScript
- **Backend:** PHP 8.x
- **ORM:** Eloquent
- **Authentication:** Custom Laravel Session-based Auth

---

## Prerequisites

Before installation, ensure you have:

1. **PHP 8.0 or higher** with extensions:
   - `php-sqlite3`
   - `php-curl`
   - `php-mbstring`
   - `php-xml`
   - `php-json`

2. **Composer** (PHP Package Manager)
   - Download from: https://getcomposer.org

3. **Node.js & npm** (Optional, for frontend assets)
   - Download from: https://nodejs.org

4. **Git** (For version control)
   - Download from: https://git-scm.com

5. **Web Server** (Apache with mod_rewrite or similar)
   - XAMPP/WAMP/LAMP stack recommended

---

## Installation Instructions

### Step 1: Clone or Download Project

```bash
# Navigate to your web root
cd c:\xampp\htdocs

# Clone the repository (if using Git)
git clone <repository-url> cctv-pms

# Or simply place the project folder there
cd cctv-pms
```

### Step 2: Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies (optional)
npm install
```

### Step 3: Environment Configuration

```bash
# Create .env file from example
cp .env.example .env

# Generate application key
php artisan key:generate
```

**Update .env file** with your settings:

```env
APP_NAME="CCTV PMS"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=sqlite
DB_DATABASE=c:\xampp\htdocs\cctv-pms\database\database.sqlite

CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

### Step 4: Create Database

```bash
# Ensure database directory exists
mkdir -p database

# Run migrations
php artisan migrate:fresh
```

**Output Should Show:**
```
✓ Creating users table
✓ Creating cache table  
✓ Creating jobs table
✓ Creating cameras table
✓ Creating company_profiles table
✓ Creating financial_reports table
✓ Creating system_settings table
```

### Step 5: Seed Master Admin

```bash
# Run the master admin seeder
php artisan db:seed --class=MasterAdminSeeder
```

**Expected Output:**
```
Master Admin created successfully!
Email: master@cctv.com
Password: Master@123
```

### Step 6: Start Development Server

```bash
# Option 1: Built-in PHP Server
php artisan serve
# Server runs on: http://127.0.0.1:8000

# Option 2: Use Apache
# Configure Virtual Host and access via: http://cctv-pms.local
```

### Step 7: Access the Application

1. Open browser and navigate to `http://127.0.0.1:8000`
2. You'll be redirected to `/admin/login` automatically
3. Login with master admin credentials

---

## Database Schema

### Users Table

```sql
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('master_admin', 'admin', 'user') DEFAULT 'user',
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Columns:**
- `id`: Unique identifier
- `name`: User's full name
- `email`: Email address (unique)
- `password`: Hashed password (never store plaintext!)
- `role`: User's permission level
- `status`: Account activation status
- `created_at`: Account creation timestamp
- `updated_at`: Last modification timestamp

### Company Profiles Table

```sql
CREATE TABLE company_profiles (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_name VARCHAR(255),
    address TEXT,
    phone VARCHAR(20),
    email VARCHAR(255),
    logo VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### System Settings Table

```sql
CREATE TABLE system_settings (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    setting_key VARCHAR(255) UNIQUE,
    setting_value LONGTEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Financial Reports Table

```sql
CREATE TABLE financial_reports (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(255) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    type ENUM('credit', 'debit') NOT NULL,
    description TEXT,
    created_by INTEGER UNSIGNED,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);
```

---

## User Roles & Permissions

### 1. Master Admin
**Full System Access**

- ✅ Login to admin panel
- ✅ Create/Edit/Delete admin accounts
- ✅ Configure system settings
- ✅ Manage company profile
- ✅ Create/Edit/Delete financial records
- ✅ View all reports
- ✅ Access dashboard with statistics

**Default Credentials:**
```
Email: master@cctv.com
Password: Master@123
```

⚠️ **IMPORTANT:** Change password after first login!

### 2. Admin
**Standard Administrator**

- ✅ Login to admin panel
- ✅ View dashboard
- ✅ View all reports
- ✅ Create/View financial records (if permitted)
- ✅ Access limited settings

**Cannot:**
- ❌ Manage other admins
- ❌ Configure system settings
- ❌ Change company profile
- ❌ Delete financial records

### 3. User
**Restricted Read-Only Access**

- ✅ Login to admin panel
- ✅ View reports only
- ✅ View dashboard (basic stats)

**Cannot:**
- ❌ Create/Edit/Delete records
- ❌ Configure settings
- ❌ Manage admins or users

---

## Key Features

### 1. Authentication System
- Secure login with email and password
- Session-based authentication
- Password hashing using bcrypt
- CSRF protection on all forms
- Auto-logout after inactivity

### 2. Admin Management
- Create new admin/user accounts
- Edit admin details and roles
- Change account status (Active/Inactive)
- Delete admin accounts
- View admin list with pagination
- Search functionality

### 3. Financial Management
- Record income (Credit) and expenses (Debit)
- Track financial transactions
- View financial summary and statistics
- Edit and delete transactions
- Export reports to CSV
- Monthly financial analysis

### 4. Reports System
- View all system reports
- Filter and search reports
- Export reports to CSV
- Detailed report view
- Report tracking by creator

### 5. Company Profile
- Manage company information
- Upload company logo
- Store contact details
- Update address and phone

### 6. System Settings
- Configure application settings
- Manage support contact information
- Set session timeout duration
- Control maximum login attempts
- Enable/disable maintenance mode

### 7. Dashboard
- User-friendly overview
- Key statistics display
- Quick access buttons
- Financial summary
- System status monitoring
- Account information display

---

## Testing Guide

### Test Account Creation

1. **Login as Master Admin**
   ```
   Email: master@cctv.com
   Password: Master@123
   ```

2. **Create an Admin Account**
   - Navigate to: Admin Management → Add New Admin
   - Fill in details:
     ```
     Name: Test Admin
     Email: admin@cctv.com
     Password: Admin@123
     Role: Admin
     Status: Active
     ```
   - Click "Create Admin"

3. **Create a User Account**
   - Navigate to: Admin Management → Add New Admin
   - Fill in details:
     ```
     Name: Test User
     Email: user@cctv.com
     Password: User@123
     Role: User
     Status: Active
     ```
   - Click "Create Admin"

### Test Financial Management

1. **Add Credit Transaction**
   - Navigate to: Financial Management
   - Click "Add Transaction"
   - Fill details:
     ```
     Title: Monthly Subscription Revenue
     Amount: 50000
     Type: Credit
     Description: SaaS subscription payment
     ```
   - Click "Create Transaction"

2. **Add Debit Transaction**
   - Click "Add Transaction" again
   - Fill details:
     ```
     Title: Office Rent
     Amount: 25000
     Type: Debit
     Description: Monthly office rent payment
     ```

3. **View Reports**
   - Navigate to: Reports
   - See all transactions with totals
   - Click on a report to see details
   - Export to CSV

### Test Admin Features

1. **Edit Company Profile**
   - Navigate to: Company Profile
   - Fill in company details
   - Upload company logo
   - Save changes

2. **Configure Settings**
   - Navigate to: System Settings
   - Update application settings
   - Adjust session timeout
   - Save configuration

3. **View Dashboard**
   - Navigate to: Dashboard
   - Verify all stats are displaying
   - Check quick action buttons
   - Review user information

### Test User Limitations

1. **Login as User**
   ```
   Email: user@cctv.com
   Password: User@123
   ```

2. **Verify User Can:**
   - ✅ Access dashboard
   - ✅ View reports

3. **Verify User Cannot:**
   - ❌ Access admin management
   - ❌ Access company profile
   - ❌ Access system settings
   - ❌ Access financial management

---

## Troubleshooting

### Common Issues & Solutions

#### 1. **"No application encryption key has been generated" error**

**Solution:**
```bash
php artisan key:generate
```

#### 2. **Database connection errors**

**Check:**
- `database/database.sqlite` file exists
- Database path in `.env` is correct
- File permissions allow read/write

**Fix:**
```bash
# Create database if missing
touch database/database.sqlite

# Re-run migrations
php artisan migrate:fresh

# Seed master admin
php artisan db:seed --class=MasterAdminSeeder
```

#### 3. **"Migrations table not found" error**

**Solution:**
```bash
# Create tables fresh
php artisan migrate:fresh --force

# Re-seed data
php artisan db:seed --class=MasterAdminSeeder
```

#### 4. **Login fails but password is correct**

**Check:**
- Account status is "Active"
- Email is correct (case-sensitive)
- Session driver is not corrupted
- Browser cookies are enabled

**Fix:**
```bash
# Clear sessions
php artisan cache:clear
php artisan config:clear
```

#### 5. **403 Forbidden errors on admin pages**

**Cause:** User doesn't have required role

**Solution:**
- Ensure user has "admin" or "master_admin" role
- Check user status is "active"
- Verify middleware is configured correctly

#### 6. **CSRF token mismatch**

**Solution:**
- Clear browser cache and cookies
- Refresh the page
- Log out and log back in
- Check session configuration in `.env`

#### 7. **File upload failures**

**Check permissions:**
```bash
# Grant write permissions to storage
chmod -R 777 storage/
chmod -R 777 bootstrap/cache/
```

---

## Security Notes

### 🔒 Security Best Practices

1. **Change Default Credentials Immediately**
   ```
   DO NOT use default master admin password in production!
   ```

2. **Use Strong Passwords**
   - Minimum 8 characters
   - Mix of uppercase and lowercase
   - Include numbers and special characters
   - Example: `P@ssw0rd!Secure`

3. **Environment Variables**
   - Never commit `.env` to version control
   - Use `.env.example` for template
   - Keep APP_DEBUG=false in production
   - Use secure APP_KEY

4. **SSL/HTTPS**
   - Always use HTTPS in production
   - Install SSL certificate
   - Force HTTPS in middleware

5. **Session Security**
   - Set appropriate SESSION_LIFETIME
   - Use secure session cookies
   - Implement activity-based logout
   - Regenerate session on login

6. **Password Security**
   - Passwords are hashed with bcrypt
   - Never log passwords
   - Implement password reset functionality
   - Consider 2FA for master admin

7. **Database**
   - Use strong database passwords
   - Restrict database access
   - Regular backups
   - Keep SQLite file outside web root

8. **CSRF Protection**
   - All forms include CSRF tokens
   - Never disable CSRF protection
   - Validate all POST requests

9. **Access Control**
   - Verify user roles on every protected route
   - Use middleware for authorization
   - Implement permission checking
   - Audit admin actions

10. **File Uploads**
    - Validate file types
    - Scan for malware
    - Store outside public directory
    - Set file permissions (644)

---

## API/Routes Reference

### Authentication Routes

```
GET  /admin/login          - Show login form
POST /admin/login          - Process login
POST /admin/logout         - Logout user
```

### Admin Routes (Protected - Admin/Master Admin only)

```
GET  /admin/dashboard                      - Dashboard view
GET  /admin/reports                        - View all reports
GET  /admin/reports/{id}                   - View report details
GET  /admin/reports/export/csv             - Export reports
```

### Master Admin Only Routes

```
# Admin Management
GET    /admin/admins                       - List all admins
GET    /admin/admins/create                - Create admin form
POST   /admin/admins                       - Store new admin
GET    /admin/admins/{id}/edit             - Edit admin form
PUT    /admin/admins/{id}                  - Update admin
DELETE /admin/admins/{id}                  - Delete admin

# System Settings
GET    /admin/system-settings              - View settings
PUT    /admin/system-settings              - Update settings

# Company Profile
GET    /admin/company-profile              - View profile
PUT    /admin/company-profile/{id?}        - Update profile

# Financial Management
GET    /admin/financial                    - View financial overview
GET    /admin/financial/create             - Create transaction form
POST   /admin/financial                    - Store transaction
GET    /admin/financial/{id}               - View transaction
GET    /admin/financial/{id}/edit          - Edit transaction form
PUT    /admin/financial/{id}               - Update transaction
DELETE /admin/financial/{id}               - Delete transaction
```

### Public Routes

```
GET /                                      - Redirect to /admin/login
```

---

## File Structure Overview

```
cctv-pms/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminAuthController.php          [Login/Logout Logic]
│   │   │   ├── DashboardController.php          [Dashboard Stats]
│   │   │   ├── AdminManagementController.php    [Admin CRUD]
│   │   │   ├── SystemSettingsController.php     [Settings Management]
│   │   │   ├── CompanyProfileController.php     [Company Info]
│   │   │   ├── ReportsController.php            [Reports Viewing]
│   │   │   └── FinancialController.php          [Financial CRUD]
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php              [Admin Authorization]
│   │       └── MasterAdminMiddleware.php        [Master Admin Authorization]
│   └── Models/
│       ├── User.php                            [User Model with Relationships]
│       ├── CompanyProfile.php
│       ├── SystemSetting.php
│       └── FinancialReport.php
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 2026_01_19_103051_create_company_profiles_table.php
│   │   ├── 2026_01_19_103051_create_system_settings_table.php
│   │   └── 2026_01_19_103051_create_financial_reports_table.php
│   ├── seeders/
│   │   └── MasterAdminSeeder.php                [Master Admin Creator]
│   └── database.sqlite                          [SQLite Database File]
├── resources/
│   └── views/
│       ├── welcome.blade.php                   [Welcome Page]
│       └── admin/
│           ├── layouts/
│           │   └── app.blade.php               [Master Admin Layout]
│           ├── auth/
│           │   └── login.blade.php             [Login Form]
│           ├── dashboard.blade.php             [Dashboard Page]
│           ├── admin-management/
│           │   ├── index.blade.php
│           │   ├── create.blade.php
│           │   └── edit.blade.php
│           ├── system-settings/
│           │   └── index.blade.php
│           ├── company-profile/
│           │   └── index.blade.php
│           ├── reports/
│           │   ├── index.blade.php
│           │   └── show.blade.php
│           └── financial/
│               ├── index.blade.php
│               ├── create.blade.php
│               ├── edit.blade.php
│               └── show.blade.php
├── routes/
│   └── web.php                                 [Route Definitions]
├── config/
│   ├── app.php
│   ├── database.php
│   └── auth.php
├── .env                                        [Environment Configuration]
├── artisan                                     [Laravel CLI]
├── composer.json                               [PHP Dependencies]
├── package.json                                [Node Dependencies]
└── README.md                                   [Documentation]
```

---

## Deployment Checklist

- [ ] Create `.env` file with production settings
- [ ] Set `APP_DEBUG=false`
- [ ] Set `APP_ENV=production`
- [ ] Generate new `APP_KEY`
- [ ] Run `composer install --no-dev`
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Seed master admin: `php artisan db:seed --class=MasterAdminSeeder`
- [ ] Clear caches: `php artisan cache:clear`
- [ ] Configure SSL/HTTPS
- [ ] Set proper file permissions
- [ ] Configure backup strategy
- [ ] Test all features
- [ ] Change default passwords
- [ ] Set up monitoring/logging
- [ ] Configure email for notifications
- [ ] Test error handling
- [ ] Document deployment steps

---

## Support & Maintenance

For issues or questions:

1. Check this documentation
2. Review error logs in `storage/logs/`
3. Check Laravel error messages
4. Review middleware configuration
5. Verify database connectivity

**Common Log Locations:**
- Laravel logs: `storage/logs/laravel.log`
- Server logs: Check Apache/Nginx error logs
- Database logs: SQLite doesn't have logs, check file permissions

---

## Version Information

- **Application Version:** 1.0.0
- **Laravel Version:** 10
- **PHP Version:** 8.0+
- **Database:** SQLite
- **Bootstrap:** 5.3.0
- **Font Awesome:** 6.4.0

---

## License & Credits

This application is built with:
- [Laravel Framework](https://laravel.com)
- [Bootstrap](https://getbootstrap.com)
- [Font Awesome](https://fontawesome.com)

---

**Last Updated:** January 2026
**Created for:** CCTV PMS Project
**Status:** Production Ready ✅

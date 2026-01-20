# CCTV PMS - Quick Reference Card

## 🚀 Quick Start

### Installation Commands
```bash
cd c:\xampp\htdocs\cctv-pms
composer install
php artisan key:generate
php artisan migrate:fresh
php artisan db:seed --class=MasterAdminSeeder
php artisan serve
```

### Access the App
- **URL:** http://127.0.0.1:8000
- **Auto Redirects to:** /admin/login

---

## 👤 Default Credentials

### Master Admin Account
```
Email: master@cctv.com
Password: Master@123
```

⚠️ **CHANGE THIS PASSWORD IMMEDIATELY IN PRODUCTION!**

---

## 🔑 User Roles Quick Guide

| Feature | Master Admin | Admin | User |
|---------|:----------:|:-----:|:----:|
| Dashboard | ✅ | ✅ | ✅ |
| View Reports | ✅ | ✅ | ✅ |
| Manage Admins | ✅ | ❌ | ❌ |
| System Settings | ✅ | ❌ | ❌ |
| Company Profile | ✅ | ❌ | ❌ |
| Financial Mgmt | ✅ | ❌ | ❌ |

---

## 📁 Project Structure

```
Key Directories:
- app/Http/Controllers/     ← Business Logic
- app/Http/Middleware/      ← Authorization Rules
- app/Models/              ← Database Models
- database/migrations/     ← Schema Files
- resources/views/admin/   ← UI Templates
- routes/web.php          ← URL Routes
```

---

## 🗂️ Main Routes

### Public
- `GET /` → Redirects to `/admin/login`

### Authentication
- `GET /admin/login` → Login form
- `POST /admin/login` → Process login
- `POST /admin/logout` → Logout

### Admin Only (Admin + Master Admin)
- `GET /admin/dashboard` → Dashboard
- `GET /admin/reports` → All reports

### Master Admin Only
- `GET /admin/admins` → Admin management
- `GET /admin/system-settings` → Settings
- `GET /admin/company-profile` → Company info
- `GET /admin/financial` → Financial management

---

## 📊 Database Tables

### users
```
id, name, email, password, role, status, created_at, updated_at
```

### company_profiles
```
id, company_name, address, phone, email, logo, created_at, updated_at
```

### system_settings
```
id, setting_key (unique), setting_value, created_at, updated_at
```

### financial_reports
```
id, title, amount, type (credit/debit), description, created_by, created_at, updated_at
```

---

## 🔐 User Role Values

- `master_admin` → Full system access
- `admin` → Limited admin features
- `user` → Read-only access

## 📊 Account Status Values

- `active` → Can login
- `inactive` → Locked out

---

## 💡 Common Artisan Commands

```bash
# Migration
php artisan migrate                    # Run migrations
php artisan migrate:fresh             # Reset & run migrations
php artisan migrate:rollback          # Undo last migration

# Seeding
php artisan db:seed --class=MasterAdminSeeder

# Cache & Config
php artisan cache:clear               # Clear cache
php artisan config:clear              # Clear config cache
php artisan route:clear               # Clear route cache

# Server
php artisan serve                     # Start dev server (port 8000)
php artisan serve --port=3000         # Start on custom port

# Make Commands
php artisan make:controller NameController
php artisan make:model ModelName -m   # With migration
php artisan make:middleware MiddlewareName
```

---

## 🛠️ File Permission (Linux/Mac)

```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
chmod 644 database/database.sqlite
```

---

## 🐛 Debugging

### Enable Debug Mode
Edit `.env`:
```
APP_DEBUG=true
```

### View Logs
```bash
tail -f storage/logs/laravel.log
```

### Clear Everything
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

---

## 📝 Environment Variables (.env)

```env
APP_NAME=CCTV PMS
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=sqlite
DB_DATABASE=c:\xampp\htdocs\cctv-pms\database\database.sqlite

SESSION_DRIVER=file
CACHE_DRIVER=file
```

---

## 🔍 File Locations

| What | Location |
|------|----------|
| Database | `database/database.sqlite` |
| Migrations | `database/migrations/` |
| Controllers | `app/Http/Controllers/` |
| Models | `app/Models/` |
| Views | `resources/views/` |
| Routes | `routes/web.php` |
| Config | `config/` |
| Logs | `storage/logs/` |
| Cache | `bootstrap/cache/` |

---

## 🧪 Test Accounts to Create

```
Test Admin:
Email: admin@example.com
Password: TestAdmin@123
Role: Admin
Status: Active

Test User:
Email: user@example.com
Password: TestUser@123
Role: User
Status: Active
```

---

## ⚠️ Common Errors & Fixes

| Error | Solution |
|-------|----------|
| `No application encryption key` | `php artisan key:generate` |
| `SQLite database file not found` | `touch database/database.sqlite` |
| `Migrations table not found` | `php artisan migrate:fresh` |
| `CSRF token mismatch` | Clear cookies & cache |
| `500 error on login` | Check `.env` configuration |
| `View not found` | Check blade file path & namespace |

---

## 📞 Quick Help

**Dashboard URL:** http://127.0.0.1:8000/admin/dashboard

**Login Page:** http://127.0.0.1:8000/admin/login

**Default Master Admin:** master@cctv.com / Master@123

**Development Server:** `php artisan serve`

**Stop Server:** Press `Ctrl + C` in terminal

---

## ✅ Verification Checklist

After setup, verify:

- [ ] Server running on http://127.0.0.1:8000
- [ ] Can access login page
- [ ] Can login with master@cctv.com
- [ ] Dashboard displays with statistics
- [ ] Can create a new admin
- [ ] Can access company profile
- [ ] Can access system settings
- [ ] Can add financial records
- [ ] Can view reports
- [ ] Can logout successfully
- [ ] Session expires after inactivity
- [ ] All forms have CSRF protection

---

## 🎯 Next Steps

1. ✅ Complete initial setup
2. 📝 Create test accounts
3. 🧪 Test all features
4. 🔐 Change master admin password
5. ⚙️ Configure system settings
6. 🏢 Add company information
7. 📊 Add sample financial records
8. 🚀 Deploy to production

---

**Last Updated:** January 2026  
**Status:** Production Ready ✅

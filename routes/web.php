<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\SystemSettingsController;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\FinancialController;

// Root redirect to general login
Route::get('/', function () {
    return redirect()->route('login');
});

// General Login Route - points to the admin login form as the primary login for the application.
// This route is named 'login' to be compatible with Laravel's default authentication scaffolding.
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');

// Admin Authentication Routes (Without Middleware)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
});
// Admin Protected Routes (With AdminMiddleware)
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Reports
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('/reports/{id}', [ReportsController::class, 'show'])->name('reports.show');
    Route::get('/reports/export/csv', [ReportsController::class, 'export'])->name('reports.export');

    // Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// Master Admin Protected Routes (With MasterAdminMiddleware)
Route::prefix('admin')->middleware(['auth', 'master-admin'])->name('admin.')->group(function () {
    // Admin Management
    Route::get('/admins', [AdminManagementController::class, 'index'])->name('admins.index');
    Route::get('/admins/create', [AdminManagementController::class, 'create'])->name('admins.create');
    Route::post('/admins', [AdminManagementController::class, 'store'])->name('admins.store');
    Route::get('/admins/{id}/edit', [AdminManagementController::class, 'edit'])->name('admins.edit');
    Route::put('/admins/{id}', [AdminManagementController::class, 'update'])->name('admins.update');
    Route::delete('/admins/{id}', [AdminManagementController::class, 'destroy'])->name('admins.destroy');

    // System Settings
    Route::get('/system-settings', [SystemSettingsController::class, 'index'])->name('system-settings.index');
    Route::put('/system-settings', [SystemSettingsController::class, 'update'])->name('system-settings.update');

    // Company Profile
    Route::get('/company-profile', [CompanyProfileController::class, 'index'])->name('company-profile.index');
    Route::put('/company-profile/{id?}', [CompanyProfileController::class, 'update'])->name('company-profile.update');

    // Financial Management
    Route::get('/financial', [FinancialController::class, 'index'])->name('financial.index');
    Route::get('/financial/create', [FinancialController::class, 'create'])->name('financial.create');
    Route::post('/financial', [FinancialController::class, 'store'])->name('financial.store');
    Route::get('/financial/{id}', [FinancialController::class, 'show'])->name('financial.show');
    Route::get('/financial/{id}/edit', [FinancialController::class, 'edit'])->name('financial.edit');
    Route::put('/financial/{id}', [FinancialController::class, 'update'])->name('financial.update');
    Route::delete('/financial/{id}', [FinancialController::class, 'destroy'])->name('financial.destroy');
});

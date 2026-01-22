<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\SystemSettingsController;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CameraResourceController;
use App\Http\Controllers\AdminPaymentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UnitController;

// Root redirect to general login
Route::get('/', function () {
    return redirect()->route('login');
});

// General Login Route
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');

// General Logout Route
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::resource('cameras', CameraResourceController::class);

// Admin and Master Admin Protected Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::resource('/products', ProductController::class)->names('products');
    Route::resource('/categories', CategoryController::class)->names('categories');
    Route::resource('/units', UnitController::class)->names('units');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/admins', AdminManagementController::class)->names('admins')->except(['show']);
    Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');
    Route::post('/approvals/purchase/{id}/approve', [ApprovalController::class, 'approvePurchase'])->name('approvals.purchase.approve');
    Route::post('/approvals/purchase/{id}/reject', [ApprovalController::class, 'rejectPurchase'])->name('approvals.purchase.reject');
    Route::post('/approvals/sale/{id}/approve', [ApprovalController::class, 'approveSale'])->name('approvals.sale.approve');
    Route::post('/approvals/sale/{id}/reject', [ApprovalController::class, 'rejectSale'])->name('approvals.sale.reject');
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('/financial', [FinancialController::class, 'index'])->name('financial.index');
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
});

// User Protected Routes
Route::prefix('user')->middleware(['auth', 'user'])->name('user.')->group(function() {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::resource('purchases', PurchaseController::class);
    Route::resource('sales', SalesController::class);
    Route::get('products', [\App\Http\Controllers\ProductController::class, 'userIndex'])->name('products.index');
    Route::resource('inventory', InventoryController::class)->parameters(['inventory' => 'product']);
    Route::resource('payments', PaymentController::class);
});

// Master Admin Exclusive Routes
Route::prefix('admin')->middleware(['auth', 'master-admin'])->name('admin.')->group(function () {
    Route::get('/system-settings', [SystemSettingsController::class, 'index'])->name('system-settings.index');
    Route::put('/system-settings', [SystemSettingsController::class, 'update'])->name('system-settings.update');
    Route::get('/company-profile', [CompanyProfileController::class, 'index'])->name('company-profile.index');
    Route::put('/company-profile/{id?}', [CompanyProfileController::class, 'update'])->name('company-profile.update');

});
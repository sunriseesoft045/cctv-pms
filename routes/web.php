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
Route::middleware(['auth','admin'])->group(function () {
    Route::resource('/admin/products', ProductController::class);
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/admin/admins', AdminManagementController::class)->except(['show']);
    Route::get('/admin/approvals', [ApprovalController::class, 'index'])->name('admin.approvals.index');
    Route::post('/admin/approvals/purchase/{id}/approve', [ApprovalController::class, 'approvePurchase'])->name('admin.approvals.purchase.approve');
    Route::post('/admin/approvals/purchase/{id}/reject', [ApprovalController::class, 'rejectPurchase'])->name('admin.approvals.purchase.reject');
    Route::post('/admin/approvals/sale/{id}/approve', [ApprovalController::class, 'approveSale'])->name('admin.approvals.sale.approve');
    Route::post('/admin/approvals/sale/{id}/reject', [ApprovalController::class, 'rejectSale'])->name('admin.approvals.sale.reject');
    Route::get('/admin/reports', [ReportsController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/reports/{id}', [ReportsController::class, 'show'])->name('admin.reports.show');
    Route::get('/admin/reports/export/csv', [ReportsController::class, 'export'])->name('admin.reports.export');
    Route::get('/admin/payments', [AdminPaymentController::class, 'index'])->name('admin.payments.index');
});

// User Protected Routes
Route::prefix('user')->middleware(['auth', 'user'])->name('user.')->group(function() {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::resource('purchases', PurchaseController::class);
    Route::resource('sales', SalesController::class);
    Route::resource('inventory', InventoryController::class)->parameters(['inventory' => 'product']);
    Route::resource('payments', PaymentController::class);
});

// Master Admin Exclusive Routes
Route::prefix('admin')->middleware(['auth', 'master-admin'])->name('admin.')->group(function () {
    Route::get('/system-settings', [SystemSettingsController::class, 'index'])->name('system-settings.index');
    Route::put('/system-settings', [SystemSettingsController::class, 'update'])->name('system-settings.update');
    Route::get('/company-profile', [CompanyProfileController::class, 'index'])->name('company-profile.index');
    Route::put('/company-profile/{id?}', [CompanyProfileController::class, 'update'])->name('company-profile.update');
    Route::get('/financial', [FinancialController::class, 'index'])->name('financial.index');
    Route::get('/financial/create', [FinancialController::class, 'create'])->name('financial.create');
    Route::post('/financial', [FinancialController::class, 'store'])->name('financial.store');
    Route::get('/financial/{id}', [FinancialController::class, 'show'])->name('financial.show');
    Route::get('/financial/{id}/edit', [FinancialController::class, 'edit'])->name('financial.edit');
    Route::put('/financial/{id}', [FinancialController::class, 'update'])->name('financial.update');
    Route::delete('/financial/{id}', [FinancialController::class, 'destroy'])->name('financial.destroy');
});
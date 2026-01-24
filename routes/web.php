<?php

use Illuminate\Support\Facades\Route;
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
use App\Http\Controllers\Admin\BomController;
use App\Http\Controllers\Admin\AssemblyController;
use App\Http\Controllers\Admin\PartController;
use App\Http\Controllers\Admin\VendorController as AdminVendorController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\QuotationController;
use App\Models\FinishedProduct;

// Root redirect to general login
Route::get('/', function () {
    return redirect()->route('login');
});

// General Login Route
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// General Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('cameras', CameraResourceController::class);

// Admin Protected Routes (applies to 'admin' role, and 'master_admin' for routes not explicitly handled below)
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
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index'); // Existing generic reports route, will be superseded by specific ones
    Route::get('/financial', [FinancialController::class, 'index'])->name('financial.index');
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');

    // Assemblies - Full CRUD for Admin (admin role has full access as per task)
    Route::resource('/assemblies', AssemblyController::class)->names('assemblies');

    // Parts - Full CRUD for Admin
    Route::resource('/parts', PartController::class)->names('parts');
    Route::post('/parts/{part}/stock-in', [PartController::class,'stockIn'])->name('parts.stock-in');
    Route::post('/parts/{part}/stock-out', [PartController::class,'stockOut'])->name('parts.stock-out');

    // Vendors and Customers - Full CRUD for Admin
    Route::resource('/vendors', AdminVendorController::class)->names('vendors');
    Route::resource('/customers', AdminCustomerController::class)->names('customers');

    // Purchases - Admin View and Approve/Reject
    Route::get('/purchases', [PurchaseController::class,'index'])->name('purchases.index');
    Route::post('/purchases/{purchase}/approve', [PurchaseController::class,'approve'])->name('purchases.approve');
    Route::post('/purchases/{purchase}/reject', [PurchaseController::class,'reject'])->name('purchases.reject');

    // Sales - Admin View and Approve/Reject
    Route::get('/sales', [SalesController::class,'index'])->name('sales.index');
    Route::post('/sales/{sale}/approve', [SalesController::class,'approve'])->name('sales.approve');
    Route::post('/sales/{sale}/reject', [SalesController::class,'reject'])->name('sales.reject');

    // New Reports Routes for Admin
    Route::get('/reports/inventory', [ReportsController::class,'inventoryReport'])->name('reports.inventory');
    Route::get('/reports/monthly-sales', [ReportsController::class,'monthlySales'])->name('reports.monthly-sales');
    Route::get('/reports/low-stock', [ReportsController::class,'lowStock'])->name('reports.low-stock');
    Route::get('/reports/dues', [ReportsController::class,'dues'])->name('reports.dues');
});

// User Protected Routes
Route::prefix('user')->middleware(['auth', 'user'])->name('user.')->group(function() {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::resource('purchases', PurchaseController::class);
    Route::resource('sales', SalesController::class);
    Route::get('products', [\App\Http\Controllers\ProductController::class, 'userIndex'])->name('products.index');
    Route::resource('inventory', InventoryController::class)->parameters(['inventory' => 'product']);
    Route::resource('payments', PaymentController::class);

    // Remove old generic Invoice and Quotation generation routes
    // Route::get('/invoice/{type}/{id}', [InvoiceController::class, 'generate'])->name('invoice.generate');
    // Route::get('/quotation/{type}/{id}', [QuotationController::class, 'generate'])->name('quotation.generate');

    // Vendors and Customers - User Create + View only
    Route::get('/vendors', [AdminVendorController::class,'index'])->name('vendors.index');
    Route::get('/vendors/create', [AdminVendorController::class,'create'])->name('vendors.create');
    Route::post('/vendors', [AdminVendorController::class,'store'])->name('vendors.store');
    Route::get('/customers', [AdminCustomerController::class,'index'])->name('customers.index');
    Route::get('/customers/create', [AdminCustomerController::class,'create'])->name('customers.create');
    Route::post('/customers', [AdminCustomerController::class,'store'])->name('customers.store');

    // Parts (user view only)
    Route::get('/parts', [PartController::class,'userIndex'])->name('parts.index');
});

// General Authenticated Routes for Invoice/Quotation generation
Route::middleware(['auth'])->group(function () {
  Route::get('/invoice/sale/{id}', [InvoiceController::class,'saleInvoice'])->name('invoice.sale');
  Route::get('/invoice/purchase/{id}', [InvoiceController::class,'purchaseInvoice'])->name('invoice.purchase');
  Route::get('/quotation/customer/{id}', [QuotationController::class,'customerQuotation'])->name('quotation.customer');
});

// Master Admin Exclusive Routes (inherits 'admin' middleware, but specific routes can override/add)
Route::prefix('admin')->middleware(['auth', 'master-admin'])->name('admin.')->group(function () {
    Route::get('/system-settings', [SystemSettingsController::class, 'index'])->name('system-settings.index');
    Route::put('/system-settings', [SystemSettingsController::class, 'update'])->name('system-settings.update');
    Route::get('/company-profile', [CompanyProfileController::class, 'index'])->name('company-profile.index');
    Route::put('/company-profile/{id?}', [CompanyProfileController::class, 'update'])->name('company-profile.update');

    // BOMs - Full CRUD for Master Admin (overrides admin view-only)
    Route::resource('/boms', BomController::class)->names('boms');

    // Assemblies - View only for Master Admin (admin role has full CRUD)
    Route::get('/assemblies', [AssemblyController::class,'index'])->name('assemblies.index');

    // New Reports Route for Master Admin
    Route::get('/reports/profit-loss', [ReportsController::class,'profitLoss'])->name('reports.profit-loss');
});
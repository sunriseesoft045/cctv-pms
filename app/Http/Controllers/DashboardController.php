<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product; // Keep this for now if any old product data exists
use App\Models\Part; // Corrected
use App\Models\FinishedProduct; // Corrected
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show Admin Dashboard
     */
    public function index()
    {
        // Count Statistics
        $totalAdmins = User::where('role', 'admin')->count();
        $totalUsers = User::where('role', 'user')->count();
        // $totalProducts = Product::count(); // Old product count

        // New Inventory Totals
        $totalPartsStock = Part::sum('stock');
        $totalFinishedProductsStock = FinishedProduct::sum('stock');
        $totalInventoryStock = $totalPartsStock + $totalFinishedProductsStock;

        // Financial Data (using new structures)
        $totalSalesAmount = Sale::where('status', 'approved')->sum('total_amount');
        $totalPurchasesAmount = Purchase::where('status', 'approved')->sum('total_amount');
        $totalPaymentsReceived = Payment::where('type', 'customer')->sum('amount');
        $totalPaymentsPaid = Payment::where('type', 'vendor')->sum('amount');

        // Profit/Loss Analysis
        $profitLoss = $totalSalesAmount - $totalPurchasesAmount;

        // Low Stock Alerts (Parts)
        $lowStockPartsCount = Part::whereColumn('stock', '<=', 'min_stock')->count();

        // Total Dues
        $customerDues = Sale::where('status', 'approved')
                            ->get()
                            ->sum(function ($sale) {
                                return $sale->total_amount - $sale->payments()->sum('amount');
                            });
        $vendorDues = Purchase::where('status', 'approved')
                            ->get()
                            ->sum(function ($purchase) {
                                return $purchase->total_amount - $purchase->payments()->sum('amount');
                            });
        $totalDues = $customerDues + $vendorDues;

        // Monthly Sales Data (This Month)
        $currentMonthSales = Sale::where('status', 'approved')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_amount');
        
        // You can keep other existing dashboard data if it still aligns with the new schema,
        // or remove/update it as needed. For now, integrating the new requirements.

        return view('admin.dashboard', compact(
            'totalAdmins',
            'totalUsers',
            'totalInventoryStock', // New
            'totalSalesAmount', // New
            'totalPurchasesAmount', // New
            'totalPaymentsReceived', // New
            'totalPaymentsPaid', // New
            'profitLoss',
            'lowStockPartsCount', // New
            'customerDues', // New
            'vendorDues', // New
            'totalDues', // New
            'currentMonthSales' // New
            // 'totalProducts', // Old, removed
            // 'totalStock', // Old, replaced by totalInventoryStock
            // 'lowStockProducts', // Old, replaced by lowStockPartsCount
            // 'monthlySales', // Old, can be kept/modified for monthly trends
            // 'recentSales',
            // 'recentPayments',
            // 'lowStockAlerts',
            // 'topProducts',
            // 'totalPayments' // Old, replaced by totalPaymentsReceived/Paid
        ));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Part; 
use App\Models\FinishedProduct; 
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

        // Inventory Totals
        $totalPartsStock = Part::sum('stock');
        $totalFinishedProductsStock = FinishedProduct::sum('stock');
        $totalInventoryStock = $totalPartsStock + $totalFinishedProductsStock;

        // Financial Data (across all users)
        $totalSalesAmount = Sale::where('status', 'approved')->sum('total_amount');
        $totalPurchasesAmount = Purchase::where('status', 'approved')->sum('total_amount');
        
        // Payments: Sale Receipt = CREDIT, Purchase Payment = DEBIT
        $totalCredit = Payment::where('type', 'sale')->sum('amount');
        $totalDebit = Payment::where('type', 'purchase')->sum('amount');

        // Profit/Loss Analysis
        $profitLoss = $totalSalesAmount - $totalPurchasesAmount;

        // Low Stock Alerts (Parts)
        $lowStockPartsCount = Part::whereColumn('stock', '<=', 'min_stock')->count();

        // Total Dues Calculation (across all users)
        $customerDues = Sale::where('status', 'approved')
                            ->sum(DB::raw('total_amount - (SELECT SUM(amount) FROM payments WHERE sale_id = sales.id AND type = "sale")'));
        
        $vendorDues = Purchase::where('status', 'approved')
                            ->sum(DB::raw('total_amount - (SELECT SUM(amount) FROM payments WHERE purchase_id = purchases.id AND type = "purchase")'));
        
        // Ensure no negative dues
        $customerDues = max(0, $customerDues);
        $vendorDues = max(0, $vendorDues);

        $totalDues = $customerDues + $vendorDues;

        // Monthly Sales Data (This Month)
        $currentMonthSales = Sale::where('status', 'approved')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_amount');
        
        return view('admin.dashboard', compact(
            'totalAdmins',
            'totalUsers',
            'totalInventoryStock',
            'totalSalesAmount',
            'totalPurchasesAmount',
            'totalCredit', // Updated from totalPaymentsReceived
            'totalDebit',  // Updated from totalPaymentsPaid
            'profitLoss',
            'lowStockPartsCount',
            'customerDues',
            'vendorDues',
            'totalDues',
            'currentMonthSales'
        ));
    }
}
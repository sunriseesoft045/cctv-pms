<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $totalProducts = Product::count();

        // Financial Data
        $totalSales = Sale::where('status', 'approved')->sum(DB::raw('quantity * price'));
        $totalPurchases = Purchase::where('status', 'approved')->sum(DB::raw('quantity * cost'));
        $totalPayments = Payment::sum('amount');

        // Profit/Loss Analysis
        $profitLoss = $totalSales - $totalPurchases;

        // Stock Overview
        $totalStock = Product::sum('stock');
        $lowStockProducts = Product::where('stock', '<', 5)->count();

        // Monthly Sales Data (Last 6 months)
        $driver = DB::getDriverName();
        if ($driver === 'sqlite') {
            $dateExpr = "strftime('%Y-%m', created_at)";
        } else {
            $dateExpr = "DATE_FORMAT(created_at, '%Y-%m')";
        }

        $monthlySales = Sale::where('status', 'approved')
            ->selectRaw($dateExpr . ' as month, SUM(quantity * price) as total')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get();
        
        // Reverse to show chronological order (oldest to newest)
        $monthlySales = $monthlySales->reverse();

        // Recent Transactions
        $recentSales = Sale::where('status', 'approved')
            ->with('product', 'user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentPayments = Payment::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Low Stock Alerts
        $lowStockAlerts = Product::where('stock', '<', 5)
            ->orderBy('stock', 'asc')
            ->get();

        // Top Selling Products
        $topProducts = Sale::where('status', 'approved')
            ->select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->with('product')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalAdmins',
            'totalUsers',
            'totalProducts',
            'totalSales',
            'totalPurchases',
            'profitLoss',
            'totalStock',
            'lowStockProducts',
            'monthlySales',
            'recentSales',
            'recentPayments',
            'lowStockAlerts',
            'topProducts',
            'totalPayments'
        ));
    }
}
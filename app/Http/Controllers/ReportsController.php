<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = [
            'totalUsers' => User::where('role', 'user')->count(),
            'totalAdmins' => User::where('role', 'admin')->count(),
            'totalSales' => Sale::count(),
            'totalPurchases' => Purchase::count(),
            'totalPayments' => Payment::sum('amount'),
            'latestSales' => Sale::with('product', 'user')->latest()->take(10)->get(),
            'latestPurchases' => Purchase::with('product', 'user')->latest()->take(10)->get(),
        ];

        return view('admin.reports.index', compact('reports'));
    }
}

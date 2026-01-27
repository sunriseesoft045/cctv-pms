<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $totalPurchases = Purchase::where('created_by', Auth::id())->count();
        $totalSales = Sale::where('created_by', Auth::id())->count();
        
        $totalCredit = Payment::where('user_id', Auth::id())->where('type', 'sale')->sum('amount');
        $totalDebit = Payment::where('user_id', Auth::id())->where('type', 'purchase')->sum('amount');
        $netBalance = $totalCredit - $totalDebit;

        return view('user.dashboard', compact('totalPurchases', 'totalSales', 'totalCredit', 'totalDebit', 'netBalance'));
    }
}
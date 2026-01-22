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
        $totalPayments = Payment::where('created_by', Auth::id())->sum('amount');

        return view('user.dashboard', compact('totalPurchases', 'totalSales', 'totalPayments'));
    }
}
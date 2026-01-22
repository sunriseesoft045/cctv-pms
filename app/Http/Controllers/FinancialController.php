<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Purchase;
use Illuminate\Http\Request;

class FinancialController extends Controller
{
    /**
     * Display financial overview dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $totalCredit = Payment::sum('amount');
        $totalDebit = Purchase::sum('cost');
        $latestPayments = Payment::with('user')->latest()->take(10)->get();
        $latestPurchases = Purchase::with('user')->latest()->take(10)->get();

        return view('admin.financial.index', compact(
            'totalCredit',
            'totalDebit',
            'latestPayments',
            'latestPurchases'
        ));
    }
}

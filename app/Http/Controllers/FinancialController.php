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
        $totalCredit = Payment::where('type', 'sale')->sum('amount');
        $totalDebit = Payment::where('type', 'purchase')->sum('amount');
        $netBalance = $totalCredit - $totalDebit;

        $latestPayments = Payment::with('user')->latest()->take(10)->get();
        // Assuming latestPurchases is still relevant as general purchase overview, not directly debit payments.
        // If 'cost' is meant to be the total of purchase payments, then it should query payments table as well.
        // For now, keeping as original to not introduce new changes beyond request scope.
        $latestPurchases = Purchase::with('user')->latest()->take(10)->get(); 

        return view('admin.financial.index', compact(
            'totalCredit',
            'totalDebit',
            'netBalance', // Add netBalance to compact
            'latestPayments',
            'latestPurchases'
        ));
    }
}

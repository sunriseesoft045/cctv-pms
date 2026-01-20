<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase; // Assuming Purchase model exists for approvals
use App\Models\Sale;     // Assuming Sale model exists for approvals

class ApprovalController extends Controller
{
    /**
     * Display a listing of pending approvals (Purchases and Sales).
     */
    public function index()
    {
        $pendingPurchases = Purchase::where('status', 'pending')->paginate(10, ['*'], 'purchases');
        $pendingSales = Sale::where('status', 'pending')->paginate(10, ['*'], 'sales');
        
        return view('admin.approvals.index', compact('pendingPurchases', 'pendingSales'));
    }

    /**
     * Approve a purchase.
     */
    public function approvePurchase($id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->status = 'approved';
        $purchase->save();

        return back()->with('success', 'Purchase approved successfully.');
    }

    /**
     * Reject a purchase.
     */
    public function rejectPurchase($id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->status = 'rejected'; // Assuming 'rejected' status
        $purchase->save();

        return back()->with('error', 'Purchase rejected.');
    }

    /**
     * Approve a sale.
     */
    public function approveSale($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->status = 'approved';
        $sale->save();

        return back()->with('success', 'Sale approved successfully.');
    }

    /**
     * Reject a sale.
     */
    public function rejectSale($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->status = 'rejected'; // Assuming 'rejected' status
        $sale->save();

        return back()->with('error', 'Sale rejected.');
    }
}

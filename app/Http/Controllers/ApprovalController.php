<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase; // Assuming Purchase model exists for approvals
use App\Models\Sale;     // Assuming Sale model exists for approvals
use App\Models\Product;

class ApprovalController extends Controller
{
    /**
     * Display a listing of pending approvals (Purchases and Sales).
     */
    public function index()
    {
        $pendingPurchases = Purchase::with('user', 'product')->where('status', 'pending')->paginate(10, ['*'], 'purchases');
        $pendingSales = Sale::with('user', 'product')->where('status', 'pending')->paginate(10, ['*'], 'sales');
        
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

        // Increment stock
        $product = Product::find($purchase->product_id);
        if ($product) {
            $product->increment('stock', $purchase->quantity);
        }

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

        // Decrement stock
        $product = Product::find($sale->product_id);
        if ($product) {
            // Ensure stock does not go below zero
            if ($product->stock >= $sale->quantity) {
                $product->decrement('stock', $sale->quantity);
            } else {
                // Optionally handle insufficient stock, e.g., log, return error
                // For now, we'll just prevent negative stock
                return back()->with('error', 'Insufficient stock for this sale.');
            }
        }

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

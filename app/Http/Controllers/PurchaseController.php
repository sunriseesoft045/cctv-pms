<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('product', 'user')
            ->where('created_by', Auth::id())
            ->latest()
            ->paginate(10);
        
        return view('user.purchases.index', compact('purchases'));
    }

    public function create()
    {
        $products = Product::all();
        return view('user.purchases.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'cost' => 'required|numeric|min:0.01',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['status'] = 'pending';

        Purchase::create($validated);

        return redirect()->route('user.purchases.index')
            ->with('success', 'Purchase created successfully and pending for approval.');
    }

    public function show(Purchase $purchase)
    {
        $this->authorize('view', $purchase);
        return view('user.purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase)
    {
        $this->authorize('update', $purchase);
        $products = Product::all();
        return view('user.purchases.edit', compact('purchase', 'products'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        $this->authorize('update', $purchase);

        // Only allow editing if status is pending
        if ($purchase->status !== 'pending') {
            return redirect()->route('user.purchases.index')
                ->with('error', 'Cannot edit approved purchases.');
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'cost' => 'required|numeric|min:0.01',
        ]);

        $purchase->update($validated);

        return redirect()->route('user.purchases.index')
            ->with('success', 'Purchase updated successfully.');
    }

    public function destroy(Purchase $purchase)
    {
        $this->authorize('delete', $purchase);

        // Only allow deleting if status is pending
        if ($purchase->status !== 'pending') {
            return redirect()->route('user.purchases.index')
                ->with('error', 'Cannot delete approved purchases.');
        }

        $purchase->delete();

        return redirect()->route('user.purchases.index')
            ->with('success', 'Purchase deleted successfully.');
    }
}
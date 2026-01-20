<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::with('product', 'user')
            ->where('created_by', Auth::id())
            ->latest()
            ->paginate(10);
        
        return view('user.sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::all();
        return view('user.sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0.01',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['status'] = 'pending';

        Sale::create($validated);

        return redirect()->route('user.sales.index')
            ->with('success', 'Sale created successfully and pending for approval.');
    }

    public function show(Sale $sale)
    {
        $this->authorize('view', $sale);
        return view('user.sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $this->authorize('update', $sale);
        $products = Product::all();
        return view('user.sales.edit', compact('sale', 'products'));
    }

    public function update(Request $request, Sale $sale)
    {
        $this->authorize('update', $sale);

        if ($sale->status !== 'pending') {
            return redirect()->route('user.sales.index')
                ->with('error', 'Cannot edit approved sales.');
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0.01',
        ]);

        $sale->update($validated);

        return redirect()->route('user.sales.index')
            ->with('success', 'Sale updated successfully.');
    }

    public function destroy(Sale $sale)
    {
        $this->authorize('delete', $sale);

        if ($sale->status !== 'pending') {
            return redirect()->route('user.sales.index')
                ->with('error', 'Cannot delete approved sales.');
        }

        $sale->delete();

        return redirect()->route('user.sales.index')
            ->with('success', 'Sale deleted successfully.');
    }
}
<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\FinishedProduct;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $sales = Sale::where('created_by', Auth::id())->with('customer', 'items')->latest()->get();
        
        if ($request->wantsJson()) {
            return response()->json($sales);
        }

        return view('user.sales.index', compact('sales'));
    }

    public function show(Request $request, $id)
    {
        $sale = Sale::with('customer', 'items.finishedProduct')->findOrFail($id);

        if ($sale->created_by !== Auth::id()) {
            abort(403);
        }

        if ($request->wantsJson()) {
            return response()->json($sale);
        }

        return view('user.sales.show', compact('sale'));
    }

    public function create()
    {
        $products = FinishedProduct::all();
        $customers = Customer::all();
        return view('user.sales.create', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_address' => 'nullable|string|max:255',
            'products.*.id' => 'required|exists:finished_products,id',
            'products.*.quantity' => 'required|numeric|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        $customer = Customer::firstOrCreate(
            ['name' => $request->customer_name],
            [
                'phone' => $request->customer_phone,
                'address' => $request->customer_address,
                'email' => $request->customer_name . '@example.com', // Dummy email
            ]
        );

        $total = 0;
        foreach ($request->products as $product) {
            $total += $product['quantity'] * $product['price'];
        }

        $sale = Sale::create([
            'customer_id' => $customer->id,
            'invoice_no' => 'INV-SALE-' . time(),
            'total_amount' => $total,
            'gst_amount' => $total * 0.18, // Assuming 18% GST
            'status' => 'completed',
            'created_by' => Auth::id(),
        ]);

        foreach ($request->products as $product) {
            $sale->items()->create([
                'finished_product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]);
            // Decrement stock
            FinishedProduct::find($product['id'])->decrement('stock', $product['quantity']);
        }

        return redirect()->route('user.sales.index')->with('success', 'Sale created successfully');
    }

    public function edit($id)
    {
        $sales = Sale::with('customer', 'items')->findOrFail($id);
        $products = FinishedProduct::all();
        $customers = Customer::all();
        return view('user.sales.edit', compact('sale', 'products', 'customers'));
    }
    

    public function update(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'status' => 'required',
            'products.*.id' => 'required|exists:finished_products,id',
            'products.*.quantity' => 'required|numeric|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        $total = 0;
        foreach ($request->products as $product) {
            $total += $product['quantity'] * $product['price'];
        }

        // Re-increment old stock
        foreach ($sale->items as $item) {
            FinishedProduct::find($item->finished_product_id)->increment('stock', $item->quantity);
        }

        $sale->update([
            'customer_id' => $request->customer_id,
            'total_amount' => $total,
            'gst_amount' => $total * 0.18, // Assuming 18% GST
            'status' => $request->status,
        ]);

        $sale->items()->delete();

        foreach ($request->products as $product) {
            $sale->items()->create([
                'finished_product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]);
            // Decrement new stock
            FinishedProduct::find($product['id'])->decrement('stock', $product['quantity']);
        }

        return redirect()->route('user.sales.index')->with('success', 'Sale updated successfully');
    }

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        // Re-increment stock before deleting
        foreach ($sale->items as $item) {
            FinishedProduct::find($item->finished_product_id)->increment('stock', $item->quantity);
        }
        $sale->delete();
        return redirect()->route('user.sales.index')->with('success', 'Sale deleted');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Vendor; // New
use App\Models\Part; // New
use App\Models\PurchaseItem; // New
use App\Models\PartStock; // New
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // New
use Illuminate\Validation\Rule; // New

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     * Accessible by User (own purchases) and Admin (all purchases)
     */
    public function index()
    {
        $purchases = Purchase::with('items.part','vendor')->latest()->get();
        return view('user.purchases.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     * Accessible only by User.
     */
    public function create()
    {
        $parts = \App\Models\Part::orderBy('name')->get();
        return view('user.purchases.create', compact('parts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vendor_name' => 'required|string',
            'invoice_no' => 'required|string|unique:purchases',
            'vendor_phone' => 'required|string|max:20',
            'vendor_address' => 'required|string|max:255',
            'parts' => 'required|array',
            'qty' => 'required|array',
            'price' => 'required|array',
        ]);

        $vendor = \App\Models\Vendor::firstOrCreate(['name' => $data['vendor_name']]);
        $total = 0;

        foreach ($request->parts as $i => $partId) {
            $total += ($request->qty[$i] * $request->price[$i]);
        }

        $purchase = \App\Models\Purchase::create([
            'created_by' => auth()->id(),
            'vendor_id' => $vendor->id,
            'invoice_no' => $data['invoice_no'],
            'vendor_phone' => $request->vendor_phone,
            'vendor_address' => $request->vendor_address,
            'total_amount' => $total,
            'status' => 'completed'
        ]);

        foreach ($request->parts as $i => $partId) {
            $qty = (int)$request->qty[$i];
            $price = (float)$request->price[$i];

            $purchase->items()->create([
                'part_id' => $partId,
                'quantity' => $qty,
                'price' => $price
            ]);

            // AUTO STOCK IN
            \App\Models\Part::where('id', $partId)
                ->increment('stock', $qty);
        }

        return redirect()->route('user.purchases.index')
            ->with('success', 'Purchase created & stock updated');
    }

    /**
     * Display the specified resource.
     * Accessible by User (own purchase) and Admin (any purchase).
     */
    public function show($id){
        $purchase = Purchase::with('items.part','vendor')->findOrFail($id);
        if (Auth::user()->role === 'user' && $purchase->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('user.purchases.show', compact('purchase'));
    }

    public function edit($id) {
        $purchase = Purchase::with('items.part','vendor')->findOrFail($id);
        if (Auth::user()->role === 'user' && $purchase->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $vendors = Vendor::all();
        $parts = Part::all();
        return view('user.purchases.edit', compact('purchase','vendors','parts'));
    }

    public function update(Request $request, $id) {
        $purchase = Purchase::findOrFail($id);
        if (Auth::user()->role === 'user' && $purchase->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'status' => 'required',
            'vendor_phone' => 'required|string|max:20',
            'vendor_address' => 'required|string|max:255',
            'items.*.part_id' => 'required|exists:parts,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0'
        ]);

        $purchase->update([
            'vendor_id' => $request->vendor_id,
            'status' => $request->status,
            'vendor_phone' => $request->vendor_phone,
            'vendor_address' => $request->vendor_address,
        ]);

        $purchase->items()->delete();

        if ($request->has('items')) {
            foreach ($request->items as $item) {
                $purchase->items()->create([
                    'part_id' => $item['part_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }
        }

        return redirect()->route('user.purchases.index')->with('success','Purchase updated');
    }

    public function destroy($id){
        $purchase = Purchase::findOrFail($id);
        if (Auth::user()->role === 'user' && $purchase->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $purchase->delete();
        return redirect()->route('user.purchases.index')->with('success','Deleted');
    }
}

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
        $purchases = \App\Models\Purchase::where('created_by', auth()->id())
            ->latest()
            ->get();

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
    public function show(Purchase $purchase)
    {
        if (Auth::user()->role === 'user' && $purchase->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $purchase->load(['vendor', 'user', 'items.part']);
        $view = Auth::user()->role === 'admin' ? 'admin.purchases.show' : 'user.purchases.show';
        return view($view, compact('purchase'));
    }

    /**
     * Approve a purchase order.
     * Accessible only by Admin.
     */
    public function approve(Request $request, Purchase $purchase)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if ($purchase->status === 'approved') {
            return back()->with('warning', 'Purchase order is already approved.');
        }

        if ($purchase->status === 'rejected') {
            return back()->with('warning', 'Purchase order was previously rejected. Cannot approve.');
        }

        DB::transaction(function () use ($purchase) {
            $purchase->update(['status' => 'approved']);

            foreach ($purchase->items as $item) {
                $part = $item->part;
                $part->increment('stock', $item->quantity);

                PartStock::create([
                    'part_id' => $part->id,
                    'quantity' => $item->quantity,
                    'type' => 'in',
                    'note' => 'Purchase order #' . $purchase->invoice_no . ' approved.',
                    'created_by' => Auth::id(),
                ]);
            }
        });

        return back()->with('success', 'Purchase order approved and stock updated successfully.');
    }

    /**
     * Reject a purchase order.
     * Accessible only by Admin.
     */
    public function reject(Request $request, Purchase $purchase)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if ($purchase->status === 'rejected') {
            return back()->with('warning', 'Purchase order is already rejected.');
        }

        if ($purchase->status === 'approved') {
            return back()->with('warning', 'Approved purchase orders cannot be rejected.');
        }

        $request->validate([
            'rejection_note' => 'required|string|max:255',
        ]);

        $purchase->update([
            'status' => 'rejected',
            'rejection_note' => $request->rejection_note, // Assuming a 'rejection_note' column exists
        ]);

        return back()->with('success', 'Purchase order rejected successfully.');
    }

    // Removing edit, update, destroy as per new flow
    // public function edit(Purchase $purchase) { ... }
    // public function update(Request $request, Purchase $purchase) { ... }
    // public function destroy(Purchase $purchase) { ... }
}

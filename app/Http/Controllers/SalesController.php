<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer; // New
use App\Models\FinishedProduct; // New
use App\Models\SaleItem; // New
use App\Models\PartStock; // For logging stock changes, reusing PartStock for FinishedProduct stock changes
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // New
use Illuminate\Validation\Rule; // New

class SalesController extends Controller
{
    // Assuming a GST rate for calculation
    const GST_RATE = 0.18; // 18% GST

    /**
     * Display a listing of the resource.
     * Accessible by User (own sales) and Admin (all sales)
     */
    public function index(Request $request)
    {
        $query = Sale::with(['customer', 'user', 'items.product']);

        if (Auth::user()->role === 'user') {
            $query->where('created_by', Auth::id());
        }

        $sales = $query->latest()->paginate(10);
        
        $view = Auth::user()->role === 'admin' ? 'admin.sales.index' : 'user.sales.index';
        return view($view, compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     * Accessible only by User.
     */
    public function create()
    {
        if (Auth::user()->role !== 'user') {
            abort(403, 'Unauthorized action.');
        }
        $customers = Customer::all();
        $finishedProducts = FinishedProduct::all();
        return view('user.sales.create', compact('customers', 'finishedProducts'));
    }

    /**
     * Store a newly created resource in storage.
     * Accessible only by User.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'user') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_no' => 'required|string|unique:sales,invoice_no|max:255',
            'items' => 'required|array|min:1',
            'items.*.finished_product_id' => 'required|exists:finished_products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0.01',
        ]);

        DB::transaction(function () use ($request) {
            $totalAmount = 0;
            $gstAmount = 0;

            foreach ($request->items as $itemData) {
                $itemTotal = $itemData['quantity'] * $itemData['price'];
                $totalAmount += $itemTotal;
                $gstAmount += ($itemTotal * self::GST_RATE);

                // Check stock availability *before* creating the sale (for pending status)
                $product = FinishedProduct::find($itemData['finished_product_id']);
                if (!$product || $product->stock < $itemData['quantity']) {
                    // This error is caught during validation, but double-check for race conditions
                    throw new \Exception('Insufficient stock for product ' . $product->name . '.');
                }
            }

            $sale = Sale::create([
                'customer_id' => $request->customer_id,
                'invoice_no' => $request->invoice_no,
                'total_amount' => $totalAmount,
                'gst_amount' => $gstAmount,
                'status' => 'pending',
                'created_by' => Auth::id(),
            ]);

            foreach ($request->items as $itemData) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'finished_product_id' => $itemData['finished_product_id'],
                    'quantity' => $itemData['quantity'],
                    'price' => $itemData['price'],
                ]);
            }
        });

        return redirect()->route('user.sales.index')
            ->with('success', 'Sales order created successfully and pending approval.');
    }

    /**
     * Display the specified resource.
     * Accessible by User (own sale) and Admin (any sale).
     */
    public function show(Sale $sale)
    {
        if (Auth::user()->role === 'user' && $sale->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $sale->load(['customer', 'user', 'items.product']);
        $view = Auth::user()->role === 'admin' ? 'admin.sales.show' : 'user.sales.show';
        return view($view, compact('sale'));
    }

    /**
     * Approve a sales order.
     * Accessible only by Admin.
     */
    public function approve(Request $request, Sale $sale)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if ($sale->status === 'approved') {
            return back()->with('warning', 'Sales order is already approved.');
        }

        if ($sale->status === 'rejected') {
            return back()->with('warning', 'Sales order was previously rejected. Cannot approve.');
        }

        DB::transaction(function () use ($sale) {
            // First, check for stock availability before decrementing
            foreach ($sale->items as $item) {
                $product = $item->product; // This is a FinishedProduct
                if (!$product || $product->stock < $item->quantity) {
                    throw new \Exception('Cannot approve due to insufficient stock for ' . $product->name . '. Available: ' . $product->stock . ', Required: ' . $item->quantity . '.');
                }
            }
            
            $sale->update(['status' => 'approved']);

            // Decrease finished product stock and log
            foreach ($sale->items as $item) {
                $product = $item->product;
                $product->decrement('stock', $item->quantity);

                // Log stock movement (reusing PartStock for simplicity for FinishedProduct as well)
                // This might need a separate FinishedProductStock table/model in a more complex system
                PartStock::create([
                    'part_id' => $product->id, // Assuming FinishedProduct IDs can be mapped to PartStock for logging, or a generic 'product_id'
                    'quantity' => $item->quantity,
                    'type' => 'out',
                    'note' => 'Sales order #' . $sale->invoice_no . ' approved. (Finished Product)',
                    'created_by' => Auth::id(),
                ]);
            }
        });

        return back()->with('success', 'Sales order approved and stock updated successfully.');
    }

    /**
     * Reject a sales order.
     * Accessible only by Admin.
     */
    public function reject(Request $request, Sale $sale)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if ($sale->status === 'rejected') {
            return back()->with('warning', 'Sales order is already rejected.');
        }

        if ($sale->status === 'approved') {
            return back()->with('warning', 'Approved sales orders cannot be rejected.');
        }

        $request->validate([
            'rejection_note' => 'required|string|max:255',
        ]);

        $sale->update([
            'status' => 'rejected',
            'rejection_note' => $request->rejection_note, // Assuming a 'rejection_note' column exists
        ]);

        return back()->with('success', 'Sales order rejected successfully.');
    }

    // Removing edit, update, destroy as per new flow
    // public function edit(Sale $sale) { ... }
    // public function update(Request $request, Sale $sale) { ... }
    // public function destroy(Sale $sale) { ... }
}

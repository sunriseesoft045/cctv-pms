<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Sale;
use App\Models\Purchase; // New
use App\Models\Vendor; // New
use App\Models\Customer; // New
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     * Accessible by User (own payments) and Admin (all payments)
     */
    public function index(Request $request)
    {
        $query = Payment::with(['user', 'sale', 'purchase']);

        if (Auth::user()->role === 'user') {
            $query->where('created_by', Auth::id());
        }

        $payments = $query->latest()->paginate(10);
        
        $view = Auth::user()->role === 'admin' ? 'admin.payments.index' : 'user.payments.index';
        return view($view, compact('payments'));
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
        $sales = Sale::where('status', 'approved')->get();
        $purchases = Purchase::where('status', 'approved')->get();
        return view('user.payments.create', compact('sales', 'purchases'));
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
            'type' => ['required', Rule::in(['customer', 'vendor'])],
            'ref_id' => 'required|integer', // This will be sale_id or purchase_id
            'amount' => 'required|numeric|min:0.01',
            'method' => ['required', Rule::in(['cash', 'upi', 'bank'])],
        ]);

        $dueAmount = 0;
        if ($request->type === 'customer') {
            $sale = Sale::find($request->ref_id);
            if (!$sale || $sale->status !== 'approved') {
                return back()->withErrors(['ref_id' => 'Selected Sale is not approved or does not exist.']);
            }
            $dueAmount = $sale->total_amount - $sale->payments()->sum('amount');
        } elseif ($request->type === 'vendor') {
            $purchase = Purchase::find($request->ref_id);
            if (!$purchase || $purchase->status !== 'approved') {
                return back()->withErrors(['ref_id' => 'Selected Purchase is not approved or does not exist.']);
            }
            $dueAmount = $purchase->total_amount - $purchase->payments()->sum('amount');
        }

        if ($request->amount > $dueAmount) {
            return back()->withErrors(['amount' => 'Payment amount cannot exceed the due amount (' . $dueAmount . ').']);
        }

        DB::transaction(function () use ($request) {
            $paymentData = [
                'type' => $request->type,
                'amount' => $request->amount,
                'method' => $request->method,
                'created_by' => Auth::id(),
            ];

            if ($request->type === 'customer') {
                $paymentData['sale_id'] = $request->ref_id;
            } elseif ($request->type === 'vendor') {
                $paymentData['purchase_id'] = $request->ref_id;
            }

            Payment::create($paymentData);
        });

        return redirect()->route('user.payments.index')
            ->with('success', 'Payment recorded successfully.');
    }

    /**
     * Display the specified resource.
     * Accessible by User (own payment) and Admin (any payment).
     */
    public function show(Payment $payment)
    {
        if (Auth::user()->role === 'user' && $payment->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $payment->load(['user', 'sale', 'purchase']);
        $view = Auth::user()->role === 'admin' ? 'admin.payments.show' : 'user.payments.show';
        return view($view, compact('payment'));
    }

    // Removing edit, update, destroy as per new flow
    // public function edit(Payment $payment) { ... }
    // public function update(Request $request, Payment $payment) { ... }
    // public function destroy(Payment $payment) { ... }
}

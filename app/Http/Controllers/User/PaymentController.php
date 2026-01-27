<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Sale;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::where('user_id', Auth::id())->latest()->paginate(10);
        return view('user.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $invoice = null;
        if ($request->has('invoice_id')) {
            $invoice = \App\Models\Invoice::where('id', $request->invoice_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
        }
        return view('user.payments.create', compact('invoice'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:purchase,sale',
            'purchase_id' => 'nullable|exists:purchases,id',
            'sale_id' => 'nullable|exists:sales,id',
            'total_amount' => 'required|numeric',
            'paid_amount' => 'required|numeric|min:0',
            'payment_mode' => 'required|string|in:Cash,UPI,Bank,Cheque',
            'payment_date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $total = (float)$data['total_amount'];
        $paid = (float)$data['paid_amount'];

        if ($paid > $total) {
            $advance = $paid - $total;
            $due = 0;
        } else {
            $due = $total - $paid;
            $advance = 0;
        }
        
        $payment = new Payment($data);
        $payment->user_id = Auth::id();
        $payment->type = $data['type']; // Assign the type
        $payment->due_amount = $due;
        $payment->advance_amount = $advance;
        // The 'amount' column from the old schema is now 'paid_amount'
        $payment->amount = $paid; 

        if ($data['type'] === 'purchase' && $data['purchase_id']) {
            $purchase = \App\Models\Purchase::findOrFail($data['purchase_id']);
            if($purchase->created_by !== Auth::id()) abort(403);
            $payment->vendor_name = $purchase->vendor->name;
        } elseif ($data['type'] === 'sale' && $data['sale_id']) {
            $sale = \App\Models\Sale::findOrFail($data['sale_id']);
            if($sale->created_by !== Auth::id()) abort(403);
            // Assuming customer name is needed, though vendor_name is the column
            $payment->vendor_name = $sale->customer->name;
        }
        
        $payment->save();

        return redirect()->route('user.payments.index')->with('success', 'Payment recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }
        return view('user.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }
        // Since we are not editing the amounts, we just pass the payment
        return view('user.payments.edit', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'payment_mode' => 'required|string|in:Cash,UPI,Bank,Cheque',
            'payment_date' => 'required|date',
            'note' => 'nullable|string',
            // Other fields are not editable as per the new design
        ]);

        $payment->update($data);

        return redirect()->route('user.payments.index')->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        $payment->delete();

        return redirect()->route('user.payments.index')->with('success', 'Payment deleted successfully.');
    }

    public function fetchUserPurchases()
    {
        $purchases = \App\Models\Purchase::where('created_by', auth()->id())
            ->with('vendor:id,name')
            ->latest()
            ->get(['id', 'invoice_no as invoice_number', 'total_amount', 'vendor_id']);

        // We need to manually add the vendor_name to the top level of the object for the JS to work
        $purchases->each(function ($purchase) {
            $purchase->vendor_name = $purchase->vendor->name;
        });

        return response()->json($purchases);
    }

    public function getUnpaidSales()
    {
        // Fetch sales created by the authenticated user that are not fully paid
        $sales = Sale::where('created_by', Auth::id())
            ->with('customer:id,name')
            ->get();

        $sales->each(function ($sale) {
            // Calculate total paid amount for this sale
            $paidAmount = Payment::where('sale_id', $sale->id)
                                ->where('user_id', Auth::id())
                                ->sum('amount'); // Assuming 'amount' column in payments stores the paid amount

            $sale->paid_amount = $paidAmount;
            $sale->due_amount = $sale->total_amount - $paidAmount;
            $sale->customer_name = $sale->customer->name;
        });

        // Filter out fully paid sales
        $unpaidSales = $sales->filter(function ($sale) {
            return $sale->due_amount > 0;
        });

        return response()->json($unpaidSales->values());
    }
}
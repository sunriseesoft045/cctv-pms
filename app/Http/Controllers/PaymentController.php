<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('sale', 'user')
            ->where('created_by', Auth::id())
            ->latest()
            ->paginate(10);
        
        return view('user.payments.index', compact('payments'));
    }

    public function create()
    {
        $sales = Sale::with('product')
            ->where('created_by', Auth::id())
            ->where('status', 'approved')
            ->get();
        
        return view('user.payments.create', compact('sales'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|in:cash,upi,bank',
        ]);

        $validated['created_by'] = Auth::id();

        Payment::create($validated);

        return redirect()->route('user.payments.index')
            ->with('success', 'Payment recorded successfully.');
    }

    public function show(Payment $payment)
    {
        $this->authorize('view', $payment);
        return view('user.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $this->authorize('update', $payment);
        $sales = Sale::with('product')
            ->where('created_by', Auth::id())
            ->where('status', 'approved')
            ->get();
        
        return view('user.payments.edit', compact('payment', 'sales'));
    }

    public function update(Request $request, Payment $payment)
    {
        $this->authorize('update', $payment);

        $validated = $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|in:cash,upi,bank',
        ]);

        $payment->update($validated);

        return redirect()->route('user.payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $this->authorize('delete', $payment);
        
        $payment->delete();

        return redirect()->route('user.payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
}
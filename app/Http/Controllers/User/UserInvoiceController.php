<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class UserInvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::where('user_id', Auth::id())->latest()->paginate(10);
        return view('user.invoices.index', compact('invoices'));
    }

    public function create()
    {
        return view('user.invoices.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'bill_to' => 'required|string|max:255',
            'ship_to' => 'nullable|string|max:255',
            'date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:date',
            'payment_terms' => 'nullable|string|max:255',
            'po_number' => 'nullable|string|max:255',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'shipping' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'paid' => 'required|numeric|min:0',
            'balance' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'terms' => 'nullable|string',
            'items' => 'required|array',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.rate' => 'required|numeric|min:0',
            'items.*.amount' => 'required|numeric|min:0',
        ]);

        $invoice = Invoice::create([
            'user_id' => Auth::id(),
            'bill_to' => $data['bill_to'],
            'ship_to' => $data['ship_to'],
            'date' => $data['date'],
            'due_date' => $data['due_date'],
            'payment_terms' => $data['payment_terms'],
            'po_number' => $data['po_number'],
            'subtotal' => $data['subtotal'],
            'tax' => $data['tax'],
            'discount' => $data['discount'],
            'shipping' => $data['shipping'],
            'total' => $data['total'],
            'paid' => $data['paid'],
            'balance' => $data['balance'],
            'notes' => $data['notes'],
            'terms' => $data['terms'],
            'invoice_number' => 'INV-' . time(), // Generate a unique invoice number
        ]);

        foreach ($data['items'] as $item) {
            $invoice->items()->create([
                'item_name' => $item['item_name'],
                'quantity' => $item['quantity'],
                'rate' => $item['rate'],
                'amount' => $item['amount'],
            ]);
        }

        return redirect()->route('user.invoices.show', $invoice->id)->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        if ($invoice->user_id !== Auth::id()) {
            abort(403);
        }
        return view('user.invoices.show', compact('invoice'));
    }

    public function generatePdf(Invoice $invoice)
    {
        if ($invoice->user_id !== Auth::id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('user.invoices.pdf', compact('invoice'));
        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }
}

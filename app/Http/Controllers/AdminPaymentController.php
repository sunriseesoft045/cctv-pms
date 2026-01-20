<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['sale.product', 'user'])->latest()->get();
        return view('admin.payments.index', compact('payments'));
    }
}
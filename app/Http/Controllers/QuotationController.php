<?php

namespace App\Http\Controllers;

use App\Models\Sale; // Corrected
use App\Models\Customer; // Corrected
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class QuotationController extends Controller
{
    /**
     * Generate a customer quotation as PDF.
     * Accessible by User (own quotation) and Admin (any quotation).
     *
     * @param  int  $id The ID of the Sale (or a future Quotation model).
     * @return \Illuminate\Http\Response
     */
    public function customerQuotation($id)
    {
        // For now, we'll base the quotation on a Sale.
        // In a real system, you might have a dedicated Quotation model.
        $sale = Sale::with(['items.product', 'customer', 'user'])
                    ->findOrFail($id);

        // Security check: User can only view their own quotations. Admin can view all.
        // For simplicity, using 'created_by' from Sale.
        if (Auth::user()->role === 'user' && $sale->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $companyProfile = CompanyProfile::first(); // Assuming one company profile for the system

        $data = [
            'title' => 'Quotation',
            'sale' => $sale, // Using sale data for quotation
            'companyProfile' => $companyProfile,
            'customer' => $sale->customer,
            'preparer' => $sale->user, // The user who created the sale
        ];

        $pdf = Pdf::loadView('pdf.quotation', $data);

        return $pdf->download('quotation-' . $sale->invoice_no . '.pdf');
    }
}

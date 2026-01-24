<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Purchase; // Corrected
use App\Models\CompanyProfile;
use App\Models\Customer; // Corrected
use App\Models\Vendor; // Corrected
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Generate a sales invoice as PDF.
     * Accessible by User (own sale) and Admin (any sale).
     *
     * @param  int  $id The ID of the Sale.
     * @return \Illuminate\Http\Response
     */
    public function saleInvoice($id)
    {
        $sale = Sale::with(['items.product', 'customer', 'user', 'payments'])
                    ->findOrFail($id);

        // Security check: User can only view their own sale invoices. Admin can view all.
        if (Auth::user()->role === 'user' && $sale->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $companyProfile = CompanyProfile::first(); // Assuming one company profile for the system

        $data = [
            'title' => 'Sales Invoice',
            'sale' => $sale,
            'companyProfile' => $companyProfile,
            'customer' => $sale->customer,
            'seller' => $sale->user,
        ];

        $pdf = Pdf::loadView('pdf.sale-invoice', $data);

        return $pdf->download('sales-invoice-' . $sale->invoice_no . '.pdf');
    }

    /**
     * Generate a purchase invoice as PDF.
     * Accessible only by Admin.
     *
     * @param  int  $id The ID of the Purchase.
     * @return \Illuminate\Http\Response
     */
    public function purchaseInvoice($id)
    {
        // Security check: Only admin can view purchase invoices.
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'master_admin') {
            abort(403, 'Unauthorized action.');
        }

        $purchase = Purchase::with(['items.part', 'vendor', 'user', 'payments'])
                            ->findOrFail($id);

        $companyProfile = CompanyProfile::first(); // Assuming one company profile for the system

        $data = [
            'title' => 'Purchase Invoice',
            'purchase' => $purchase,
            'companyProfile' => $companyProfile,
            'vendor' => $purchase->vendor,
            'buyer' => $purchase->user,
        ];

        $pdf = Pdf::loadView('pdf.purchase-invoice', $data);

        return $pdf->download('purchase-invoice-' . $purchase->invoice_no . '.pdf');
    }
}

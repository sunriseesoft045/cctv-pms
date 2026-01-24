<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Purchase;
use App\Models\Sale; // Corrected
use App\Models\User; // Corrected
use App\Models\Part;
use App\Models\FinishedProduct;
use Illuminate\Http\Request; // Corrected
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsController extends Controller
{
    /**
     * Display the default reports view (redirect to inventory report).
     */
    public function index()
    {
        return redirect()->route('admin.reports.inventory');
    }

    /**
     * Generate inventory report (Parts + Finished Products).
     */
    public function inventoryReport()
    {
        $parts = \App\Models\Part::orderBy('name')->get();
        $finished = \App\Models\FinishedProduct::orderBy('name')->get();

        return view('admin.reports.inventory', compact('parts','finished'));
    }

    /**
     * Generate monthly sales report.
     */
    public function monthlySales(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);
        $monthlySales = Sale::select(
                DB::raw('strftime("%Y-%m", created_at) as month'),
                DB::raw('SUM(total_amount) as total_sales')
            )
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.reports.monthly-sales', compact('monthlySales', 'year'));
    }

    /**
     * Generate low stock report for parts.
     */
    public function lowStock()
    {
        $lowStockParts = Part::whereColumn('stock', '<=', 'min_stock')->get();
        return view('admin.reports.low-stock', compact('lowStockParts'));
    }

    /**
     * Generate profit/loss report.
     */
    public function profitLoss()
    {
        $totalSales = Sale::where('status', 'approved')->sum('total_amount');
        $totalPurchases = Purchase::where('status', 'approved')->sum('total_amount');
        $profit = $totalSales - $totalPurchases;

        return view('admin.reports.profit-loss', compact('totalSales', 'totalPurchases', 'profit'));
    }

    /**
     * Generate customer and vendor dues report.
     */
    public function dues()
    {
        // Get all approved sales
        $sales = Sale::where('status', 'approved')->get();
        $customerDues = [];
        foreach ($sales as $sale) {
            $amountDue = $sale->total_amount - $sale->payments()->sum('amount');
            if ($amountDue > 0) {
                $customerDues[] = [
                    'customer' => $sale->customer->name,
                    'invoice_no' => $sale->invoice_no,
                    'total_amount' => $sale->total_amount,
                    'amount_paid' => $sale->payments()->sum('amount'),
                    'amount_due' => $amountDue,
                ];
            }
        }

        // Get all approved purchases
        $purchases = Purchase::where('status', 'approved')->get();
        $vendorDues = [];
        foreach ($purchases as $purchase) {
            $amountDue = $purchase->total_amount - $purchase->payments()->sum('amount');
            if ($amountDue > 0) {
                $vendorDues[] = [
                    'vendor' => $purchase->vendor->name,
                    'invoice_no' => $purchase->invoice_no,
                    'total_amount' => $purchase->total_amount,
                    'amount_paid' => $purchase->payments()->sum('amount'),
                    'amount_due' => $amountDue,
                ];
            }
        }

        return view('admin.reports.dues', compact('customerDues', 'vendorDues'));
    }
}

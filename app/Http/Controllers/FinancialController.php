<?php

namespace App\Http\Controllers;

use App\Models\FinancialReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialController extends Controller
{
    /**
     * Display financial overview dashboard
     */
    public function index()
    {
        $totalCredit = FinancialReport::where('type', 'credit')->sum('amount');
        $totalDebit = FinancialReport::where('type', 'debit')->sum('amount');
        $balance = $totalCredit - $totalDebit;
        $totalTransactions = FinancialReport::count();

        $recentTransactions = FinancialReport::with('createdBy')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Use driver-aware date formatting: MySQL uses DATE_FORMAT, SQLite uses strftime
        $driver = DB::getDriverName();
        if ($driver === 'sqlite') {
            $dateExpr = "strftime('%Y-%m', created_at)";
        } else {
            $dateExpr = "DATE_FORMAT(created_at, '%Y-%m')";
        }

        $monthlyData = FinancialReport::selectRaw($dateExpr . ' as month, type, SUM(amount) as total')
            ->groupBy('month', 'type')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get();

        return view('admin.financial.index', compact('totalCredit', 'totalDebit', 'balance', 'totalTransactions', 'recentTransactions', 'monthlyData'));
    }

    /**
     * Show create financial report form
     */
    public function create()
    {
        return view('admin.financial.create');
    }

    /**
     * Store new financial report
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:credit,debit',
            'description' => 'nullable|string|max:1000',
        ]);

        FinancialReport::create([
            'title' => $request->title,
            'amount' => $request->amount,
            'type' => $request->type,
            'description' => $request->description,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.financial.index')->with('success', 'Financial report created successfully');
    }

    /**
     * Display specific financial report
     */
    public function show($id)
    {
        $report = FinancialReport::with('createdBy')->findOrFail($id);
        return view('admin.financial.show', compact('report'));
    }

    /**
     * Show edit form for financial report
     */
    public function edit($id)
    {
        $report = FinancialReport::findOrFail($id);
        $this->authorize('update', $report);
        return view('admin.financial.edit', compact('report'));
    }

    /**
     * Update financial report
     */
    public function update(Request $request, $id)
    {
        $report = FinancialReport::findOrFail($id);
        $this->authorize('update', $report);

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:credit,debit',
            'description' => 'nullable|string|max:1000',
        ]);

        $report->update([
            'title' => $request->title,
            'amount' => $request->amount,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.financial.index')->with('success', 'Financial report updated successfully');
    }

    /**
     * Delete financial report
     */
    public function destroy($id)
    {
        $report = FinancialReport::findOrFail($id);
        $this->authorize('delete', $report);
        $report->delete();

        return redirect()->route('admin.financial.index')->with('success', 'Financial report deleted successfully');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\FinancialReport;
use App\Models\User;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    /**
     * Display all reports with pagination
     */
    public function index()
    {
        $reports = FinancialReport::with('createdBy')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalReports = FinancialReport::count();
        $creditTotal = FinancialReport::where('type', 'credit')->sum('amount');
        $debitTotal = FinancialReport::where('type', 'debit')->sum('amount');

        return view('admin.reports.index', compact('reports', 'totalReports', 'creditTotal', 'debitTotal'));
    }

    /**
     * Display single report details
     */
    public function show($id)
    {
        $report = FinancialReport::with('createdBy')->findOrFail($id);
        return view('admin.reports.show', compact('report'));
    }

    /**
     * Export reports as CSV
     */
    public function export()
    {
        $reports = FinancialReport::with('createdBy')
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'reports_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($reports) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Title', 'Amount', 'Type', 'Description', 'Created By', 'Created At']);

            foreach ($reports as $report) {
                fputcsv($file, [
                    $report->title,
                    $report->amount,
                    $report->type,
                    $report->description,
                    $report->createdBy->name,
                    $report->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

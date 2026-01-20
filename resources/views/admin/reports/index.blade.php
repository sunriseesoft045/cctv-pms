@extends('admin.layouts.app')

@section('title', 'Reports')
@section('page-title', 'Reports')

@section('content')
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1><i class="fas fa-chart-bar"></i> Reports</h1>
            <p>View and manage all system reports</p>
        </div>
        <a href="/admin/reports/export/csv" class="btn btn-primary">
            <i class="fas fa-download"></i> Export to CSV
        </a>
    </div>

    <!-- Statistics Row -->
    <div class="row" style="margin-bottom: 30px;">
        <!-- Total Reports Card -->
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-card-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-card-title">Total Reports</div>
                <div class="stat-card-value">{{ $totalReports }}</div>
            </div>
        </div>

        <!-- Total Credit Card -->
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-card-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                    <i class="fas fa-arrow-up"></i>
                </div>
                <div class="stat-card-title">Total Credit</div>
                <div class="stat-card-value">₨ {{ number_format($creditTotal, 2) }}</div>
            </div>
        </div>

        <!-- Total Debit Card -->
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-card-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                    <i class="fas fa-arrow-down"></i>
                </div>
                <div class="stat-card-title">Total Debit</div>
                <div class="stat-card-value">₨ {{ number_format($debitTotal, 2) }}</div>
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-list"></i> All Reports
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Created By</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td>
                                <strong>{{ $report->title }}</strong>
                            </td>
                            <td>
                                <span style="font-weight: 600; font-size: 16px;">
                                    ₨ {{ number_format($report->amount, 2) }}
                                </span>
                            </td>
                            <td>
                                @if($report->type === 'credit')
                                    <span class="badge" style="background: #d4edda; color: #155724;">
                                        <i class="fas fa-arrow-up"></i> Credit
                                    </span>
                                @else
                                    <span class="badge" style="background: #f8d7da; color: #721c24;">
                                        <i class="fas fa-arrow-down"></i> Debit
                                    </span>
                                @endif
                            </td>
                            <td>
                                {{ Str::limit($report->description, 50) }}
                            </td>
                            <td>
                                {{ $report->createdBy->name ?? 'N/A' }}
                            </td>
                            <td>
                                {{ $report->created_at->format('M d, Y H:i') }}
                            </td>
                            <td>
                                <a 
                                    href="/admin/reports/{{ $report->id }}" 
                                    class="btn btn-sm" 
                                    style="background: #3498db; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; transition: all 0.3s ease;"
                                    onmouseover="this.style.background='#2980b9'"
                                    onmouseout="this.style.background='#3498db'"
                                >
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px 20px;">
                                <i class="fas fa-inbox" style="font-size: 32px; color: #bdc3c7; margin-bottom: 10px; display: block;"></i>
                                <strong>No reports found</strong>
                                <p style="color: #7f8c8d; margin-top: 5px;">Start by creating a new report</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($reports->hasPages())
            <div style="padding: 20px;">
                {{ $reports->links() }}
            </div>
        @endif
    </div>
@endsection

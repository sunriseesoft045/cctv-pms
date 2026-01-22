@extends('admin.layouts.app')

@section('title', 'Financial Management')
@section('page-title', 'Financial Management')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1><i class="fas fa-coins"></i> Financial Management</h1>
        <p>Live overview of financial activities</p>
    </div>
</div>

<!-- Statistics Row -->
<div class="row" style="margin-bottom: 30px;">
    <!-- Total Credit Card -->
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div class="stat-card-title">Total Credit (Payments)</div>
            <div class="stat-card-value" style="color: #27ae60;">
                Rs {{ number_format($totalCredit, 2) }}
            </div>
        </div>
    </div>

    <!-- Total Debit Card -->
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div class="stat-card-title">Total Debit (Purchases)</div>
            <div class="stat-card-value" style="color: #e74c3c;">
                Rs {{ number_format($totalDebit, 2) }}
            </div>
        </div>
    </div>

    <!-- Balance Card -->
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="stat-card-title">Net Balance</div>
            <div class="stat-card-value" style="color: {{ ($totalCredit - $totalDebit) >= 0 ? '#27ae60' : '#e74c3c' }};">
                Rs {{ number_format($totalCredit - $totalDebit, 2) }}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Latest Payments Table -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-hand-holding-usd"></i> Latest Payments
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestPayments as $payment)
                            <tr>
                                <td>{{ $payment->user->name ?? 'N/A' }}</td>
                                <td>Rs {{ number_format($payment->amount, 2) }}</td>
                                <td><span class="badge badge-secondary">{{ ucfirst($payment->method) }}</span></td>
                                <td>{{ $payment->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No payment data available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Latest Purchases Table -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-shopping-cart"></i> Latest Purchases
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestPurchases as $purchase)
                            <tr>
                                <td>{{ $purchase->user->name ?? 'N/A' }}</td>
                                <td>Rs {{ number_format($purchase->cost, 2) }}</td>
                                <td><span class="badge badge-info">{{ ucfirst($purchase->status) }}</span></td>
                                <td>{{ $purchase->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No purchase data available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
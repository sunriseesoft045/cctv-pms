@extends('admin.layouts.app')

@section('title', 'Financial Management')
@section('page-title', 'Financial Management')

@section('content')
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1><i class="fas fa-coins"></i> Financial Management</h1>
            <p>Manage financial records and transactions</p>
        </div>
        <a href="/admin/financial/create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Transaction
        </a>
    </div>

    <!-- Statistics Row -->
    <div class="row" style="margin-bottom: 30px;">
        <!-- Total Credit Card -->
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-card-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                    <i class="fas fa-arrow-up"></i>
                </div>
                <div class="stat-card-title">Total Credit</div>
                <div class="stat-card-value" style="color: #27ae60;">
                    ₨ {{ number_format($totalCredit, 2) }}
                </div>
            </div>
        </div>

        <!-- Total Debit Card -->
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-card-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                    <i class="fas fa-arrow-down"></i>
                </div>
                <div class="stat-card-title">Total Debit</div>
                <div class="stat-card-value" style="color: #e74c3c;">
                    ₨ {{ number_format($totalDebit, 2) }}
                </div>
            </div>
        </div>

        <!-- Balance Card -->
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-card-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="stat-card-title">Balance</div>
                <div class="stat-card-value" style="color: {{ $balance >= 0 ? '#27ae60' : '#e74c3c' }};">
                    ₨ {{ number_format($balance, 2) }}
                </div>
            </div>
        </div>

        <!-- Total Transactions Card -->
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-card-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                    <i class="fas fa-list"></i>
                </div>
                <div class="stat-card-title">Transactions</div>
                <div class="stat-card-value">{{ $totalTransactions }}</div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="card" style="margin-bottom: 30px;">
        <div class="card-header">
            <i class="fas fa-history"></i> Recent Transactions
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
                    @forelse($recentTransactions as $transaction)
                        <tr>
                            <td><strong>{{ $transaction->title }}</strong></td>
                            <td style="font-weight: 600; font-size: 16px;">
                                ₨ {{ number_format($transaction->amount, 2) }}
                            </td>
                            <td>
                                @if($transaction->type === 'credit')
                                    <span class="badge" style="background: #d4edda; color: #155724;">
                                        <i class="fas fa-arrow-up"></i> Credit
                                    </span>
                                @else
                                    <span class="badge" style="background: #f8d7da; color: #721c24;">
                                        <i class="fas fa-arrow-down"></i> Debit
                                    </span>
                                @endif
                            </td>
                            <td>{{ Str::limit($transaction->description, 40) }}</td>
                            <td>{{ $transaction->createdBy->name ?? 'N/A' }}</td>
                            <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                            <td>
                                <div style="display: flex; gap: 5px;">
                                    <a 
                                        href="/admin/financial/{{ $transaction->id }}" 
                                        class="btn btn-sm" 
                                        style="background: #3498db; color: white; padding: 4px 8px; border-radius: 4px; text-decoration: none; font-size: 11px; transition: all 0.3s ease;"
                                        onmouseover="this.style.background='#2980b9'"
                                        onmouseout="this.style.background='#3498db'"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a 
                                        href="{{ route('admin.financial.edit', $transaction->id) }}" 
                                        class="btn btn-sm" 
                                        style="background: #27ae60; color: white; padding: 4px 8px; border-radius: 4px; text-decoration: none; font-size: 11px; transition: all 0.3s ease;"
                                        onmouseover="this.style.background='#229954'"
                                        onmouseout="this.style.background='#27ae60'"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.financial.destroy', $transaction->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this transaction?');">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="btn btn-sm" 
                                            style="background: #e74c3c; color: white; padding: 4px 8px; border-radius: 4px; border: none; cursor: pointer; font-size: 11px; transition: all 0.3s ease;"
                                            onmouseover="this.style.background='#c0392b'"
                                            onmouseout="this.style.background='#e74c3c'"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px 20px;">
                                <i class="fas fa-inbox" style="font-size: 32px; color: #bdc3c7; margin-bottom: 10px; display: block;"></i>
                                <strong>No transactions found</strong>
                                <p style="color: #7f8c8d; margin-top: 5px;">Start by creating a new financial record</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Summary Card -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-chart-pie"></i> Financial Summary
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-4">
                    <div style="padding: 20px;">
                        <div style="font-size: 12px; color: #7f8c8d; text-transform: uppercase; margin-bottom: 10px;">Credit Percentage</div>
                        <div style="font-size: 28px; font-weight: 600; color: #27ae60;">
                            {{ $totalCredit > 0 && $totalCredit + $totalDebit > 0 ? round(($totalCredit / ($totalCredit + $totalDebit)) * 100, 2) : 0 }}%
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div style="padding: 20px; border-left: 1px solid #eee; border-right: 1px solid #eee;">
                        <div style="font-size: 12px; color: #7f8c8d; text-transform: uppercase; margin-bottom: 10px;">Debit Percentage</div>
                        <div style="font-size: 28px; font-weight: 600; color: #e74c3c;">
                            {{ $totalDebit > 0 && $totalCredit + $totalDebit > 0 ? round(($totalDebit / ($totalCredit + $totalDebit)) * 100, 2) : 0 }}%
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div style="padding: 20px;">
                        <div style="font-size: 12px; color: #7f8c8d; text-transform: uppercase; margin-bottom: 10px;">Net Balance</div>
                        <div style="font-size: 28px; font-weight: 600; color: {{ $balance >= 0 ? '#27ae60' : '#e74c3c' }};">
                            ₨ {{ number_format($balance, 2) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

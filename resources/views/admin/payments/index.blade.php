@extends('admin.layouts.app')

@section('title', 'Payments')
@section('page-title', 'Payments')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-coins"></i> Payments</h1>
    <p>View all payments recorded in the system.</p>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-list"></i> All Payments
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Sale ID</th>
                    <th>Product Name</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>User</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td>#{{ $payment->id }}</td>
                        <td>#{{ $payment->sale_id }}</td>
                        <td>{{ $payment->sale->product->name ?? 'N/A' }}</td>
                        <td>₹{{ number_format($payment->amount, 2) }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($payment->method) }}</span></td>
                        <td>{{ $payment->user->name ?? 'N/A' }}</td>
                        <td>{{ $payment->created_at->format('M d, Y h:i A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No payments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

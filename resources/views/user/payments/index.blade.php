@extends('user.layouts.app')
@section('page-title', 'Payments')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-credit-card"></i> Payments</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('user.payments.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Payment
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">All Payments</h5>
        </div>
        <div class="card-body">
            @if($payments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Sale ID</th>
                                <th>Product</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>#{{ $payment->id }}</td>
                                    <td>#{{ $payment->sale_id }}</td>
                                    <td>
                                        <strong>{{ $payment->sale->product->name }}</strong><br>
                                        <small class="text-muted">Qty: {{ $payment->sale->quantity }}</small>
                                    </td>
                                    <td><strong>₹{{ number_format($payment->amount, 2) }}</strong></td>
                                    <td>
                                        @php
                                            $methods = [
                                                'cash' => ['text' => 'Cash', 'color' => 'success'],
                                                'upi' => ['text' => 'UPI', 'color' => 'info'],
                                                'bank' => ['text' => 'Bank', 'color' => 'primary'],
                                            ];
                                            $method = $methods[$payment->method] ?? $methods['cash'];
                                        @endphp
                                        <span class="badge bg-{{ $method['color'] }}">{{ $method['text'] }}</span>
                                    </td>
                                    <td>{{ $payment->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('user.payments.edit', $payment->id) }}" 
                                               class="btn btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('user.payments.destroy', $payment->id) }}" 
                                                  method="POST" style="display:inline;" 
                                                  onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav aria-label="Page navigation">
                    {{ $payments->links() }}
                </nav>
            @else
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle"></i> No payments found. 
                    <a href="{{ route('user.payments.create') }}">Create your first payment</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
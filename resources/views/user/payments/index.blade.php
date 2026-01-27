@extends('user.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Accounts</h2>
        <a href="{{ route('user.payments.create') }}" class="btn btn-primary">Add New Entry</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Party</th>
                        <th>Invoice</th>
                        <th>Total</th>
                        <th>Paid</th>
                        <th>Due</th>
                        <th>Advance</th>
                        <th>Mode</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payments as $payment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if ($payment->type == 'purchase')
                                    <span class="badge bg-danger">Purchase</span>
                                @else
                                    <span class="badge bg-success">Sale</span>
                                @endif
                            </td>
                            <td>{{ $payment->vendor_name }}</td>
                            <td>
                                @if ($payment->type == 'purchase')
                                    <a href="{{ route('user.purchases.show', $payment->purchase_id) }}">#{{ $payment->purchase_id }}</a>
                                @else
                                    <a href="{{ route('user.sales.show', $payment->sale_id) }}">#{{ $payment->sale_id }}</a>
                                @endif
                            </td>
                            <td>{{ number_format($payment->total_amount, 2) }}</td>
                            <td>{{ number_format($payment->paid_amount, 2) }}</td>
                            <td>
                                @if ($payment->due_amount > 0)
                                    <span class="badge bg-danger">{{ number_format($payment->due_amount, 2) }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($payment->advance_amount > 0)
                                    <span class="badge bg-primary">{{ number_format($payment->advance_amount, 2) }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $payment->payment_mode }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M, Y') }}</td>
                            <td>
                                <a href="{{ route('user.payments.show', $payment->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('user.payments.edit', $payment->id) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                <form action="{{ route('user.payments.destroy', $payment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this entry?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">No payment entries found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

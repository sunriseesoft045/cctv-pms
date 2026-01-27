@extends('user.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Invoices</h2>
        <a href="{{ route('user.invoices.create') }}" class="btn btn-primary">Create New Invoice</a>
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
                        <th>Invoice No</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($invoices as $invoice)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $invoice->invoice_number }}</td>
                            <td>{{ $invoice->bill_to }}</td>
                            <td>{{ number_format($invoice->total, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'partial' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </td>
                            <td>{{ $invoice->date->format('d M, Y') }}</td>
                            <td>
                                <a href="{{ route('user.invoices.show', $invoice->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('user.invoices.pdf', $invoice->id) }}" class="btn btn-sm btn-secondary">Download PDF</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No invoices found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

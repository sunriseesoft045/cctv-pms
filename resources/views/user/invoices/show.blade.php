@extends('user.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Invoice #{{ $invoice->invoice_number }}</h2>
        <div>
            <a href="{{ route('user.invoices.pdf', $invoice->id) }}" class="btn btn-primary">Download PDF</a>
            <a href="{{ route('user.invoices.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h4>Customer Details</h4>
                    <p><strong>Name:</strong> {{ $invoice->customer_name }}</p>
                    @if($invoice->quotation)
                    <p><strong>Phone:</strong> {{ $invoice->quotation->customer_phone }}</p>
                    <p><strong>Address:</strong> {{ $invoice->quotation->customer_address }}</p>
                    @endif
                </div>
                <div class="col-md-6 text-end">
                    <p><strong>Date:</strong> {{ $invoice->created_at->format('d M, Y') }}</p>
                    <p><strong>Status:</strong> <span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'partial' ? 'warning' : 'danger') }}">{{ ucfirst($invoice->status) }}</span></p>
                </div>
            </div>

            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ number_format($item->price, 2) }}</td>
                            <td>{{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="row justify-content-end mt-4">
                <div class="col-md-4">
                    <table class="table table-sm">
                        <tr>
                            <th>Subtotal</th>
                            <td class="text-end">{{ number_format($invoice->subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <th>GST (18%)</th>
                            <td class="text-end">{{ number_format($invoice->tax, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Grand Total</th>
                            <td class="text-end"><strong>{{ number_format($invoice->total, 2) }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

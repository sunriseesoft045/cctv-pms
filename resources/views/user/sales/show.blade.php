@extends('user.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3>Sale Details</h3>
            <a href="{{ route('user.sales.index') }}" class="btn btn-secondary">Back</a>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Customer Details:</h5>
                    <p><strong>Name:</strong> {{ $sale->customer->name }}</p>
                    <p><strong>Phone:</strong> {{ $sale->customer->phone }}</p>
                    <p><strong>Address:</strong> {{ $sale->customer->address }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Sale Info:</h5>
                    <p><strong>Invoice #:</strong> {{ $sale->invoice_no }}</p>
                    <p><strong>Date:</strong> {{ $sale->created_at->format('d M Y') }}</p>
                    <p><strong>Status:</strong> <span class="badge bg-primary">{{ ucwords($sale->status) }}</span></p>
                </div>
            </div>

            <h5>Items</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->items as $item)
                    <tr>
                        <td>{{ $item->finishedProduct->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>₹{{ number_format($item->price, 2) }}</td>
                        <td>₹{{ number_format($item->quantity * $item->price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                        <td>₹{{ number_format($sale->total_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end"><strong>GST (18%):</strong></td>
                        <td>₹{{ number_format($sale->gst_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Grand Total:</strong></td>
                        <td><strong>₹{{ number_format($sale->total_amount + $sale->gst_amount, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
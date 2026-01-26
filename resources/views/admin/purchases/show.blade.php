@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Purchase Order #{{ $purchase->id }}</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <strong>Order ID:</strong> #{{ $purchase->id }} <br>
                            <strong>Vendor:</strong> {{ $purchase->vendor->name }} <br>
                        </div>
                        <div class="col-md-4">
                            <strong>Created By:</strong> {{ $purchase->user->name }} <br>
                            <strong>Date:</strong> {{ $purchase->created_at->format('d-m-Y') }} <br>
                        </div>
                        <div class="col-md-4">
                            <strong>Status:</strong> <span class="badge bg-primary">{{ ucwords($purchase->status) }}</span> <br>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Part Name</th>
                                    <th>SKU</th>
                                    <th>Qty</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $subtotal = 0;
                                @endphp
                                @foreach($purchase->items as $item)
                                    @php
                                        $total = $item->quantity * $item->price;
                                        $subtotal += $total;
                                    @endphp
                                    <tr>
                                        <td>{{ $item->part->name }}</td>
                                        <td>{{ $item->part->sku }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>₹{{ number_format($item->price, 2) }}</td>
                                        <td>₹{{ number_format($total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-6 offset-lg-6">
                            <h5 class="text-end">Order Summary</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Subtotal</strong></td>
                                        <td class="text-end">₹{{ number_format($subtotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>GST (18%)</strong></td>
                                        @php $gst = $subtotal * 0.18; @endphp
                                        <td class="text-end">₹{{ number_format($gst, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Grand Total</strong></td>
                                        <td class="text-end"><strong>₹{{ number_format($subtotal + $gst, 2) }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.purchases.index') }}" class="btn btn-secondary">Back</a>
                        <button onclick="window.print()" class="btn btn-primary">Print Invoice</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

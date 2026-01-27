@extends('user.layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-3">Account Entry Details</h2>

    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Type:</strong> <span class="badge bg-{{ $payment->type == 'sale' ? 'success' : 'danger' }}">{{ ucfirst($payment->type) }}</span></p>
                    <p><strong>Party:</strong> {{ $payment->vendor_name }}</p>
                    <p><strong>Invoice:</strong> 
                        @if($payment->type == 'sale')
                            <a href="{{ route('user.sales.show', $payment->sale_id) }}">#{{ $payment->sale_id }}</a>
                        @else
                            <a href="{{ route('user.purchases.show', $payment->purchase_id) }}">#{{ $payment->purchase_id }}</a>
                        @endif
                    </p>
                    <p><strong>Payment Mode:</strong> {{ $payment->payment_mode }}</p>
                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M, Y') }}</p>

                </div>
                <div class="col-md-6">
                    <p><strong>Total Amount:</strong> ₹{{ number_format($payment->total_amount, 2) }}</p>
                    <p><strong>Paid Amount:</strong> ₹{{ number_format($payment->paid_amount, 2) }}</p>
                    <p><strong>Due:</strong> <span class="text-danger">₹{{ number_format($payment->due_amount, 2) }}</span></p>
                    <p><strong>Advance:</strong> <span class="text-primary">₹{{ number_format($payment->advance_amount, 2) }}</span></p>
                </div>
            </div>

            @if($payment->note)
                <hr>
                <p><strong>Note:</strong></p>
                <p>{{ $payment->note }}</p>
            @endif

            <a href="{{ route('user.payments.index') }}" class="btn btn-secondary mt-3">
                Back to Accounts
            </a>

        </div>
    </div>
</div>
@endsection
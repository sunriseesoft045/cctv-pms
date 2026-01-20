@extends('user.layouts.app')
@section('page-title', 'Edit Payment')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-edit"></i> Edit Payment</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('user.payments.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Please fix the following errors:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Payment #{{ $payment->id }} Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.payments.update', $payment->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="sale_id" class="form-label">Sale <span class="text-danger">*</span></label>
                            <select name="sale_id" id="sale_id" class="form-select @error('sale_id') is-invalid @enderror" required>
                                <option value="">-- Select Sale --</option>
                                @foreach($sales as $sale)
                                    <option value="{{ $sale->id }}" {{ $payment->sale_id == $sale->id ? 'selected' : '' }}>
                                        Sale #{{ $sale->id }} - {{ $sale->product->name }} (Qty: {{ $sale->quantity }}) - ₹{{ number_format($sale->quantity * $sale->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sale_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" 
                                       value="{{ old('amount', $payment->amount) }}" step="0.01" min="0.01" required>
                            </div>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="method" class="form-label">Payment Method <span class="text-danger">*</span></label>
                            <select name="method" id="method" class="form-select @error('method') is-invalid @enderror" required>
                                <option value="">-- Select Method --</option>
                                <option value="cash" {{ $payment->method == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="upi" {{ $payment->method == 'upi' ? 'selected' : '' }}>UPI</option>
                                <option value="bank" {{ $payment->method == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                            </select>
                            @error('method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Created At:</strong></p>
                                <p>{{ $payment->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Created By:</strong></p>
                                <p>{{ $payment->user->name }}</p>
                            </div>
                        </div>

                        <hr>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('user.payments.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
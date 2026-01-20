@extends('user.layouts.app')
@section('page-title', 'Add Payment')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-plus-circle"></i> Add Payment</h2>
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
                    <h5 class="mb-0">Payment Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.payments.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="sale_id" class="form-label">Sale <span class="text-danger">*</span></label>
                            <select name="sale_id" id="sale_id" class="form-select @error('sale_id') is-invalid @enderror" required>
                                <option value="">-- Select Sale --</option>
                                @foreach($sales as $sale)
                                    <option value="{{ $sale->id }}" {{ old('sale_id') == $sale->id ? 'selected' : '' }}>
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
                                       value="{{ old('amount', '0.00') }}" step="0.01" min="0.01" required>
                            </div>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="method" class="form-label">Payment Method <span class="text-danger">*</span></label>
                            <select name="method" id="method" class="form-select @error('method') is-invalid @enderror" required>
                                <option value="">-- Select Method --</option>
                                <option value="cash" {{ old('method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="upi" {{ old('method') == 'upi' ? 'selected' : '' }}>UPI</option>
                                <option value="bank" {{ old('method') == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                            </select>
                            @error('method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <strong>Note:</strong> Only approved sales can have payments recorded.
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="fas fa-redo"></i> Clear
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
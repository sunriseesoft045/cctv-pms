@extends('user.layouts.app')

@section('content')
<div class="container-fluid">
    <h2>Edit Payment Entry</h2>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('user.payments.update', $payment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="alert alert-info">
                    You can only update the payment mode, date, and note for an existing entry. To change amounts or type, please delete this entry and create a new one.
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Type</label>
                        <input type="text" class="form-control" value="{{ ucfirst($payment->type) }}" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Party</label>
                        <input type="text" class="form-control" value="{{ $payment->vendor_name }}" readonly>
                    </div>
                </div>

                 <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Total Amount</label>
                        <input type="text" class="form-control" value="{{ number_format($payment->total_amount, 2) }}" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Paid Amount</label>
                        <input type="text" class="form-control" value="{{ number_format($payment->paid_amount, 2) }}" readonly>
                    </div>
                     <div class="col-md-4 mb-3">
                        <label class="form-label">Due / Advance</label>
                        <input type="text" class="form-control" value="{{ $payment->due_amount > 0 ? 'Due: ' . number_format($payment->due_amount, 2) : 'Adv: ' . number_format($payment->advance_amount, 2) }}" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="payment_mode" class="form-label">Payment Mode</label>
                        <select class="form-select @error('payment_mode') is-invalid @enderror" id="payment_mode" name="payment_mode" required>
                            <option value="Cash" {{ old('payment_mode', $payment->payment_mode) == 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="UPI" {{ old('payment_mode', $payment->payment_mode) == 'UPI' ? 'selected' : '' }}>UPI</option>
                            <option value="Bank" {{ old('payment_mode', $payment->payment_mode) == 'Bank' ? 'selected' : '' }}>Bank</option>
                            <option value="Cheque" {{ old('payment_mode', $payment->payment_mode) == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                        </select>
                         @error('payment_mode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                     <div class="col-md-6 mb-3">
                        <label for="payment_date" class="form-label">Payment Date</label>
                        <input type="date" class="form-control @error('payment_date') is-invalid @enderror" id="payment_date" name="payment_date" value="{{ old('payment_date', \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d')) }}" required>
                         @error('payment_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="note" class="form-label">Note (Optional)</label>
                    <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note" rows="3">{{ old('note', $payment->note) }}</textarea>
                     @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Entry</button>
                <a href="{{ route('user.payments.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
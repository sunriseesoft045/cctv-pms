@extends('user.layouts.app')

@section('content')
<div class="container-fluid">
    <h2>Add New Payment / Receipt</h2>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('user.payments.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">Payment Type</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required {{ $invoice ? 'disabled' : '' }}>
                            <option value="">Select Type</option>
                            <option value="purchase" {{ old('type', ($invoice ? 'sale' : '')) == 'purchase' ? 'selected' : '' }}>Purchase Payment</option>
                            <option value="sale" {{ old('type', ($invoice ? 'sale' : '')) == 'sale' ? 'selected' : '' }}>Sale Receipt</option>
                        </select>
                        @if($invoice)
                            <input type="hidden" name="type" value="sale">
                        @endif
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div id="purchase_fields" class="{{ $invoice ? 'd-none' : '' }}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="purchase_id" class="form-label">Purchase Invoice</label>
                            <select class="form-select" id="purchase_id" name="purchase_id">
                                <!-- Options will be loaded via AJAX -->
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="vendor_name" class="form-label">Vendor Name</label>
                            <input type="text" class="form-control" id="vendor_name" name="vendor_name" readonly>
                        </div>
                    </div>
                </div>

                <div id="sale_fields" class="{{ $invoice ? '' : 'd-none' }}">
                   <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sale_id" class="form-label">Sale Invoice</label>
                            <select class="form-select" id="sale_id" name="sale_id" {{ $invoice ? 'disabled' : '' }}>
                                @if($invoice)
                                    <option value="{{ $invoice->id }}" selected>#{{$invoice->id}} - {{ $invoice->customer_name }}</option>
                                @endif
                            </select>
                             @if($invoice)
                                <input type="hidden" name="sale_id" value="{{ $invoice->id }}">
                            @endif
                        </div>
                         <div class="col-md-6 mb-3">
                            <label for="customer_name" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ $invoice ? $invoice->customer_name : '' }}" readonly>
                        </div>
                   </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="total_amount" class="form-label">Total Amount</label>
                        <input type="number" class="form-control" id="total_amount" name="total_amount" value="{{ $invoice ? $invoice->total : '' }}" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="paid_amount" class="form-label">Paid Amount</label>
                        <input type="number" class="form-control @error('paid_amount') is-invalid @enderror" id="paid_amount" name="paid_amount" step="0.01" required>
                         @error('paid_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="payment_mode" class="form-label">Payment Mode</label>
                        <select class="form-select @error('payment_mode') is-invalid @enderror" id="payment_mode" name="payment_mode" required>
                            <option value="Cash" {{ old('payment_mode') == 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="UPI" {{ old('payment_mode') == 'UPI' ? 'selected' : '' }}>UPI</option>
                            <option value="Bank" {{ old('payment_mode') == 'Bank' ? 'selected' : '' }}>Bank</option>
                            <option value="Cheque" {{ old('payment_mode') == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                        </select>
                         @error('payment_mode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="payment_date" class="form-label">Payment Date</label>
                        <input type="date" class="form-control @error('payment_date') is-invalid @enderror" id="payment_date" name="payment_date" value="{{ date('Y-m-d') }}" required>
                         @error('payment_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="note" class="form-label">Note (Optional)</label>
                    <textarea class="form-control" id="note" name="note" rows="3">{{ old('note') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Save Payment</button>
                <a href="{{ route('user.payments.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('type');
    const purchaseFields = document.getElementById('purchase_fields');
    const saleFields = document.getElementById('sale_fields');
    const purchaseSelect = document.getElementById('purchase_id');
    const saleSelect = document.getElementById('sale_id');
    const vendorNameInput = document.getElementById('vendor_name');
    const customerNameInput = document.getElementById('customer_name');
    const totalAmountInput = document.getElementById('total_amount');

    function toggleFields() {
        totalAmountInput.value = '';
        vendorNameInput.value = '';
        customerNameInput.value = '';
        if (typeSelect.value === 'purchase') {
            purchaseFields.classList.remove('d-none');
            saleFields.classList.add('d-none');
            loadPurchases();
        } else if (typeSelect.value === 'sale') {
            saleFields.classList.remove('d-none');
            purchaseFields.classList.add('d-none');
            loadSales();
        } else {
            purchaseFields.classList.add('d-none');
            saleFields.classList.add('d-none');
        }
    }

    function loadPurchases() {
        fetch("{{ route('user.api.purchases') }}")
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('purchase_id');
                select.innerHTML = '<option value="">Select Purchase Invoice</option>';

                data.forEach(p => {
                    const option = document.createElement('option');
                    option.value = p.id;
                    option.text = p.invoice_number + ' — ' + p.vendor_name;
                    option.dataset.vendor = p.vendor_name;
                    option.dataset.total = p.total_amount;
                    select.appendChild(option);
                });
            });
    }

    function loadSales() {
        fetch("{{ route('user.api.sales.unpaid') }}")
            .then(response => response.json())
            .then(data => {
                saleSelect.innerHTML = '<option value="">Select Sale Invoice</option>';
                data.forEach(sale => {
                    const option = document.createElement('option');
                    option.value = sale.id;
                    option.textContent = `${sale.invoice_no} — ${sale.customer_name} (Due: ${sale.due_amount})`;
                    option.dataset.customer = sale.customer_name;
                    option.dataset.total = sale.total_amount;
                    option.dataset.paid = sale.paid_amount;
                    option.dataset.due = sale.due_amount;
                    saleSelect.add(option);
                });
            });
    }

    document.getElementById('purchase_id').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        vendorNameInput.value = selected.dataset.vendor || '';
        totalAmountInput.value = selected.dataset.total || '';
        document.getElementById('paid_amount').value = 0;
    });

    saleSelect.addEventListener('change', function() {
        let opt = this.options[this.selectedIndex];
        customerNameInput.value = opt.dataset.customer || '';
        totalAmountInput.value = opt.dataset.total || '';
        document.getElementById('paid_amount').value = 0; // Initialize paid amount to 0 for sales
    });

    typeSelect.addEventListener('change', toggleFields);
    // Initial call in case of old() value
    toggleFields();
});
</script>
@endpush

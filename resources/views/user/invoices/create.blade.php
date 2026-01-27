@extends('user.layouts.app')

@section('content')
<div class="container-fluid">
    <h2>Create Invoice</h2>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('user.invoices.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="bill_to" class="form-label">Bill To</label>
                        <input type="text" class="form-control" id="bill_to" name="bill_to" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="ship_to" class="form-label">Ship To (Optional)</label>
                        <input type="text" class="form-control" id="ship_to" name="ship_to">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="due_date" class="form-label">Due Date (Optional)</label>
                        <input type="date" class="form-control" id="due_date" name="due_date">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="payment_terms" class="form-label">Payment Terms (Optional)</label>
                        <input type="text" class="form-control" id="payment_terms" name="payment_terms">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="po_number" class="form-label">PO Number (Optional)</label>
                        <input type="text" class="form-control" id="po_number" name="po_number">
                    </div>
                </div>

                <hr>

                <table class="table table-bordered" id="items-table">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Rate</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="items[0][item_name]" class="form-control" required></td>
                            <td><input type="number" name="items[0][quantity]" class="form-control quantity" value="1" min="1" required></td>
                            <td><input type="number" name="items[0][rate]" class="form-control rate" step="0.01" min="0" required></td>
                            <td><input type="number" name="items[0][amount]" class="form-control amount" readonly></td>
                            <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" id="add-row" class="btn btn-primary">Add Row</button>

                <hr>

                <div class="row justify-content-end">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="subtotal" class="form-label">Subtotal</label>
                            <input type="number" class="form-control" id="subtotal" name="subtotal" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tax" class="form-label">Tax (Optional)</label>
                            <input type="number" class="form-control" id="tax" name="tax" step="0.01" value="0">
                        </div>
                        <div class="mb-3">
                            <label for="discount" class="form-label">Discount (Optional)</label>
                            <input type="number" class="form-control" id="discount" name="discount" step="0.01" value="0">
                        </div>
                        <div class="mb-3">
                            <label for="shipping" class="form-label">Shipping (Optional)</label>
                            <input type="number" class="form-control" id="shipping" name="shipping" step="0.01" value="0">
                        </div>
                        <div class="mb-3">
                            <label for="total" class="form-label">Total</label>
                            <input type="number" class="form-control" id="total" name="total" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="paid" class="form-label">Amount Paid</label>
                            <input type="number" class="form-control" id="paid" name="paid" step="0.01" value="0">
                        </div>
                        <div class="mb-3">
                            <label for="balance" class="form-label">Balance Due</label>
                            <input type="number" class="form-control" id="balance" name="balance" readonly>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">Notes (Optional)</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="terms" class="form-label">Terms (Optional)</label>
                    <textarea class="form-control" id="terms" name="terms" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-success mt-3">Save Invoice</button>
                <a href="{{ route('user.invoices.index') }}" class="btn btn-secondary mt-3">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let itemIndex = 0; // Use a new index for items

    function calculateLineTotal(row) {
        let quantity = parseFloat(row.find('.quantity').val()) || 0;
        let rate = parseFloat(row.find('.rate').val()) || 0;
        row.find('.amount').val((quantity * rate).toFixed(2));
    }

    function calculateGrandTotals() {
        let subtotal = 0;
        $('#items-table tbody tr').each(function() {
            subtotal += parseFloat($(this).find('.amount').val()) || 0;
        });
        $('#subtotal').val(subtotal.toFixed(2));

        let tax = parseFloat($('#tax').val()) || 0;
        let discount = parseFloat($('#discount').val()) || 0;
        let shipping = parseFloat($('#shipping').val()) || 0;
        let paid = parseFloat($('#paid').val()) || 0;

        let total = subtotal + tax + shipping - discount;
        $('#total').val(total.toFixed(2));

        let balance = total - paid;
        $('#balance').val(balance.toFixed(2));
    }

    $('#add-row').on('click', function() {
        itemIndex++;
        let newRow = `
            <tr>
                <td><input type="text" name="items[${itemIndex}][item_name]" class="form-control" required></td>
                <td><input type="number" name="items[${itemIndex}][quantity]" class="form-control quantity" value="1" min="1" required></td>
                <td><input type="number" name="items[${itemIndex}][rate]" class="form-control rate" step="0.01" min="0" required></td>
                <td><input type="number" name="items[${itemIndex}][amount]" class="form-control amount" readonly></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
            </tr>
        `;
        $('#items-table tbody').append(newRow);
        calculateGrandTotals();
    });

    $('#items-table').on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
        calculateGrandTotals();
    });

    $('#items-table').on('input', '.quantity, .rate', function() {
        calculateLineTotal($(this).closest('tr'));
        calculateGrandTotals();
    });

    $('#tax, #discount, #shipping, #paid').on('input', function() {
        calculateGrandTotals();
    });

    // Initial calculations
    calculateGrandTotals();
});
</script>
@endpush
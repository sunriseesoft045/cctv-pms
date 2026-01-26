@extends('user.layouts.app')

@section('content')
<div class="container-fluid">
    <h3>Create Sale</h3>

    <form action="{{ route('user.sales.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Select Customer</label>
            <select id="customerSelect" class="form-control">
                <option value="">-- New Customer --</option>
                @foreach($customers as $c)
                    <option 
                        value="{{ $c->name }}"
                        data-phone="{{ $c->phone }}" 
                        data-address="{{ $c->address }}">
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Customer Name</label>
            <input type="text" name="customer_name" id="customerName" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="customer_phone" id="customerPhone" class="form-control">
        </div>

        <div class="mb-3">
            <label>Address</label>
            <textarea name="customer_address" id="customerAddress" class="form-control"></textarea>
        </div>

        <h4>Products</h4>
        <table class="table table-bordered" id="products-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dynamic rows will be added here -->
            </tbody>
        </table>

        <button type="button" class="btn btn-secondary" id="add-product-row">+ Add Product</button>
        <hr>

        <button type="submit" class="btn btn-success">Save Sale</button>
        <a href="{{ route('user.sales.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('customerSelect').addEventListener('change', function(){
        let opt = this.options[this.selectedIndex];
        if(this.value === ""){
            document.getElementById('customerName').value = "";
            document.getElementById('customerPhone').value = "";
            document.getElementById('customerAddress').value = "";
        } else {
            document.getElementById('customerName').value = this.value;
            document.getElementById('customerPhone').value = opt.dataset.phone || '';
            document.getElementById('customerAddress').value = opt.dataset.address || '';
        }
    });

    let productRowIndex = 0;
    const addProductRowButton = document.getElementById('add-product-row');
    const productsTableBody = document.querySelector('#products-table tbody');

    addProductRowButton.addEventListener('click', function () {
        const newRow = `
            <tr>
                <td>
                    <select name="products[${productRowIndex}][id]" class="form-control" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} (Stock: {{ $product->stock }})</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="products[${productRowIndex}][quantity]" class="form-control" min="1" placeholder="Quantity" required>
                </td>
                <td>
                    <input type="number" name="products[${productRowIndex}][price]" class="form-control" min="0" step="0.01" placeholder="Price" required>
                </td>
                <td>
                    <button type="button" class="btn btn-danger remove-product-row">X</button>
                </td>
            </tr>
        `;
        productsTableBody.insertAdjacentHTML('beforeend', newRow);
        productRowIndex++;
    });

    productsTableBody.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-product-row')) {
            e.target.closest('tr').remove();
        }
    });
});
</script>
@endsection
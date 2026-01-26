@extends('user.layouts.app')

@section('content')
<div class="container-fluid">
    <h3>Edit Sale</h3>

    <form action="{{ route('user.sales.update', $sale->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="customer_id">Customer</label>
            <select name="customer_id" id="customer_id" class="form-control" required>
                @foreach($customers as $customer)
                <option value="{{ $customer->id }}" {{ $sale->customer_id == $customer->id ? 'selected' : '' }}>
                    {{ $customer->name }}
                </option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group mb-3">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="pending" {{ $sale->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ $sale->status == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="approved" {{ $sale->status == 'approved' ? 'selected' : '' }}>Approved</option>
                 <option value="rejected" {{ $sale->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
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
                @foreach($sale->items as $index => $item)
                <tr>
                    <td>
                        <select name="products[{{ $index }}][id]" class="form-control" required>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ $item->finished_product_id == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} (Stock: {{ $product->stock }})
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="products[{{ $index }}][quantity]" class="form-control" min="1" value="{{ $item->quantity }}" required>
                    </td>
                    <td>
                        <input type="number" name="products[{{ $index }}][price]" class="form-control" min="0" step="0.01" value="{{ $item->price }}" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger remove-product-row">X</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button type="button" class="btn btn-secondary" id="add-product-row">+ Add Product</button>
        <hr>

        <button type="submit" class="btn btn-primary">Update Sale</button>
        <a href="{{ route('user.sales.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let productRowIndex = {{ count($sale->items) }};
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

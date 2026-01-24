@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-3">Create Bill of Materials (BOM)</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.boms.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Product Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Product SKU</label>
                            <input type="text" name="sku" class="form-control" required>
                        </div>
                    </div>
                </div>

                <hr>

                <h3>Parts</h3>
                <div id="parts-container">
                    <div class="row part-item mb-3">
                        <div class="col-md-6">
                            <label>Part</label>
                            <select name="items[0][part_id]" class="form-control" required>
                                <option value="">-- Select Part --</option>
                                @foreach($parts as $part)
                                    <option value="{{ $part->id }}" data-stock="{{ $part->stock }}">{{ $part->name }} (Stock: {{ $part->stock }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Quantity Required</label>
                            <input type="number" name="items[0][qty_required]" class="form-control" min="1" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove-part-btn" style="display:none;">Remove</button>
                        </div>
                    </div>
                </div>

                <button type="button" id="add-part-btn" class="btn btn-secondary mb-3">+ Add Another Part</button>

                <hr>

                <button type="submit" class="btn btn-success">Save BOM</button>
                <a href="{{ route('admin.boms.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let partIndex = 1;
    const addPartBtn = document.getElementById('add-part-btn');
    const partsContainer = document.getElementById('parts-container');

    addPartBtn.addEventListener('click', function () {
        const newItem = partsContainer.firstElementChild.cloneNode(true);
        newItem.querySelectorAll('select, input').forEach(input => {
            const name = input.name.replace(/\[\d+\]/, `[${partIndex}]`);
            input.name = name;
            input.value = '';
        });
        newItem.querySelector('.remove-part-btn').style.display = 'inline-block';
        partsContainer.appendChild(newItem);
        partIndex++;
    });

    partsContainer.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-part-btn')) {
            e.target.closest('.part-item').remove();
        }
    });
});
</script>
@endsection
@endsection
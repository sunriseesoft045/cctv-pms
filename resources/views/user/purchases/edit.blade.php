@extends('user.layouts.app')

@section('content')
<div class="container">
    <h2>Edit Purchase</h2>

    <form method="POST" action="{{ route('user.purchases.update', $purchase->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Vendor</label>
            <select name="vendor_id" class="form-control">
                @foreach($vendors as $v)
                <option value="{{ $v->id }}" {{ $purchase->vendor_id == $v->id ? 'selected' : '' }}>
                    {{ $v->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Vendor Phone</label>
            <input type="text" name="vendor_phone" class="form-control" value="{{ $purchase->vendor_phone }}" required>
        </div>

        <div class="mb-3">
            <label>Vendor Address</label>
            <textarea name="vendor_address" class="form-control" required>{{ $purchase->vendor_address }}</textarea>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="Pending" {{ $purchase->status=='Pending'?'selected':'' }}>Pending</option>
                <option value="Completed" {{ $purchase->status=='Completed'?'selected':'' }}>Completed</option>
                <option value="Approved" {{ $purchase->status=='approved'?'selected':'' }}>Approved</option>
                <option value="Rejected" {{ $purchase->status=='rejected'?'selected':'' }}>Rejected</option>
            </select>
        </div>

        <h4>Parts</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Part</th>
                    <th width="150">Qty</th>
                    <th width="150">Price</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="partsTable">
                @foreach($purchase->items as $i => $item)
                <tr>
                    <td>
                        <select name="items[{{ $i }}][part_id]" class="form-control">
                            @foreach($parts as $p)
                            <option value="{{ $p->id }}" {{ $item->part_id == $p->id ? 'selected' : '' }}>
                                {{ $p->name }}
                            </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="items[{{ $i }}][quantity]" class="form-control" value="{{ $item->quantity }}">
                    </td>
                    <td>
                        <input type="number" step="0.01" name="items[{{ $i }}][price]" class="form-control" value="{{ $item->price }}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button type="button" class="btn btn-sm btn-secondary" onclick="addRow()">+ Add Part</button>
        <br><br>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('user.purchases.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

<script>
    let row = {{ count($purchase->items) }};
    function addRow() {
        const table = document.getElementById('partsTable');
        const html = `
        <tr>
          <td>
            <select name="items[${row}][part_id]" class="form-control">
              @foreach($parts as $p)
              <option value="{{ $p->id }}">{{ $p->name }}</option>
              @endforeach
            </select>
          </td>
          <td><input type="number" name="items[${row}][quantity]" class="form-control" value="1"></td>
          <td><input type="number" step="0.01" name="items[${row}][price]" class="form-control" value="0"></td>
          <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button>
          </td>
        </tr>`;
        table.insertAdjacentHTML('beforeend', html);
        row++;
    }

    function deleteRow(btn) {
        const row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
</script>
@endsection

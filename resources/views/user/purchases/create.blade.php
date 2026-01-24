@extends('user.layouts.app')

@section('content')
<div class="container-fluid">
<h3>Create Purchase</h3>

<form method="POST" action="{{ route('user.purchases.store') }}">
@csrf

<div class="form-group mb-3">
  <label>Vendor Name</label>
  <input type="text" name="vendor_name" class="form-control" required>
</div>

<div class="form-group mb-3">
  <label>Invoice Number</label>
  <input type="text" name="invoice_no" class="form-control" value="INV-{{ time() }}" required>
</div>

<table class="table table-bordered" id="partsTable">
<thead>
<tr>
  <th>Part</th>
  <th>Qty</th>
  <th>Price</th>
  <th>Action</th>
</tr>
</thead>
<tbody>
<tr>
  <td>
    <select name="parts[]" class="form-control" required>
      <option value="">Select Part</option>
      @foreach($parts as $p)
        <option value="{{ $p->id }}">{{ $p->name }} (Stock: {{ $p->stock }})</option>
      @endforeach
    </select>
  </td>
  <td>
    <input type="number" name="qty[]" class="form-control" min="1" required>
  </td>
  <td>
    <input type="number" name="price[]" class="form-control" min="0" step="0.01" required>
  </td>
  <td>
    <button type="button" class="btn btn-danger removeRow">X</button>
  </td>
</tr>
</tbody>
</table>

<button type="button" id="addRow" class="btn btn-secondary mb-3">
+ Add More Parts
</button>

<br>
<button class="btn btn-primary">Save Purchase</button>
<a href="{{ route('user.purchases.index') }}" class="btn btn-secondary">Back</a>

</form>
</div>

<script>
document.getElementById('addRow').onclick = function(){
  let table = document.querySelector('#partsTable tbody');
  let row = table.rows[0].cloneNode(true);
  row.querySelectorAll('input, select').forEach(e => e.value = '');
  table.appendChild(row);
};

document.addEventListener('click', function(e){
  if(e.target.classList.contains('removeRow')){
    let rows = document.querySelectorAll('#partsTable tbody tr');
    if(rows.length > 1){
      e.target.closest('tr').remove();
    }
  }
});
</script>
@endsection
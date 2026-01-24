@extends('admin.layouts.app')
@section('content')
<div class='container-fluid'>
<h1>Edit BOM</h1>

<form method='POST' action='{{ route("admin.boms.update", $bom) }}'>
@csrf
@method('PUT')

<div class='form-group mb-3'>
<label>Product Name</label>
<input type='text' name='name' class='form-control' value='{{ $bom->name }}' required>
</div>

<div class='form-group mb-3'>
<label>SKU</label>
<input type='text' name='sku' class='form-control' value='{{ $bom->sku }}' required>
</div>

<h5>Parts</h5>

@foreach($bom->items as $i => $item)
<div class='row mb-2'>
  <div class='col'>
    <select name='parts[]' class='form-control'>
      @foreach($parts as $p)
        <option value='{{ $p->id }}' @if($p->id == $item->part_id) selected @endif>
          {{ $p->name }}
        </option>
      @endforeach
    </select>
  </div>
  <div class='col'>
    <input type='number' name='qty[]' class='form-control' value='{{ $item->qty_required }}' min='1' required>
  </div>
</div>
@endforeach

<button class='btn btn-success'>Update BOM</button>
<a href='{{ route("admin.boms.index") }}' class='btn btn-secondary'>Back</a>
</form>
</div>
@endsection
@extends('admin.layouts.app')

@section('content')
<div class='container-fluid'>

<h1 class='mb-3'>Edit Part</h1>

<form action='{{ route("admin.parts.update", $part) }}' method='POST'>
  @csrf
  @method('PUT')

  <div class='form-group mb-3'>
    <label>Name</label>
    <input type='text' name='name' class='form-control' value='{{ $part->name }}' required>
  </div>

  <div class='form-group mb-3'>
    <label>SKU</label>
    <input type='text' name='sku' class='form-control' value='{{ $part->sku }}' required>
  </div>

  <div class='form-group mb-3'>
    <label>Unit</label>
    <input type='text' name='unit' class='form-control' value='{{ $part->unit }}' required>
  </div>

  <div class='form-group mb-3'>
    <label>Stock</label>
    <input type='number' name='stock' class='form-control' value='{{ $part->stock }}' required>
  </div>

  <div class='form-group mb-3'>
    <label>Min Stock</label>
    <input type='number' name='min_stock' class='form-control' value='{{ $part->min_stock }}' required>
  </div>

  <button class='btn btn-success'>Update Part</button>
  <a href='{{ route("admin.parts.index") }}' class='btn btn-secondary'>Back</a>

</form>

</div>
@endsection
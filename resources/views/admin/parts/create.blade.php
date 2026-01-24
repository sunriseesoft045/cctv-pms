@extends('admin.layouts.app')

@section('content')
<div class='container-fluid'>
<h1 class='mb-3'>Add Part</h1>

<form action='{{ route("admin.parts.store") }}' method='POST'>
@csrf

<div class='form-group mb-3'>
<label>Name</label>
<input type='text' name='name' class='form-control' required>
</div>

<div class='form-group mb-3'>
<label>SKU</label>
<input type='text' name='sku' class='form-control' required>
</div>

<div class='form-group mb-3'>
<label>Unit</label>
<input type='text' name='unit' class='form-control' required>
</div>

<div class='form-group mb-3'>
<label>Stock</label>
<input type='number' name='stock' class='form-control' value='0' required>
</div>

<div class='form-group mb-3'>
<label>Min Stock</label>
<input type='number' name='min_stock' class='form-control' value='0' required>
</div>

<button class='btn btn-primary'>Save Part</button>
<a href='{{ route("admin.parts.index") }}' class='btn btn-secondary'>Back</a>
</form>
</div>
@endsection
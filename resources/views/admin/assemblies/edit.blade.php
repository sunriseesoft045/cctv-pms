@extends('admin.layouts.app')
@section('content')
<div class='container-fluid'>
<h1>Edit Assembly</h1>

<form method='POST' action='{{ route("admin.assemblies.update", $assembly) }}'>
@csrf
@method('PUT')

<div class='form-group mb-3'>
<label>Quantity</label>
<input type='number' name='quantity' class='form-control' value='{{ $assembly->quantity }}' min='1' required>
</div>

<button class='btn btn-success'>Update</button>
<a href='{{ route("admin.assemblies.index") }}' class='btn btn-secondary'>Back</a>
</form>
</div>
@endsection

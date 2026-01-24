@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-3">Create Assembly</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.assemblies.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="bom_id">Select BOM (Recipe)</label>
                    <select name="bom_id" id="bom_id" class="form-control" required>
                        <option value="">-- Choose a BOM --</option>
                        @foreach($boms as $bom)
                            <option value="{{ $bom->id }}" {{ old('bom_id') == $bom->id ? 'selected' : '' }}>
                                {{ $bom->name }} (SKU: {{ $bom->sku }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="quantity">Quantity to Assemble</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity', 1) }}" min="1" required>
                </div>

                <button type="submit" class="btn btn-success">Assemble</button>
                <a href="{{ route('admin.assemblies.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Edit Camera')

@section('content_header')
    <h1>Edit Camera</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Camera Details</h3>
                </div>
                <form action="{{ route('cameras.update', $camera->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Or @method('PATCH') --}}
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Camera Name</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $camera->name) }}" placeholder="Enter camera name" required>
                        </div>
                        <div class="form-group">
                            <label for="model">Model</label>
                            <input type="text" name="model" class="form-control" id="model" value="{{ old('model', $camera->model) }}" placeholder="Enter model" required>
                        </div>
                        <div class="form-group">
                            <label for="serial_number">Serial Number</label>
                            <input type="text" name="serial_number" class="form-control" id="serial_number" value="{{ old('serial_number', $camera->serial_number) }}" placeholder="Enter serial number" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" id="status" required>
                                @php
                                    $statuses = ['in_production', 'quality_check', 'packaged', 'shipped'];
                                @endphp
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}" {{ old('status', $camera->status) == $status ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('cameras.index') }}" class="btn btn-default float-right">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

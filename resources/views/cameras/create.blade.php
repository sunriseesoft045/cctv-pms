@extends('layouts.app')

@section('title', 'Add New Camera')

@section('content_header')
    <h1>Add New Camera</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Camera Details</h3>
                </div>
                <form action="{{ route('cameras.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Camera Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter camera name" required>
                        </div>
                        <div class="form-group">
                            <label for="model">Model</label>
                            <input type="text" name="model" class="form-control" id="model" placeholder="Enter model" required>
                        </div>
                        <div class="form-group">
                            <label for="serial_number">Serial Number</label>
                            <input type="text" name="serial_number" class="form-control" id="serial_number" placeholder="Enter serial number" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" id="status" required>
                                <option value="in_production">In Production</option>
                                <option value="quality_check">Quality Check</option>
                                <option value="packaged">Packaged</option>
                                <option value="shipped">Shipped</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
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

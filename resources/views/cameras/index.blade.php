@extends('layouts.app')

@section('title', 'CCTV Cameras')

@section('content_header')
    <h1>CCTV Cameras</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List of Cameras</h3>
                    <div class="card-tools">
                        <a href="{{ route('cameras.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add New Camera
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if ($cameras->isEmpty())
                        <p class="text-center p-3">No cameras found.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Model</th>
                                    <th>Serial Number</th>
                                    <th>Status</th>
                                    <th style="width: 40px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cameras as $camera)
                                    <tr>
                                        <td>{{ $camera->id }}</td>
                                        <td>{{ $camera->name }}</td>
                                        <td>{{ $camera->model }}</td>
                                        <td>{{ $camera->serial_number }}</td>
                                        <td>
                                            <span class="badge {{ $camera->status == 'in_production' ? 'bg-info' : 'bg-success' }}">
                                                {{ $camera->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('cameras.edit', $camera->id) }}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                                <i class="fa fa-lg fa-fw fa-pen"></i>
                                            </a>
                                            <form action="{{ route('cameras.destroy', $camera->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete" onclick="return confirm('Are you sure you want to delete this camera?')">
                                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="card-footer clearfix">
                    {{-- Pagination will go here later --}}
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
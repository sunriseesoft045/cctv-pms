@extends('user.layouts.app')
@section('page-title', 'User Dashboard')
@section('content')
<div class="container">
    <h1>Welcome, {{ auth()->user()->name }}!</h1>
    <p>This is your dashboard.</p>
</div>
@endsection
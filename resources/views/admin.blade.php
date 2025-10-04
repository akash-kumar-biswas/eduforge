{{-- resources/views/admin.blade.php --}}
@extends('layouts.admin-layout')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Welcome to Admin Dashboard</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Users</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $userCount ?? 0 }}</h5>
                    <p class="card-text">Total Registered Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Posts</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $postCount ?? 0 }}</h5>
                    <p class="card-text">Total Posts</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Comments</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $commentCount ?? 0 }}</h5>
                    <p class="card-text">Total Comments</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

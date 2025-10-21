@extends('layouts.instructor')

@section('title', 'Instructor Profile')

@section('content')
<style>
    :root {
        --brand-color: #04317aff;
    }

    /* === Card Styling === */
    .card {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        transition: all 0.2s ease;
        background: #fff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .card:hover {
        border-color: var(--brand-color);
        box-shadow: 0 4px 12px rgba(4, 49, 122, 0.15);
        transform: translateY(-2px);
    }

    /* === Card Header === */
    .card-header {
        background-color: var(--brand-color) !important;
        color: #fff !important;
        border-bottom: none;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    .card-header h3 {
        margin: 0;
        font-weight: 600;
        font-size: 1.25rem;
    }

    /* === Buttons === */
    .btn-primary {
        background-color: var(--brand-color) !important;
        border-color: var(--brand-color) !important;
        color: #fff !important;
        transition: all 0.2s ease;
    }

    .btn-primary:hover {
        box-shadow: 0 4px 8px rgba(4, 49, 122, 0.25);
        transform: translateY(-1px);
    }

    .btn-secondary {
        color: var(--brand-color) !important;
        border: 1px solid var(--brand-color) !important;
        background-color: #fff !important;
        transition: all 0.2s ease;
    }

    .btn-secondary:hover {
        background-color: var(--brand-color) !important;
        color: #fff !important;
        box-shadow: 0 4px 8px rgba(4, 49, 122, 0.25);
        transform: translateY(-1px);
    }

    /* === Image Styling === */
    .rounded-circle {
        border: 3px solid var(--brand-color) !important;
    }

    /* === Text + Badges === */
    .text-brand {
        color: var(--brand-color) !important;
    }

    .badge.bg-primary {
        background-color: var(--brand-color) !important;
    }

    /* === Fade In Animation === */
    .container {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* === Alert === */
    .alert-success {
        border-left: 4px solid var(--brand-color);
        background-color: #eff6ff;
        color: var(--brand-color);
    }
</style>

<div class="container my-5">
    <div class="row">
        <div class="col-md-10 mx-auto">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="mb-0"><i class="bi bi-person-circle"></i> Your Profile</h3>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center mb-4">
                            @if($instructor->image)
                                <img src="{{ asset('uploads/instructors/' . $instructor->image) }}" 
                                     alt="Profile"
                                     class="img-fluid rounded-circle border border-3"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="bg-light border border-2 border-secondary rounded-circle d-inline-flex align-items-center justify-content-center"
                                     style="width: 150px; height: 150px;">
                                    <i class="bi bi-person-fill text-secondary" style="font-size: 4rem;"></i>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-9">
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Name:</label>
                                <p class="fs-5">{{ $instructor->name }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold text-muted">Email:</label>
                                <p class="fs-5">{{ $instructor->email }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold text-muted">Phone:</label>
                                <p class="fs-5">{{ $instructor->phone ?? 'Not provided' }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold text-muted">Bio:</label>
                                <p class="text-muted">{{ $instructor->bio ?? 'No bio added yet.' }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold text-muted">Status:</label>
                                <span class="badge {{ $instructor->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($instructor->status ?? 'active') }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold text-muted">Member Since:</label>
                                <p class="text-muted">{{ $instructor->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <a href="{{ route('instructor.profile.edit') }}" class="btn btn-primary">
                            <i class="bi bi-pencil-square"></i> Edit Profile
                        </a>
                        <a href="{{ route('instructor.dashboard') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

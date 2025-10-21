@extends('layouts.instructor')

@section('title', 'My Courses')

@section('content')
<style>
    :root {
        --brand-color: #04317aff;
    }

    /* === General Card Styling === */
    .card {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #fff;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .card:hover {
        border-color: var(--brand-color);
        box-shadow: 0 4px 12px rgba(4, 49, 122, 0.15);
        transform: translateY(-2px);
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

    .btn-outline-primary {
        color: var(--brand-color) !important;
        border: 1px solid var(--brand-color) !important;
        transition: all 0.2s ease;
    }

    .btn-outline-primary:hover {
        background-color: var(--brand-color) !important;
        color: #fff !important;
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
    }

    /* === Summary Stats === */
    .text-brand {
        color: var(--brand-color) !important;
    }

    .card-title {
        color: var(--brand-color);
        font-weight: 600;
    }

    /* === Course Card === */
    .course-card img {
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    .course-card .badge {
        font-size: 0.75rem;
        font-weight: 500;
        padding: 0.35em 0.6em;
    }

    .course-card .card-title {
        font-weight: 600;
        color: #1e293b;
    }

    .course-card .card-text {
        color: #64748b;
    }

    .course-card .card-footer {
        background-color: #f8fafc;
        border-top: 1px solid #e2e8f0;
    }

    /* === Custom Badge Colors === */
    .badge-free {
        background-color: #22c55e !important; /* green for free */
    }

    .badge-paid {
        background-color: var(--brand-color) !important; /* brand blue for paid */
    }

    /* === Alert === */
    .alert-success {
        border-left: 4px solid var(--brand-color);
        background-color: #eff6ff;
        color: var(--brand-color);
    }

    /* === Modal === */
    .modal-content {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }

    .modal-header {
        background-color: var(--brand-color);
        color: #fff;
        border-bottom: none;
    }

    .modal-footer .btn-danger {
        background-color: #dc2626 !important;
        border-color: #dc2626 !important;
    }

    .modal-footer .btn-danger:hover {
        background-color: #b91c1c !important;
    }

    /* === Animation === */
    .container-fluid {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<!-- Summary Stats -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-bar-chart me-2"></i>Course Statistics</h5>
                <div class="row text-center mt-3">
                    <div class="col-md-3">
                        <h3 class="text-brand">{{ $courses->count() }}</h3>
                        <p class="text-muted">Total Courses</p>
                    </div>
                    <div class="col-md-3">
                        <h3 class="text-success">{{ $courses->where('status', 'active')->count() }}</h3>
                        <p class="text-muted">Active</p>
                    </div>
                    <div class="col-md-3">
                        <h3 class="text-success">{{ $courses->where('type', 'free')->count() }}</h3>
                        <p class="text-muted">Free Courses</p>
                    </div>
                    <div class="col-md-3">
                        <h3 class="text-brand">{{ $courses->where('type', 'paid')->count() }}</h3>
                        <p class="text-muted">Paid Courses</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- My Courses -->
<div class="container-fluid my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-brand"><i class="bi bi-book"></i> My Courses</h2>
        <a href="{{ route('instructor.courses.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create New Course
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($courses->isEmpty())
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                <h4 class="mt-3 text-muted">No Courses Yet</h4>
                <p class="text-muted">Start creating courses to share your knowledge with students.</p>
                <a href="{{ route('instructor.courses.create') }}" class="btn btn-primary mt-3">
                    <i class="bi bi-plus-circle"></i> Create Your First Course
                </a>
            </div>
        </div>
    @else
        <div class="row">
            @foreach($courses as $course)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm course-card">
                        @if($course->image)
                            <img src="{{ asset('uploads/courses/' . $course->image) }}" 
                                 class="card-img-top" 
                                 alt="{{ $course->title }}" 
                                 style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                 style="height: 200px;">
                                <i class="bi bi-book text-brand" style="font-size: 3rem;"></i>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge {{ $course->type === 'free' ? 'badge-free' : 'badge-paid' }} me-1">
                                    {{ ucfirst($course->type) }}
                                </span>
                                <span class="badge bg-info">{{ ucfirst($course->difficulty) }}</span>
                                <span class="badge {{ $course->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($course->status) }}
                                </span>
                            </div>

                            <h5 class="card-title">{{ Str::limit($course->title, 50) }}</h5>
                            <p class="card-text small flex-grow-1">{{ Str::limit($course->description, 100) }}</p>

                            <div class="course-meta mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">
                                        <i class="bi bi-clock"></i> {{ $course->duration ?? 'N/A' }}
                                    </span>
                                    <span class="fw-bold text-brand">
                                        @if($course->type === 'free')
                                            Free
                                        @else
                                            ৳{{ number_format($course->price, 2) }}
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-auto">
                                <a href="{{ route('instructor.courses.edit', $course->id) }}" 
                                   class="btn btn-sm btn-outline-primary flex-grow-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $course->id }}">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </div>
                        </div>

                        <div class="card-footer text-muted small">
                            <i class="bi bi-calendar"></i> Created: {{ $course->created_at->format('M d, Y') }}
                        </div>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteModal{{ $course->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i> Confirm Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete the course <strong>{{ $course->title }}</strong>? 
                                This action cannot be undone.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('instructor.courses.destroy', $course->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

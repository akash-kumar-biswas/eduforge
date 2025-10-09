@extends('layouts.instructor')

@section('title', 'My Courses')

@section('content')

<!-- Summary Stats -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Course Statistics</h5>
                        <div class="row text-center">
                            <div class="col-md-3">
                                <h3 class="text-primary">{{ $courses->count() }}</h3>
                                <p class="text-muted">Total Courses</p>
                            </div>
                            <div class="col-md-3">
                                <h3 class="text-success">{{ $courses->where('status', 'active')->count() }}</h3>
                                <p class="text-muted">Active</p>
                            </div>
                            <div class="col-md-3">
                                <h3 class="text-info">{{ $courses->where('type', 'free')->count() }}</h3>
                                <p class="text-muted">Free Courses</p>
                            </div>
                            <div class="col-md-3">
                                <h3 class="text-warning">{{ $courses->where('type', 'paid')->count() }}</h3>
                                <p class="text-muted">Paid Courses</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<div class="container-fluid my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-book"></i> My Courses</h2>
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
                            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="bi bi-book text-white" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge {{ $course->type === 'free' ? 'bg-success' : 'bg-primary' }} me-1">
                                    {{ ucfirst($course->type) }}
                                </span>
                                <span class="badge bg-info">{{ ucfirst($course->difficulty) }}</span>
                                <span class="badge {{ $course->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($course->status) }}
                                </span>
                            </div>
                            
                            <h5 class="card-title">{{ Str::limit($course->title, 50) }}</h5>
                            <p class="card-text text-muted small flex-grow-1">
                                {{ Str::limit($course->description, 100) }}
                            </p>
                            
                            <div class="course-meta mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">
                                        <i class="bi bi-clock"></i> {{ $course->duration ?? 'N/A' }}
                                    </span>
                                    <span class="fw-bold text-primary">
                                        @if($course->type === 'free')
                                            Free
                                        @else
                                            ${{ number_format($course->price, 2) }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2 mt-auto">
                                <a href="{{ route('instructor.courses.edit', $course->id) }}" 
                                   class="btn btn-sm btn-outline-primary flex-grow-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal{{ $course->id }}">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-light text-muted small">
                            <i class="bi bi-calendar"></i> Created: {{ $course->created_at->format('M d, Y') }}
                        </div>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteModal{{ $course->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirm Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete the course <strong>{{ $course->title }}</strong>? This action cannot be undone.
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

@extends('layouts.instructor')

@section('title', 'Instructor Profile')

@section('content')
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
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="bi bi-person-circle"></i> Your Profile</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center mb-4">
                            @if($instructor->image)
                                <img src="{{ asset('uploads/instructors/' . $instructor->image) }}" 
                                     alt="Profile" 
                                     class="img-fluid rounded-circle border border-3 border-primary" 
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center" 
                                     style="width: 150px; height: 150px;">
                                    <i class="bi bi-person-fill text-white" style="font-size: 4rem;"></i>
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

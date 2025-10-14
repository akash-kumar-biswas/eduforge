@extends('layouts.app')

@section('title', 'Student Profile')

@section('content')
    <style>
        /* Profile Page Responsive Styles */
        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        .profile-placeholder {
            width: 150px;
            height: 150px;
        }

        @media (max-width: 768px) {

            .profile-img,
            .profile-placeholder {
                width: 120px;
                height: 120px;
            }

            .profile-placeholder .fs-1 {
                font-size: 2.5rem !important;
            }

            .col-md-2 {
                margin-bottom: 1rem;
            }

            .col-md-7 h2 {
                font-size: 1.5rem;
                text-align: center;
            }

            .col-md-7 p {
                text-align: center;
                font-size: 0.95rem;
            }

            .col-md-3 {
                text-align: center !important;
            }

            .btn-lg {
                width: 100%;
                font-size: 1rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .card-header h5 {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .py-5 {
                padding: 2rem 0 !important;
            }

            .profile-img,
            .profile-placeholder {
                width: 100px;
                height: 100px;
            }

            .profile-placeholder .fs-1 {
                font-size: 2rem !important;
            }

            .col-md-7 h2 {
                font-size: 1.25rem;
            }

            .col-md-7 p {
                font-size: 0.9rem;
            }

            .btn-lg {
                font-size: 0.95rem;
                padding: 0.75rem 1rem;
            }

            .card-body {
                padding: 1rem;
            }

            .card-header {
                padding: 0.75rem 1rem;
            }

            .card-header h5 {
                font-size: 1rem;
            }

            .info-item label {
                font-size: 0.85rem;
            }

            .info-item p {
                font-size: 0.9rem;
            }
        }
    </style>

    <div class="container py-5">
        <!-- Profile Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center mb-3 mb-md-0">
                                <div class="profile-image-wrapper">
                                    @if($student->image)
                                        <img src="{{ asset('uploads/students/' . $student->image) }}" alt="Profile"
                                            class="img-fluid rounded-circle profile-img">
                                    @else
                                        <div
                                            class="profile-placeholder rounded-circle d-flex align-items-center justify-content-center bg-primary text-white">
                                            <span class="fs-1 fw-bold">{{ strtoupper(substr($student->name, 0, 1)) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-7">
                                <h2 class="fw-bold mb-2">{{ $student->name }}</h2>
                                <p class="text-muted mb-2"><i class="bi bi-envelope-fill me-2"></i>{{ $student->email }}</p>
                                @if($student->city || $student->country)
                                    <p class="text-muted mb-2">
                                        <i class="bi bi-geo-alt-fill me-2"></i>
                                        @if($student->city){{ $student->city }}@endif
                                        @if($student->city && $student->country), @endif
                                        @if($student->country){{ $student->country }}@endif
                                    </p>
                                @endif
                                <p class="text-muted mb-0"><i class="bi bi-calendar-fill me-2"></i>Member Since:
                                    {{ $student->created_at->format('M d, Y') }}
                                </p>
                            </div>
                            <div class="col-md-3 text-md-end mt-3 mt-md-0">
                                <a href="{{ route('student.profile.edit') }}" class="btn btn-primary btn-lg">
                                    <i class="bi bi-pencil-square me-2"></i>Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Personal Information -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-person-fill me-2"></i>Personal Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="info-item mb-3">
                            <label class="text-muted small mb-1">Full Name</label>
                            <p class="fw-semibold mb-0">{{ $student->name }}</p>
                        </div>
                        <hr>
                        <div class="info-item mb-3">
                            <label class="text-muted small mb-1">Email Address</label>
                            <p class="fw-semibold mb-0">{{ $student->email }}</p>
                        </div>
                        <hr>
                        <div class="info-item mb-3">
                            <label class="text-muted small mb-1">Phone Number</label>
                            <p class="fw-semibold mb-0">{{ $student->phone ?? 'Not set' }}</p>
                        </div>
                        <hr>
                        <div class="info-item mb-3">
                            <label class="text-muted small mb-1">Date of Birth</label>
                            <p class="fw-semibold mb-0">
                                {{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('M d, Y') : 'Not set' }}
                            </p>
                        </div>
                        <hr>
                        <div class="info-item mb-3">
                            <label class="text-muted small mb-1">Gender</label>
                            <p class="fw-semibold mb-0">{{ $student->gender ? ucfirst($student->gender) : 'Not set' }}</p>
                        </div>
                        <hr>
                        <div class="info-item mb-3">
                            <label class="text-muted small mb-1">Nationality</label>
                            <p class="fw-semibold mb-0">{{ $student->nationality ?? 'Not set' }}</p>
                        </div>
                        @if($student->bio)
                            <hr>
                            <div class="info-item">
                                <label class="text-muted small mb-1">Bio</label>
                                <p class="mb-0">{{ $student->bio }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contact & Address Information -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-geo-fill me-2"></i>Contact & Address</h5>
                    </div>
                    <div class="card-body">
                        <div class="info-item mb-3">
                            <label class="text-muted small mb-1">Address</label>
                            <p class="fw-semibold mb-0">{{ $student->address ?? 'Not set' }}</p>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item mb-3">
                                    <label class="text-muted small mb-1">City</label>
                                    <p class="fw-semibold mb-0">{{ $student->city ?? 'Not set' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item mb-3">
                                    <label class="text-muted small mb-1">State</label>
                                    <p class="fw-semibold mb-0">{{ $student->state ?? 'Not set' }}</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item mb-3">
                                    <label class="text-muted small mb-1">Postcode</label>
                                    <p class="fw-semibold mb-0">{{ $student->postcode ?? 'Not set' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item mb-3">
                                    <label class="text-muted small mb-1">Country</label>
                                    <p class="fw-semibold mb-0">{{ $student->country ?? 'Not set' }}</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="info-item">
                            <label class="text-muted small mb-1">Account Status</label>
                            <p class="mb-0">
                                @if($student->status === 'active' || $student->status === null)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .profile-image-wrapper {
            position: relative;
        }

        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 4px solid #007bff;
        }

        .profile-placeholder {
            width: 150px;
            height: 150px;
            font-size: 3rem;
            border: 4px solid #007bff;
        }

        .info-item label {
            font-weight: 600;
            color: #6c757d;
        }

        .card-header {
            padding: 1rem 1.25rem;
        }
    </style>
@endsection
@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <style>
        /* Edit Profile Page Responsive Styles */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem !important;
            }

            .card-header h3 {
                font-size: 1.3rem;
            }

            h5 {
                font-size: 1.1rem;
            }

            .form-control.w-50 {
                width: 100% !important;
            }

            #imagePreview,
            #imagePlaceholder {
                width: 120px !important;
                height: 120px !important;
            }

            #imagePlaceholder .fs-1 {
                font-size: 2.5rem !important;
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

            .card-body {
                padding: 1rem !important;
            }

            .card-header {
                padding: 0.75rem 1rem;
            }

            .card-header h3 {
                font-size: 1.1rem;
            }

            h5 {
                font-size: 1rem;
            }

            .form-label {
                font-size: 0.95rem;
            }

            .form-control,
            .form-select {
                font-size: 0.95rem;
            }

            #imagePreview,
            #imagePlaceholder {
                width: 100px !important;
                height: 100px !important;
            }

            #imagePlaceholder .fs-1 {
                font-size: 2rem !important;
            }

            .btn {
                font-size: 0.95rem;
                width: 100%;
                margin-bottom: 0.5rem;
            }

            small {
                font-size: 0.8rem;
            }
        }
    </style>

    <div id="edit-profile" class="container py-5">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Profile</h3>
                    </div>
                    <div class="card-body p-4">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Profile Image Section -->
                            <div class="mb-4 text-center">
                                <label class="form-label fw-bold">Profile Picture</label>
                                <div class="mb-3">
                                    @if($student->image)
                                        <img id="imagePreview" src="{{ asset('uploads/students/' . $student->image) }}"
                                            alt="Profile" class="rounded-circle"
                                            style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #175388ff;">
                                    @else
                                        <div id="imagePlaceholder"
                                            class="rounded-circle d-inline-flex align-items-center justify-content-center bg-primary text-white"
                                            style="width: 150px; height: 150px; border: 4px solid #175388ff;">
                                            <span class="fs-1 fw-bold">{{ strtoupper(substr($student->name, 0, 1)) }}</span>
                                        </div>
                                        <img id="imagePreview" src="" alt="Profile" class="rounded-circle d-none"
                                            style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #175388ff;">
                                    @endif
                                </div>
                                <input type="file" class="form-control w-50 mx-auto" id="image" name="image"
                                    accept="image/*" onchange="previewImage(event)">
                                <small class="text-muted">Accepted formats: JPG, PNG, GIF (Max: 2MB)</small>
                            </div>

                            <hr class="my-4">

                            <!-- Personal Information -->
                            <h5 class="mb-3 text-primary"><i class="bi bi-person-fill me-2"></i>Personal Information</h5>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Full Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name', $student->name) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email Address <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email', $student->email) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ old('phone', $student->phone) }}" placeholder="+880 1XXX-XXXXXX">
                                </div>

                                <div class="col-md-6">
                                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                        value="{{ old('date_of_birth', $student->date_of_birth) }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select" id="gender" name="gender">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $student->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="nationality" class="form-label">Nationality</label>
                                    <input type="text" class="form-control" id="nationality" name="nationality"
                                        value="{{ old('nationality', $student->nationality) }}"
                                        placeholder="e.g., Bangladeshi">
                                </div>

                                <div class="col-12">
                                    <label for="bio" class="form-label">Bio</label>
                                    <textarea class="form-control" id="bio" name="bio" rows="3"
                                        placeholder="Tell us about yourself...">{{ old('bio', $student->bio) }}</textarea>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Contact & Address Information -->
                            <h5 class="mb-3 text-primary"><i class="bi bi-geo-fill me-2"></i>Contact & Address</h5>
                            <div class="row g-3 mb-4">
                                <div class="col-12">
                                    <label for="address" class="form-label">Street Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ old('address', $student->address) }}"
                                        placeholder="House/Flat No, Street Name">
                                </div>

                                <div class="col-md-6">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" name="city"
                                        value="{{ old('city', $student->city) }}" placeholder="e.g., Dhaka">
                                </div>

                                <div class="col-md-6">
                                    <label for="state" class="form-label">State/Province</label>
                                    <input type="text" class="form-control" id="state" name="state"
                                        value="{{ old('state', $student->state) }}" placeholder="e.g., Dhaka Division">
                                </div>

                                <div class="col-md-6">
                                    <label for="postcode" class="form-label">Postcode/ZIP</label>
                                    <input type="text" class="form-control" id="postcode" name="postcode"
                                        value="{{ old('postcode', $student->postcode) }}" placeholder="e.g., 1000">
                                </div>

                                <div class="col-md-6">
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text" class="form-control" id="country" name="country"
                                        value="{{ old('country', $student->country) }}" placeholder="e.g., Bangladesh">
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Password Change -->
                            <h5 class="mb-3 text-primary"><i class="bi bi-shield-lock-fill me-2"></i>Change Password</h5>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle-fill me-2"></i>Leave password fields blank if you don't want to
                                change your password.
                            </div>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter new password">
                                    <small class="text-muted">Minimum 6 characters</small>
                                </div>

                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="Confirm new password">
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('student.profile') }}" class="btn btn-secondary px-4">
                                    <i class="bi bi-x-circle me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check-circle me-2"></i>Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('imagePlaceholder');

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    if (placeholder) {
                        placeholder.classList.add('d-none');
                    }
                }
                reader.readAsDataURL(file);
            }
        }
    </script>

    <style>
        .form-label {
            font-weight: 600;
            color: #495057;
        }

        /* Make sure this page's focus styles are the deep blue and scoped to the page */
        #edit-profile .form-control:focus,
        #edit-profile .form-select:focus {
            border-color: #175388ff;
            box-shadow: 0 0 0 0.2rem rgba(23, 83, 136, 0.25);
        }
    </style>
    <style>
        /* Page-scoped overrides: apply exact #175388ff only inside edit-profile */
        #edit-profile .card-header.bg-primary,
        #edit-profile .bg-primary {
            background-color: #175388ff !important;
            background-image: none !important;
            border-color: #175388ff !important;
            color: #fff !important;
        }

        #edit-profile .card-header.bg-primary h3,
        #edit-profile .card-header.bg-primary h3 i {
            color: #fff !important;
        }

        #edit-profile .btn-primary {
            background: linear-gradient(135deg, #175388ff 0%, #114b6eff 100%) !important;
            border-color: #175388ff !important;
            color: #fff !important;
            box-shadow: none !important;
        }

        #edit-profile .text-primary {
            color: #175388ff !important;
        }

        /* Focused form-control inside this page should use the same deep blue */
        #edit-profile .form-control:focus,
        #edit-profile .form-select:focus {
            border-color: #175388ff !important;
            box-shadow: 0 0 0 0.2rem rgba(23, 83, 136, 0.25) !important;
        }
    </style>
@endsection
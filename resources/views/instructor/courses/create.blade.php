@extends('layouts.instructor')

@section('title', 'Create New Course')

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
        display: flex;
        align-items: center;
        justify-content: space-between;
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
        background-color: var(--brand-color) !important;
        border-color: var(--brand-color) !important;
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

    /* === Form Controls === */
    .form-label {
        color: #1e293b;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--brand-color);
        box-shadow: 0 0 0 0.25rem rgba(4, 49, 122, 0.15);
    }

    /* === File Input / Image Preview === */
    .img-thumbnail {
        border: 2px solid var(--brand-color);
        border-radius: 6px;
    }

    .alert-info {
        background-color: #eff6ff;
        color: var(--brand-color);
        border-color: var(--brand-color);
    }

    /* === Text Elements === */
    .text-brand {
        color: var(--brand-color) !important;
    }

    /* === Page Container === */
    .container {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container my-4">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3><i class="bi bi-plus-circle"></i> Create New Course</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('instructor.courses.store') }}" method="POST" enctype="multipart/form-data" id="courseForm">
                        @csrf

                        <div class="row">
                            <!-- Course Title -->
                            <div class="col-md-12 mb-3">
                                <label for="title" class="form-label fw-bold">Course Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                       id="title" name="title" value="{{ old('title') }}"
                                       placeholder="e.g., Complete Web Development Bootcamp" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label fw-bold">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description" name="description" rows="5"
                                          placeholder="Provide a detailed description of your course..." required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Type and Price -->
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label fw-bold">Course Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" onchange="togglePriceField()" required>
                                    <option value="">Select Type</option>
                                    <option value="free" {{ old('type') == 'free' ? 'selected' : '' }}>Free</option>
                                    <option value="paid" {{ old('type') == 'paid' ? 'selected' : '' }}>Paid</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label fw-bold">Price ($) <span class="text-danger" id="priceRequired">*</span></label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                       id="price" name="price" value="{{ old('price', 0) }}" step="0.01" min="0" placeholder="0.00">
                                <small class="text-muted" id="priceHelp">Price will be set to ৳0 for free courses</small>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Duration and Difficulty -->
                            <div class="col-md-6 mb-3">
                                <label for="duration" class="form-label fw-bold">Duration</label>
                                <input type="text" class="form-control @error('duration') is-invalid @enderror"
                                       id="duration" name="duration" value="{{ old('duration') }}" placeholder="e.g., 8 weeks, 40 hours">
                                @error('duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="difficulty" class="form-label fw-bold">Difficulty Level <span class="text-danger">*</span></label>
                                <select class="form-select @error('difficulty') is-invalid @enderror" id="difficulty" name="difficulty" required>
                                    <option value="">Select Difficulty</option>
                                    <option value="beginner" {{ old('difficulty') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="intermediate" {{ old('difficulty') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="advanced" {{ old('difficulty') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                </select>
                                @error('difficulty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Content URL -->
                            <div class="col-md-12 mb-3">
                                <label for="content_url" class="form-label fw-bold">Content URL (Optional)</label>
                                <input type="url" class="form-control @error('content_url') is-invalid @enderror"
                                       id="content_url" name="content_url" value="{{ old('content_url') }}"
                                       placeholder="https://example.com/course-content">
                                <small class="text-muted">Link to external course materials or resources</small>
                                @error('content_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Video Upload -->
                            <div class="col-md-12 mb-3">
                                <label for="video" class="form-label fw-bold">Course Video (Optional)</label>
                                <input type="file" class="form-control @error('video') is-invalid @enderror" id="video"
                                       name="video" accept="video/*" onchange="showVideoName(event)">
                                <small class="text-muted">Upload course video: MP4, AVI, MOV, WMV, FLV, MKV (Max: 500MB)</small>
                                @error('video')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <div class="mt-2" id="videoNameDisplay" style="display: none;">
                                    <div class="alert alert-info py-2">
                                        <i class="bi bi-camera-video"></i> <span id="videoFileName"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Image Upload -->
                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label fw-bold">Course Image</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                       id="image" name="image" accept="image/*" onchange="previewImage(event)">
                                <small class="text-muted">Accepted: JPG, PNG, JPEG, GIF (Max: 2MB)</small>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <div class="mt-3" id="imagePreview" style="display: none;">
                                    <img src="" alt="Preview" id="preview" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Pending</option>
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Inactive</option>
                                    <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Active</option>
                                </select>
                                <small class="text-muted">Inactive courses won't be visible to students</small>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-4 text-end">
                            <a href="{{ route('instructor.courses') }}" class="btn btn-secondary btn-lg">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle"></i> Create Course
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle price field based on course type
    function togglePriceField() {
        const type = document.getElementById('type').value;
        const priceField = document.getElementById('price');
        const priceRequired = document.getElementById('priceRequired');
        const priceHelp = document.getElementById('priceHelp');

        if (type === 'free') {
            priceField.value = '0';
            priceField.readOnly = true;
            priceField.classList.add('bg-light');
            priceRequired.style.display = 'none';
            priceHelp.textContent = 'Price is automatically set to ৳0 for free courses';
        } else if (type === 'paid') {
            priceField.readOnly = false;
            priceField.classList.remove('bg-light');
            priceRequired.style.display = 'inline';
            priceHelp.textContent = 'Enter the course price in USD';
            if (priceField.value === '0' || priceField.value === '0.00') {
                priceField.value = '';
            }
        }
    }

    // Preview uploaded image
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }

    // Show uploaded video name
    function showVideoName(event) {
        const file = event.target.files[0];
        if (file) {
            document.getElementById('videoFileName').textContent = file.name;
            document.getElementById('videoNameDisplay').style.display = 'block';
        } else {
            document.getElementById('videoNameDisplay').style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', togglePriceField);
</script>
@endsection

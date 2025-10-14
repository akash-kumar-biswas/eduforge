@extends('layouts.app')

@section('title', $course->title)

@section('content')
    <style>
        /* Course Details Responsive Styles */
        .card-img-top {
            width: 100%;
            height: auto;
            max-height: 450px;
            object-fit: cover;
        }

        @media (max-width: 768px) {
            .card-img-top {
                max-height: 300px;
            }

            .card-title {
                font-size: 1.5rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .d-flex.gap-3 {
                flex-direction: column;
                gap: 1rem !important;
            }

            .d-flex.gap-3 h2 {
                margin-bottom: 0.5rem !important;
            }

            .badge {
                font-size: 0.85rem;
                padding: 0.4rem 0.6rem;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .card-img-top {
                max-height: 220px;
            }

            .card-title {
                font-size: 1.25rem;
            }

            .card-body {
                padding: 1rem;
            }

            .badge {
                font-size: 0.75rem;
                padding: 0.35rem 0.5rem;
                margin-bottom: 0.5rem;
            }

            .btn-lg {
                font-size: 1rem;
                padding: 0.75rem 1.5rem;
            }

            h2.text-success {
                font-size: 1.75rem;
            }
        }
    </style>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow-sm">
                    {{-- ✅ Course Image --}}
                    @if($course->image)
                        <img src="{{ asset('uploads/courses/' . $course->image) }}" class="card-img-top"
                            alt="{{ $course->title }}">
                    @else
                        <img src="{{ asset('images/default-course.jpg') }}" class="card-img-top" alt="Default Image">
                    @endif

                    <div class="card-body">
                        {{-- ✅ Title --}}
                        <h2 class="card-title fw-bold mb-3">{{ $course->title }}</h2>

                        {{-- ✅ Instructor --}}
                        <p class="text-muted mb-3">
                            @if($course->instructor)
                                Instructor: <strong>{{ $course->instructor->name }}</strong>
                            @else
                                <em>No instructor assigned</em>
                            @endif
                        </p>

                        {{-- ✅ Description --}}
                        <p class="mb-4">{{ $course->description }}</p>

                        {{-- ✅ Course Info --}}
                        <div class="mb-3">
                            <span class="badge bg-secondary">{{ ucfirst($course->difficulty ?? 'All Levels') }}</span>
                            <span class="badge bg-info text-capitalize">{{ $course->type }}</span>
                            <span class="badge bg-light text-dark">Duration: {{ $course->duration ?? 'N/A' }} hrs</span>
                            @if($course->video_path)
                                <span class="badge bg-success"><i class="bi bi-camera-video"></i> Video Included</span>
                            @endif
                        </div>

                        {{-- ✅ Price --}}
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <h2 class="text-success mb-0">
                                ৳{{ number_format($course->price, 2) }}
                            </h2> {{-- ✅ Add to Cart Button --}}
                            <form action="{{ route('cart.add', $course->id) }}" method="POST" id="addToCartForm">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg w-100" id="addToCartBtn">
                                    🛒 Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ✅ Prevent Double Form Submission --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.getElementById('addToCartForm');
                const button = document.getElementById('addToCartBtn');
                let isSubmitting = false;

                if (form && button) {
                    form.addEventListener('submit', function (e) {
                        // Prevent double submission
                        if (isSubmitting || button.disabled) {
                            e.preventDefault();
                            return false;
                        }

                        isSubmitting = true;
                        button.disabled = true;
                        button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...';
                    });
                }
            });
        </script>
@endsection
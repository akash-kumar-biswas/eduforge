@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <!-- Hero Section -->
    <section class="py-5 bg-primary text-white about-s">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">Contact Us</h1>
            <p class="lead mb-0">Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as
                possible.</p>
        </div>
    </section>

    <!-- Contact Info Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="card h-100 text-center border-0 shadow-sm">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="bi bi-geo-alt-fill text-primary fs-1"></i>
                            </div>
                            <h5 class="fw-semibold">Address</h5>
                            <p class="text-muted">123 Main Street, Dhaka-1000, Bangladesh</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 text-center border-0 shadow-sm">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="bi bi-envelope-fill text-primary fs-1"></i>
                            </div>
                            <h5 class="fw-semibold">Email</h5>
                            <p class="text-muted">contact@eduforge.com</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 text-center border-0 shadow-sm">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="bi bi-telephone-fill text-primary fs-1"></i>
                            </div>
                            <h5 class="fw-semibold">Phone</h5>
                            <p class="text-muted">+880 1234 567 890</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold text-center mb-4">Get In Touch</h2>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
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

                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" placeholder="Your name..." id="name" name="name"
                                    value="{{ old('name') }}" required />
                            </div>
                            <div class="col-lg-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="Your email..." id="email" name="email"
                                    value="{{ old('email') }}" required />
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-12">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" id="subject" name="subject" class="form-control" placeholder="Subject..."
                                    value="{{ old('subject') }}" required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="message" class="form-label">Message</label>
                                <textarea id="message" name="message" placeholder="Your message..." class="form-control"
                                    rows="5" required>{{ old('message') }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* ✅ Jumping hover effect for contact info cards */
        .card.border-0.shadow-sm {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card.border-0.shadow-sm:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15) !important;
        }

        /* ✅ Icon bounce effect on hover */
        .card.border-0.shadow-sm i {
            transition: transform 0.3s ease;
        }

        .card.border-0.shadow-sm:hover i {
            transform: scale(1.2) rotate(10deg);
        }

        /* ✅ Form input jump effect on focus */
        .form-control {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.2) !important;
        }

        /* ✅ Submit button jump effect on hover */
        .btn-primary.btn-lg {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-primary.btn-lg:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 123, 255, 0.3) !important;
        }

        /* ✅ Label animation on focus */
        .form-label {
            transition: color 0.3s ease, transform 0.3s ease;
            display: inline-block;
        }

        .form-control:focus+.form-label,
        .form-control:focus~.form-label {
            color: var(--bs-primary);
            transform: translateX(5px);
        }
    </style>
@endsection
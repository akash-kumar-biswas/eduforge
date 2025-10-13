@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <!-- Contact Info Section -->
    <section class="py-5">
        <div class="container">
            <h1 class="mb-4 fw-bold text-center">Contact Us</h1>
            <p class="text-center text-muted mb-5">Have questions? We'd love to hear from you. Send us a message and we'll
                respond as soon as possible.</p>

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
@endsection
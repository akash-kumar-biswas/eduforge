@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <style>
        /* Login Page Responsive Styles */
        @media (max-width: 768px) {
            .col-md-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            section.py-5 {
                padding: 2rem 0 !important;
            }

            h2 {
                font-size: 1.5rem;
            }

            .col-md-6 {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .form-label {
                font-size: 0.95rem;
            }

            .form-control {
                font-size: 0.95rem;
            }

            .btn {
                font-size: 0.95rem;
            }
        }
    </style>

    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h2 class="fw-bold text-center mb-4">Login to Your Account</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('student.login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                                required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary text-white fw-bold">Login</button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        Don't have an account? <a href="{{ route('student.register') }}">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
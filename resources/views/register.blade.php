@extends('appAuth')
@section('title', 'Registration')

@section('content')

<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                <div class="authincation-content">
                    <div class="auth-form p-4 shadow rounded bg-white">
                        <h4 class="text-center mb-4">Sign up your account</h4>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('register.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label><strong>Full Name</strong></label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                            </div>

                            <div class="mb-3">
                                <label><strong>Email</strong></label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            </div>

                            <div class="mb-3">
                                <label><strong>Password</strong></label>
                                <input type="password" class="form-control" name="password" required>
                            </div>

                            <div class="mb-3">
                                <label><strong>Confirm Password</strong></label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary w-100">Sign Me Up</button>
                            </div>
                        </form>

                        <div class="new-account mt-3 text-center">
                            <p>Already have an account? <a class="text-primary" href="{{ route('login') }}">Sign in</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

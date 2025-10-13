@extends('appAuth')
@section('title', 'Login')

@section('content')
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                <div class="authincation-content">
                    <div class="auth-form p-4 shadow rounded bg-white">
                        <h4 class="text-center mb-4">Login to your account</h4>

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

                        <form action="{{ route('login.submit') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label><strong>Email</strong></label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            </div>

                            <div class="mb-3">
                                <label><strong>Password</strong></label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                            </div>
                        </form>

                        <div class="new-account mt-3 text-center">
                            <p>Don’t have an account? <a class="text-primary" href="{{ route('register') }}">Sign up</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

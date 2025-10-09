<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Register - EduForge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #04317aff;
            --primary-dark: #02234f;
            --primary-light: #dbeafe;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --bg: #f8fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #f2f2f5ff 0%, #ecebedff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            width: 100%;
            max-width: 420px;
        }

        .register-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .register-header {
            padding: 40px 30px 30px;
            text-align: center;
            background: white;
            border-bottom: 1px solid var(--border);
        }

        .logo {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #110a9eff 0%, #04317aff 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .logo i {
            font-size: 28px;
            color: white;
        }

        .register-header h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .register-header p {
            color: var(--text-muted);
            font-size: 14px;
        }

        .register-body {
            padding: 30px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            border: none;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 18px;
            pointer-events: none;
        }

        .form-control {
            width: 100%;
            height: 48px;
            padding: 0 14px 0 44px;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.2s ease;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: #051661ff;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            cursor: pointer;
            font-size: 18px;
            transition: color 0.2s;
        }

        .password-toggle:hover {
            color: #667eea;
        }

        .btn-register {
            width: 100%;
            height: 48px;
            background: linear-gradient(135deg, #1d318dff 0%, #110a9eff 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 8px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .additional-links {
            margin-top: 20px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .additional-links a {
            color: var(--primary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: color 0.2s;
        }

        .additional-links a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .register-footer {
            text-align: center;
            margin-top: 30px;
            color: black;
            font-size: 15px;
        }

        .register-footer a {
            color: black;
            text-decoration: none;
            font-weight: 600;
            border-bottom: 1px solid rgba(0, 0, 0, 0.3);
            transition: border-color 0.2s;
        }

        .register-footer a:hover {
            border-bottom-color: black;
        }

        .text-danger {
            color: #dc2626;
            font-size: 13px;
            margin-top: 4px;
            display: block;
        }

        @media (max-width: 480px) {
            .register-header {
                padding: 30px 20px 20px;
            }

            .register-body {
                padding: 24px 20px;
            }

            .logo {
                width: 56px;
                height: 56px;
            }

            .logo i {
                font-size: 24px;
            }

            .register-header h1 {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-card">
            <!-- Header -->
            <div class="register-header">
                <div class="logo">
                    <i class="bi bi-person-badge"></i>
                </div>
                <h1>Join as Instructor</h1>
                <p>Create your instructor account</p>
            </div>

            <!-- Body -->
            <div class="register-body">
                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('instructor.register.submit') }}">
                    @csrf

                    <!-- Name -->
                    <div class="form-group">
                        <label class="form-label" for="name">Full Name</label>
                        <div class="input-wrapper">
                            <i class="bi bi-person-fill input-icon"></i>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter your full name" value="{{ old('name') }}" required autofocus>
                        </div>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label class="form-label" for="email">Email Address</label>
                        <div class="input-wrapper">
                            <i class="bi bi-envelope-fill input-icon"></i>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="instructor@eduforge.com" value="{{ old('email') }}" required>
                        </div>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <div class="input-wrapper">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Enter password (min 6 characters)" required>
                            <i class="bi bi-eye-fill password-toggle" id="togglePassword"></i>
                        </div>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                        <div class="input-wrapper">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Confirm your password" required>
                            <i class="bi bi-eye-fill password-toggle" id="toggleConfirmPassword"></i>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-register">
                        Create Account
                    </button>
                </form>

                <!-- Additional Links -->
                <div class="additional-links">
                    <a href="{{ route('instructor.login') }}">Already have an account? Sign in</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Password toggle for password field
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('bi-eye-fill');
            this.classList.toggle('bi-eye-slash-fill');
        });

        // Password toggle for confirm password field
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPasswordInput = document.getElementById('password_confirmation');

        toggleConfirmPassword.addEventListener('click', function () {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            this.classList.toggle('bi-eye-fill');
            this.classList.toggle('bi-eye-slash-fill');
        });
    </script>
</body>

</html>
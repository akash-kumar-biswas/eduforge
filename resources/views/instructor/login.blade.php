<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Login - EduForge</title>
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

        .login-container {
            width: 100%;
            max-width: 420px;
        }

        .login-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .login-header {
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

        .login-header h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .login-header p {
            color: var(--text-muted);
            font-size: 14px;
        }

        .login-body {
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

        .btn-login {
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

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .remember-me label {
            font-size: 14px;
            color: var(--text-dark);
            cursor: pointer;
            user-select: none;
        }

        .additional-links {
            margin-top: 20px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .additional-links p {
            color: var(--text-muted);
            font-size: 14px;
            margin: 0 0 10px 0;
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

        .additional-links .divider {
            margin: 0 8px;
            color: var(--text-muted);
        }

        .login-footer {
            text-align: center;
            margin-top: 30px;
            color: black;
            font-size: 15px;
        }

        .login-footer a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            transition: border-color 0.2s;
            color: black;
        }

        .login-footer a:hover {
            border-bottom-color: white;
        }

        @media (max-width: 480px) {
            .login-header {
                padding: 30px 20px 20px;
            }

            .login-body {
                padding: 24px 20px;
            }

            .logo {
                width: 56px;
                height: 56px;
            }

            .logo i {
                font-size: 24px;
            }

            .login-header h1 {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div class="logo">
                    <i class="bi bi-person-badge"></i>
                </div>
                <h1>EduForge Instructor</h1>
                <p>Sign in to your account</p>
            </div>

            <!-- Body -->
            <div class="login-body">
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

                <form method="POST" action="{{ route('instructor.login.submit') }}">
                    @csrf

                    <!-- Email -->
                    <div class="form-group">
                        <label class="form-label" for="email">Email Address</label>
                        <div class="input-wrapper">
                            <i class="bi bi-envelope-fill input-icon"></i>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="instructor@eduforge.com" value="{{ old('email') }}" required autofocus>
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
                                placeholder="Enter your password" required>
                            <i class="bi bi-eye-fill password-toggle" id="togglePassword"></i>
                        </div>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-login">
                        Sign In
                    </button>
                </form>

                <!-- Additional Links -->
                <div class="additional-links">
                    <p>Don't have an account? <a href="{{ route('instructor.register') }}">Create an Account</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Password toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('bi-eye-fill');
            this.classList.toggle('bi-eye-slash-fill');
        });
    </script>
</body>

</html>
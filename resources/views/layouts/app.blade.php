<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'My Website')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ✅ Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css  " rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/courses.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            background: #343a40 !important;
        }

        .navbar-brand,
        .navbar-nav .nav-link {
            color: #fff !important;
            font-weight: 500;
        }

        .navbar-nav .nav-link:hover {
            text-decoration: underline;
        }

        .navbar-brand img {
            height: 1.8rem;
        }

        .search-bar {
            max-width: 250px;
        }

        footer {
            background: #212529;
            color: #bbb;
            padding: 50px 0 20px;
        }

        footer h5 {
            color: #fff;
            margin-bottom: 20px;
        }

        footer a {
            color: #bbb;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .footer-bottom {
            border-top: 1px solid #444;
            margin-top: 30px;
            padding-top: 15px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>

<body>

    <!-- ✅ Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}"><img
                    src="{{ asset('frontend/dist/images/eduforge-white.png') }}" alt="EduForge"></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/courses') }}">Courses</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About</a></li>
                </ul>

                <!-- ✅ Search Bar -->
                <form class="d-flex me-3 search-bar" role="search">
                    <input class="form-control" type="search" placeholder="Search..." aria-label="Search">
                </form>

                <!-- ✅ Conditional Auth Buttons -->
                @if(session('student_logged_in'))
                    <div class="dropdown me-2">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" id="userMenu"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            👤 {{ session('student_name') ?? session('student_email') }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Dashboard</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="#" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="#" class="btn btn-outline-light me-2">Sign In</a>
                    <a href="#" class="btn btn-warning text-dark">Sign Up</a>
                @endif

                <a href="{{ url('/cart') }}" class="btn btn-outline-light ms-2">🛒 Cart</a>
            </div>
        </div>
    </nav>

    <!-- ✅ Flash Messages -->
    <div class="container mt-3">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <!-- ✅ Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- ✅ Footer -->
    <footer class="mt-5">
        <div class="container">
            <div class="row">
                <!-- Quick Links -->
                <div class="col-md-3 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/courses') }}">Courses</a></li>
                        <li><a href="{{ url('/about') }}">About</a></li>
                        <li><a href="{{ url('/contact') }}">Contact</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="col-md-3 mb-4">
                    <h5>Newsletter</h5>
                    <p>Subscribe to get our latest courses and offers.</p>
                    <form>
                        <input type="email" class="form-control mb-2" placeholder="Enter your email">
                        <button type="submit" class="btn btn-warning w-100">Subscribe</button>
                    </form>
                </div>

                <!-- Contact Info -->
                <div class="col-md-3 mb-4">
                    <h5>Contact Info</h5>
                    <p>📍 123 Main Street, Dhaka</p>
                    <p>📞 +880 1234 567 890</p>
                    <p>📧 contact@eduforge.com</p>
                </div>

                <!-- Social Links -->
                <div class="col-md-3 mb-4">
                    <h5>Follow Us</h5>
                    <a href="#" class="d-block">🌐 Facebook</a>
                    <a href="#" class="d-block">🐦 Twitter</a>
                    <a href="#" class="d-block">📸 Instagram</a>
                    <a href="#" class="d-block">💼 LinkedIn</a>
                </div>
            </div>

            <div class="footer-bottom">
                &copy; {{ date('Y') }} EduForge. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- ✅ Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js  "></script>
</body>

</html>
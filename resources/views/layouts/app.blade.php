<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'My Website')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ✅ Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/courses.css') }}">
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
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

        /* Fix navbar vertical alignment */
        .navbar-nav {
            margin-bottom: 0 !important;
        }

        .navbar-collapse .d-flex {
            margin-bottom: 0 !important;
        }

        @media (max-width: 991px) {
            .search-bar {
                margin-bottom: 1rem;
                margin-right: 0 !important;
            }

            .navbar-nav {
                margin-bottom: 0.75rem;
            }

            .navbar-collapse .d-flex {
                margin-top: 0.5rem;
            }
        }

        footer {
            background: #212529;
            color: #bbb;
            padding: 50px 0 20px;
        }

        footer h5 {
            color: #fff;
            margin-bottom: 20px;
            font-weight: 600;
        }

        footer a {
            color: #bbb;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: #007bff;
        }

        footer ul li {
            margin-bottom: 8px;
        }

        footer .social-icon {
            transition: all 0.3s ease;
        }

        footer .social-icon:hover {
            transform: translateY(-3px);
            background-color: #0056b3 !important;
        }

        .footer-bottom {
            border-top: 1px solid #444;
            margin-top: 30px;
            padding-top: 15px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .contact-s {
            background-color: #434548ff !important;
        }

        .about-s {
            background-color: #434548ff !important;
        }

        .browse-c {
            background-color: #434548ff !important;
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
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/courses') }}">Courses</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Contact</a></li>
                </ul>

                <!-- ✅ Search Bar -->
                <form class="d-flex me-3 search-bar" role="search" id="searchForm">
                    <input class="form-control s" type="text" id="searchInput" placeholder="Search Courses..."
                        aria-label="Search" value="{{ request('search') }}">
                </form>

                <!-- ✅ Conditional Auth Buttons -->
                <div class="d-flex align-items-center">
                    @auth('student')
                        <div class="dropdown me-2">
                            <button class="btn btn-outline-light dropdown-toggle" type="button" id="userMenu"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                👤 {{ Auth::guard('student')->user()->name ?? Auth::guard('student')->user()->email }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                <li><a class="dropdown-item" href="{{ route('student.dashboard') }}">Dashboard</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('student.logout') }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('student.login') }}" class="btn btn-outline-light me-2">Sign In</a>
                    @endauth

                    <a href="{{ url('/cart') }}" class="btn btn-outline-light ms-2">🛒 Cart</a>
                </div>
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
        @if (session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('info') }}
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

                <!-- Why Choose Us -->
                <div class="col-md-3 mb-4">
                    <h5>Why Choose Us</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Expert Instructors
                        </li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Lifetime Access</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Certificates</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>24/7 Support</li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-md-3 mb-4">
                    <h5>Contact Info</h5>
                    <p class="mb-2"><i class="bi bi-geo-alt-fill text-primary me-2"></i>123 Main Street, Dhaka-1000</p>
                    <p class="mb-2"><i class="bi bi-telephone-fill text-primary me-2"></i>+880 1234 567 890</p>
                    <p class="mb-2"><i class="bi bi-envelope-fill text-primary me-2"></i>contact@eduforge.com</p>
                </div>

                <!-- Social Links -->
                <div class="col-md-3 mb-4">
                    <h5>Follow Us</h5>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#"
                            class="social-icon text-white bg-primary rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#"
                            class="social-icon text-white bg-primary rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;" title="Twitter">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#"
                            class="social-icon text-white bg-primary rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#"
                            class="social-icon text-white bg-primary rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;" title="LinkedIn">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    </div>
                    <p class="mt-3 mb-0 small">Connect with us on social media for updates and learning tips.</p>
                </div>
            </div>

            <div class="footer-bottom">
                &copy; {{ date('Y') }} EduForge. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- ✅ Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ✅ Real-time Search Script -->
    <!-- ✅ Real-time Search Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const searchForm = document.getElementById('searchForm');

            // Store the original page URL (where the user started searching from)
            let originalPageUrl = window.location.href;

            // If we're already on courses page with search, don't override the original URL
            if (!window.location.href.includes('/courses?search=')) {
                sessionStorage.setItem('searchOriginPage', originalPageUrl);
            }

            // Prevent form submission
            if (searchForm) {
                searchForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                });
            }

            if (searchInput) {
                let searchTimeout;

                searchInput.addEventListener('input', function () {
                    clearTimeout(searchTimeout);

                    const searchTerm = this.value.trim();

                    // Debounce: wait 300ms after user stops typing
                    searchTimeout = setTimeout(function () {
                        if (searchTerm.length > 0) {
                            // Redirect to courses page with search parameter
                            window.location.href = '{{ route("courses.index") }}?search=' + encodeURIComponent(searchTerm);
                        } else {
                            // If search is cleared, go back to original page
                            const returnUrl = sessionStorage.getItem('searchOriginPage') || '{{ route("courses.index") }}';
                            sessionStorage.removeItem('searchOriginPage'); // Clean up
                            window.location.href = returnUrl;
                        }
                    }, 300);
                });
            }
        });
    </script>
</body>

</html>
```
</body>

</html>
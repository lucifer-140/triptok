<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TripTock - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap" rel="stylesheet">

    <style>
        html, body {
            height: 100%;  /* Make sure the body and html elements take up the full height of the viewport */
            margin: 0;     /* Remove default margin */
            display: flex;
            flex-direction: column;
        }

        .container {
            flex: 1;  /* This ensures that the main content takes up all available space */
        }
        body {
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .nav-link {
            font-size: 1.1rem;
            text-decoration: none;
            color: #343a40;
            transition: color 0.3s ease, transform 0.3s ease, text-decoration 0.3s ease;
        }

        .nav-link.active {
            color: #007bff;
            font-weight: bold;
        }

        .nav-link:hover {
            color: #007bff;
            text-decoration: underline;
            transform: scale(1.05);
        }

        .navbar-nav .nav-item + .nav-item {
            margin-left: 20px;
        }


        footer {
            background-color: #f8f9fa;
            /* padding: 3rem 0; */
            border-top: 1px solid #e0e0e0;
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: auto;
        }

        footer .footer-logo {
            width: 120px;
            margin-bottom: 1rem;
        }

        footer .footer-links {
            list-style: none;
            padding: 0;
        }

        footer .footer-links li {
            display: inline;
            margin: 0 15px;
        }

        footer .footer-links a {
            color: #6c757d;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer .footer-links a:hover {
            color: #007bff;
        }

        footer .social-icons a {
            margin: 0 10px;
            color: #6c757d;
            font-size: 1.5rem;
            transition: color 0.3s ease;
        }

        footer .social-icons a:hover {
            color: #007bff;
        }

        footer .footer-bottom {
            text-align: center;
            font-size: 0.8rem;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            .page-heading {
                font-size: 2rem;
            }
            footer .footer-links li {
                display: block;
                text-align: center;
                margin-bottom: 10px;
            }
        }

        /* Loading screen styling */
        #loadingScreen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            visibility: hidden;
            opacity: 0;
            transition: visibility 0.3s, opacity 0.3s;
        }

        #loadingScreen.active {
            visibility: visible;
            opacity: 1;
        }

        .dots {
            display: inline-block;
            animation: blink 1.5s infinite steps(1);
        }

        .dots:nth-child(1) {
            animation-delay: 0s;
        }

        .dots:nth-child(2) {
            animation-delay: 0.3s;
        }

        .dots:nth-child(3) {
            animation-delay: 0.6s;
        }

        /* Create the blinking dots animation */
        @keyframes blink {
            0%, 100% {
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <!-- Loading Screen -->
    <div id="loadingScreen" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8);
        z-index: 9999; display: flex; align-items: center; justify-content: center; flex-direction: column;
        backdrop-filter: blur(10px); /* Blur background */">
        <div class="d-flex flex-column align-items-center">
            <!-- Logo -->
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="logo-img mt-3" style="max-height: 100px; width: auto;">

            <!-- Loading Text with Animated Ellipsis -->
            <p class="mt-3 loading-text" style="font-size: 1.2rem; color: #333;">
                Loading, please wait
                <span class="dots">.</span><span class="dots">.</span><span class="dots">.</span>
            </p>
        </div>
    </div>

    <header class="py-3 mb-3 border-bottom">
        <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr;">
            <div class="d-none d-md-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="{{ url('/') }}" class="link-body-emphasis text-decoration-none">
                        <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="logo-img me-3" style="max-height: 70px; width: auto;">
                        <span class="fs-4">TripTock</span>
                    </a>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <a href="{{ url('/') }}" class="link-body-emphasis text-decoration-none">Home</a>
                    {{-- <a href="#" class="link-body-emphasis text-decoration-none">Destinations</a> --}}
                    <a href="{{ route('signin') }}" class="link-body-emphasis text-decoration-none">Login</a>
                    <a href="{{ route('signup') }}" class="link-body-emphasis text-decoration-none btn btn-primary text-white">Register</a>
                </div>
            </div>

            <div class="d-md-none">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="logo-img me-3" style="max-height: 70px; width: auto;">
                        <span class="fs-4">TripTock</span>
                    </a>
                    <ul class="dropdown-menu text-small shadow">
                        <li><a class="dropdown-item" href="{{ url('/') }}" aria-current="page">Home</a></li>
                        {{-- <li><a class="dropdown-item" href="#">Destinations</a></li> --}}
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('signin') }}">Login</a></li>
                        <li><a class="dropdown-item" href="{{ route('signup') }}">Register</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <div class="container mt-5">
        @yield('content')
    </div>

    <!-- Footer Section -->
    <footer>
        <div class="container text-center">
            <div>
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="footer-logo">
            </div>
            <div>
                <ul class="footer-links">
                    <li><a href="{{ route('about') }}" class="text-decoration-none text-muted">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="text-decoration-none text-muted">Contact</a></li>
                    <li><a href="{{ route('privacy') }}" class="text-decoration-none text-muted">Privacy Policy</a></li>
                    <li><a href="{{ route('terms') }}" class="text-decoration-none text-muted">Terms of Service</a></li>
                    <li><a href="{{ route('help') }}" class="text-decoration-none text-muted">Help</a></li>
                </ul>
            </div>
            <div class="social-icons">
                <a href="#" target="_blank" class="bi bi-facebook"></a>
                <a href="#" target="_blank" class="bi bi-twitter"></a>
                <a href="#" target="_blank" class="bi bi-instagram"></a>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 TripTock.    All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loadingScreen = document.getElementById('loadingScreen');

            // Show loading screen during form submissions
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function () {
                    loadingScreen.classList.add('active');
                });
            });

            // Show loading screen when links are clicked
            document.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', function (e) {
                    const href = link.getAttribute('href');

                    // Skip anchor-only links and links with data-no-loader
                    if (href && href !== '#' && !link.hasAttribute('data-no-loader')) {
                        loadingScreen.classList.add('active');
                    }
                });
            });

            // Hide the loading screen once the page fully loads
            window.addEventListener('load', function () {
                loadingScreen.classList.remove('active');
            });

            // Handle browser back/forward button to hide the loading screen
            window.addEventListener('pageshow', function (event) {
                if (event.persisted) {
                    loadingScreen.classList.remove('active');
                }
            });
        });

        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js')
                .then(function(registration) {
                    console.log('Service Worker registered with scope:', registration.scope);
                })
                .catch(function(error) {
                    console.log('Service Worker registration failed:', error);
                });
        }
    </script>

    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>

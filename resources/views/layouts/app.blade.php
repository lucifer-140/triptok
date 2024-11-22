<!DOCTYPE html>
<html lang="en-GB">
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
        /* Custom font */
        body {
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* Navbar Links Styling */
        .nav-link {
            font-size: 1.1rem;
            text-decoration: none; /* No underline by default */
            color: #343a40;
            transition: color 0.3s ease, transform 0.3s ease, text-decoration 0.3s ease;
        }

        /* Active link and hover effect */
        .nav-link.active {
            color: #007bff;
            font-weight: bold;
        }

        .nav-link:hover {
            color: #007bff;
            text-decoration: underline; /* Underline on hover */
            transform: scale(1.05);
        }

        .navbar-nav .nav-item + .nav-item {
            margin-left: 20px;
        }

        /* Page Heading Styling */
        .page-heading {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: #343a40;
            margin-bottom: 30px;
            position: relative;
        }

        /* Line below the heading */
        .page-heading:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background-color: #007bff;
        }
        /* Profile Image Styling */
        .profile-img {
            width: 50px;  /* Increase the size */
            height: 50px; /* Ensure the height matches the width for a circle */
            object-fit: cover; /* Ensure the image maintains aspect ratio and doesn't stretch */
            border: 2px solid #a0a0a0;  /* Optional: Add a border to match the notification icon style */
        }

        /* Notification Icon Container */
        .notification {
            position: relative;
            display: inline-block;
            font-size: 2rem;  /* Icon size */
        }

        /* Icon Styling (Bell Icon) */
        .notification-icon {
            font-size: 2rem; /* Adjust size as needed */
        }

        /* Badge Styling */
        .notification .badge {
            position: absolute;
            top: -5px;  /* Move the badge a little closer to the icon */
            right: -5px;  /* Move the badge a little closer to the icon */
            padding: 5px 10px;
            border-radius: 50%;
            background-color: red;
            color: white;
            font-size: 0.75rem;  /* Adjust the size of the badge number */
        }

        /* Hover effect on notification */
        .notification:hover .badge {
            background: darkred;
        }

        .dropdown-toggle::after {
            display: none;
        }

        /* Footer Styling */
        footer {
            background-color: #f8f9fa;
            padding: 3rem 0;
            border-top: 1px solid #e0e0e0;
            color: #6c757d;
            font-size: 0.9rem;
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

        header.sticky-top {
            z-index: 1030; /* Higher value to ensure it stays on top */
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


    <header class="py-3 mb-3 border-bottom sticky-top" style="background-color: #ffffff;">
        <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr;">
            <!-- Navbar content -->
            <div class="d-none d-md-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="{{ url('/user/home') }}" class="link-body-emphasis text-decoration-none">
                        <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="logo-img me-3" style="max-height: 70px; width: auto;">
                        <span class="fs-4">TripTock</span>
                    </a>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <a href="{{ url('/user/home') }}" class="link-body-emphasis text-decoration-none">Home</a>
                    <a href="{{ url('/trip/list') }}" class="link-body-emphasis text-decoration-none">Trips</a>
                    <a href="{{ url('/travel/travel-guide') }}" class="link-body-emphasis text-decoration-none">Travel Guide</a>
                    <a href="{{ url('/user/notifications') }}" class="notification link-body-emphasis text-decoration-none" aria-label="Notifications">
                        <i class="bi bi-bell notification-icon"></i>
                        @if ($receivedRequestsCount > 0 || $sharedTripsCount > 0)
                            <span class="badge">{{ $receivedRequestsCount + $sharedTripsCount }}</span>
                        @endif
                    </a>
                    <div class="dropdown">
                        <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img
                                src="{{ Auth::user()->profile_image ? Storage::url('public/' . Auth::user()->profile_image) : asset('assets/blankprofilepic.jpeg') }}"
                                alt="Profile Picture"
                                class="rounded-circle"
                                style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #a0a0a0;">
                        </a>
                        <ul class="dropdown-menu text-small shadow">
                            <li><span class="dropdown-item text-muted">Hello, {{ Auth::user()->first_name }}</span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ url('/user/profile') }}">Profile</a></li>
                            <li><a class="dropdown-item" href="{{ url('/user/friends') }}">Friends</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>


            <!-- Mobile/Small Screens (Below Medium Screens) -->
            <div class="d-md-none">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="logo-img me-3" style="max-height: 70px; width: auto;">
                        <span class="fs-4">TripTock</span>
                    </a>
                    <ul class="dropdown-menu text-small shadow">
                        <li><span class="dropdown-item text-muted">Hello, {{ Auth::user()->first_name }}</span></li>
                        <li><hr class="dropdown-divider"></li>
                        <!-- Navigation Links for Mobile -->
                        <li><a class="dropdown-item" href="{{ url('/user/home') }}" aria-current="page">Home</a></li>
                        <li><a class="dropdown-item" href="{{ url('/trip/list') }}">Trips</a></li>
                        <li><a class="dropdown-item" href="{{ url('/travel/travel-guide') }}">Travel Guide</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <!-- Profile and Sign Out Options (Visible Only on Mobile) -->
                        <li><a class="dropdown-item" href="{{ url('/user/profile') }}">Profile</a></li>
                        <li><a class="dropdown-item" href="{{ url('/user/friends') }}">Friends</a></li>
                        <li>
                            <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ url('/user/notifications') }}">
                                Notifications
                                @if ($receivedRequestsCount > 0 || $sharedTripsCount > 0)
                                    <!-- Notification badge -->
                                    <span class="badge bg-danger rounded-pill ms-2">
                                        {{ $receivedRequestsCount + $sharedTripsCount }}
                                    </span>
                                @endif
                            </a>
                        </li>

                        <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a></li>
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
                <li><a href="{{ url('/about') }}" class="text-decoration-none text-muted">About Us</a></li>
                <li><a href="{{ url('/contact') }}" class="text-decoration-none text-muted">Contact</a></li>
                <li><a href="{{ url('/privacy-policy') }}" class="text-decoration-none text-muted">Privacy Policy</a></li>
                <li><a href="{{ url('/terms-of-service') }}" class="text-decoration-none text-muted">Terms of Service</a></li>
                <li><a href="{{ url('/help') }}" class="text-decoration-none text-muted">Help</a></li>
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

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

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

                // Ensure it is not an anchor-only link
                if (href && href !== '#' && !link.hasAttribute('data-no-loader')) {
                    loadingScreen.classList.add('active');
                }
            });
        });

        // Hide the loading screen once the page fully loads
        window.addEventListener('load', function () {
            loadingScreen.classList.remove('active');
        });
    });

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
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<!-- Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>

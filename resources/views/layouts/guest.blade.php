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

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap" rel="stylesheet">

    <style>
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
    </style>
</head>
<body>

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
                    <a href="#" class="link-body-emphasis text-decoration-none">Destinations</a>
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
                        <li><a class="dropdown-item" href="#">Destinations</a></li>
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

    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>

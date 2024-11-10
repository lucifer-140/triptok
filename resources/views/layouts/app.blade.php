<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TripTock - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Modern Fonts (Google Fonts) -->
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

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
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

        @media (max-width: 768px) {
            .page-heading {
                font-size: 2rem;
            }
        }

    </style>

</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/user/home') }}">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="logo-img" style="max-height: 40px;">
            TripTock
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ url('/user/home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/trip/list') }}">Trips</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Destinations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/user/profile') }}">Account</a>
                </li>
                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container mt-5">
    @yield('content')
</div>

<!-- Bootstrap JS and dependencies -->
<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>

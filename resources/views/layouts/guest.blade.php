<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TripTock - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Google Fonts (Modern Fonts) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap" rel="stylesheet">

    <style>
        /* Use a modern, clean font */
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.6rem;
        }

        .nav-link {
            font-size: 1.1rem;
            color: #343a40;
            text-decoration: none; /* No underline by default */
            transition: color 0.3s ease, transform 0.3s ease, text-decoration 0.3s ease;
        }

        .nav-link:hover {
            color: #007bff;
            text-decoration: underline; /* Underline only on hover */
            transform: scale(1.05);
        }

        .navbar-nav .nav-item + .nav-item {
            margin-left: 20px;
        }

        /* Consistent button style for login/register */
        .nav-link.btn-link {
            font-weight: 600;
            color: #007bff;
        }

        .nav-link.btn-link:hover {
            text-decoration: underline; /* Underline on hover only */
            color: #0056b3;
        }

        /* Container */
        .container {
            margin-top: 60px;
        }

        /* Heading Styles for Content */
        .content-heading {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: #343a40;
            margin-bottom: 30px;
        }

        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.4rem;
            }
            .nav-link {
                font-size: 1rem;
            }
            .content-heading {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="logo-img" style="max-height: 40px;">
                TripTock
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Destinations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-link" href="{{ route('signin') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-link" href="{{ route('signup') }}">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        @yield('content')
    </div>

    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>

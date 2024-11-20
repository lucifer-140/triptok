<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - TripTock</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        .error-message {
            color: red;
            font-size: 0.9em;
        }

        .required:after {
            content: ' *';
            color: red;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 30px;
        }

        .text-center h4 {
            font-size: 2rem;
            font-weight: 700;
            color: #343a40;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
        }

        .form-control {
            border-radius: 8px;
            padding: 10px;
            font-size: 1rem;
        }

        .text-center a {
            color: #007bff;
            text-decoration: none;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        .container {
            margin-top: 60px;
        }

        /* Loading screen styles */
        #loadingScreen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            backdrop-filter: blur(10px);
        }

        .loading-text {
            font-size: 1.2rem;
            color: #333;
        }

        @media (max-width: 768px) {
            .container {
                margin-top: 20px;
            }

            .card-body {
                padding: 20px;
            }

            .text-center h4 {
                font-size: 1.5rem;
            }
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
<body class="bg-light">
    <!-- Loading Screen -->
    <div id="loadingScreen">
        <div class="d-flex flex-column align-items-center">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="logo-img mt-3" style="max-height: 100px; width: auto;">
            <p class="mt-3 loading-text">
                Loading, please wait<span class="dots">.</span><span class="dots">.</span><span class="dots">.</span>
            </p>
        </div>
    </div>


    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow" style="width: 400px;">
            <div class="card-body">
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/logo.png') }}" alt="TripTock Logo" class="mb-3" style="width: 100px;">
                    <h4>Create Account</h4>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('signup.submit') }}" method="POST" id="signupForm">
                    @csrf
                    <div class="mb-3">
                        <label for="first_name" class="form-label required">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" maxlength="50"
                               value="{{ old('first_name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label required">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" maxlength="50"
                               value="{{ old('last_name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label required">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" maxlength="15"
                               value="{{ old('phone') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label required">Email</label>
                        <input type="email" class="form-control" id="email" name="email" maxlength="100"
                               value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label required">Password</label>
                        <input type="password" class="form-control" id="password" name="password" minlength="8" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label required">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="password_confirmation" required>
                    </div>

                    <div class="mb-3 show-password-container">
                        <input type="checkbox" id="showPassword">
                        <label for="showPassword">Show Password</label>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Sign Up</button>
                </form>

                <div class="text-center mt-3">
                    <p>Already have an account? <a href="{{ route('signin') }}">Sign In</a></p>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ url('/') }}" class="btn btn-link">Back to Home</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const signupForm = document.getElementById('signupForm');
            const loadingScreen = document.getElementById('loadingScreen');

            signupForm.addEventListener('submit', function () {
                // Show the loading screen when the form is submitted
                loadingScreen.style.display = 'flex';
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            const showPasswordCheckbox = document.getElementById('showPassword');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirm_password');

            // Toggle the password visibility when the checkbox is clicked
            showPasswordCheckbox.addEventListener('change', function () {
                if (showPasswordCheckbox.checked) {
                    passwordInput.type = 'text';  // Show password
                    confirmPasswordInput.type = 'text'; // Show confirm password
                } else {
                    passwordInput.type = 'password';  // Hide password
                    confirmPasswordInput.type = 'password'; // Hide confirm password
                }
            });

            const signupForm = document.getElementById('signupForm');
            const loadingScreen = document.getElementById('loadingScreen');

            signupForm.addEventListener('submit', function () {
                // Show the loading screen when the form is submitted
                loadingScreen.style.display = 'flex';
            });
        });
    </script>
</body>
</html>

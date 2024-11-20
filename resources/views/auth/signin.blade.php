<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - TripTock</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
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

        .error-message {
            color: red;
            font-size: 0.9em;
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
                    <h4>Sign In</h4>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('post.signin') }}" method="POST" id="signinForm">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <div class="error-message">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        @if ($errors->has('password'))
                            <div class="error-message">{{ $errors->first('password') }}</div>
                        @endif
                    </div>
                    <div class="mb-3 show-password-container">
                        <input type="checkbox" id="showPassword">
                        <label for="showPassword">Show Password</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                </form>

                <div class="text-center mt-3">
                    <p><a href="{{ route('password.request') }}">Forgot Your Password?</a></p>
                </div>

                <div class="text-center mt-3">
                    <p>Don't have an account? <a href="{{ route('signup') }}">Sign Up</a></p>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ url('/') }}" class="btn btn-link">Back to Home</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const signinForm = document.getElementById('signinForm');
            const loadingScreen = document.getElementById('loadingScreen');

            signinForm.addEventListener('submit', function () {
                // Show the loading screen
                loadingScreen.style.display = 'flex';
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            const showPasswordCheckbox = document.getElementById('showPassword');
            const passwordInput = document.getElementById('password');

            // Toggle the password visibility when the checkbox is clicked
            showPasswordCheckbox.addEventListener('change', function () {
                if (showPasswordCheckbox.checked) {
                    passwordInput.type = 'text';  // Show password
                } else {
                    passwordInput.type = 'password';  // Hide password
                }
            });

            const signinForm = document.getElementById('signinForm');
            const loadingScreen = document.getElementById('loadingScreen');

            signinForm.addEventListener('submit', function () {
                // Show the loading screen
                loadingScreen.style.display = 'flex';
            });
        });
    </script>
</body>
</html>

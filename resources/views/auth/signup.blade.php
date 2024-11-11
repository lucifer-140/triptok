<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - TripTock</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .error-message {
            color: red;
            font-size: 0.9em;
        }
        .required:after {
            content: ' *';
            color: red;
        }
        /* Use a modern, clean font */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa; /* Light background */
        }

        /* Card Styling */
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

        /* Input field styles */
        .form-label {
            font-weight: 600;
        }

        .form-control {
            border-radius: 8px;
            padding: 10px;
            font-size: 1rem;
        }


        /* Link Styling */
        .text-center a {
            color: #007bff;
            text-decoration: none;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        /* Container styling */
        .container {
            margin-top: 60px;
        }

        /* Responsive design */
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
    </style>
</head>
<body class="bg-light">
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
                        <input type="text" class="form-control" id="first_name" name="first_name" maxlength="50" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label required">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" maxlength="50" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label required">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" maxlength="15" required>
                        <div class="error-message" id="phoneError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label required">Email</label>
                        <input type="email" class="form-control" id="email" name="email" maxlength="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label required">Password</label>
                        <input type="password" class="form-control" id="password" name="password" minlength="8" required>
                        <div class="error-message" id="passwordError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label required">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="password_confirmation" required>
                        <div class="error-message" id="confirmPasswordError"></div>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Sign Up</button>
                </form>
                <div class="text-center mt-3">
                    <p>Already have an account? <a href="{{ route('signin') }}">Sign In</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const phoneInput = document.getElementById('phone');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirm_password');

            // Phone validation
            phoneInput.addEventListener('input', function () {
                const phoneError = document.getElementById('phoneError');
                if (phoneInput.value.length > 15) {
                    phoneError.textContent = "Phone number can't be longer than 15 characters.";
                } else {
                    phoneError.textContent = "";
                }
            });

            // Password length validation
            passwordInput.addEventListener('input', function () {
                const passwordError = document.getElementById('passwordError');
                if (passwordInput.value.length < 8) {
                    passwordError.textContent = "Password must be at least 8 characters long.";
                } else {
                    passwordError.textContent = "";
                }
            });

            // Confirm password match validation
            confirmPasswordInput.addEventListener('input', function () {
                const confirmPasswordError = document.getElementById('confirmPasswordError');
                if (confirmPasswordInput.value !== passwordInput.value) {
                    confirmPasswordError.textContent = "Passwords do not match.";
                } else {
                    confirmPasswordError.textContent = "";
                }
            });

            // Prevent form submission if there are validation errors
            document.getElementById('signupForm').addEventListener('submit', function (e) {
                if (phoneInput.value.length > 15 || passwordInput.value.length < 8 || confirmPasswordInput.value !== passwordInput.value) {
                    e.preventDefault(); // Stop form submission
                }
            });
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - TripTock</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .error-message {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow" style="width: 400px;">
            <div class="card-body">
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/logo.png') }}" alt="TripTock Logo" class="mb-3" style="width: 100px;">
                    <h4>Sign In</h4>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('post.signin') }}" method="POST" id="signinForm">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="error-message" id="emailError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="error-message" id="passwordError"></div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                </form>
                <div class="text-center mt-3">
                    <p>Don't have an account? <a href="{{ route('signup') }}">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');

            // Email validation
            emailInput.addEventListener('input', function () {
                const emailError = document.getElementById('emailError');
                const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                if (!emailPattern.test(emailInput.value)) {
                    emailError.textContent = "Please enter a valid email address.";
                } else {
                    emailError.textContent = "";
                }
            });

            // Password required validation
            passwordInput.addEventListener('input', function () {
                const passwordError = document.getElementById('passwordError');
                if (passwordInput.value.trim() === "") {
                    passwordError.textContent = "Password is required.";
                } else {
                    passwordError.textContent = "";
                }
            });

            // Prevent form submission if there are validation errors
            document.getElementById('signinForm').addEventListener('submit', function (e) {
                if (!emailInput.value.match(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/) || passwordInput.value.trim() === "") {
                    e.preventDefault(); // Stop form submission
                }
            });
        });
    </script>
</body>
</html>

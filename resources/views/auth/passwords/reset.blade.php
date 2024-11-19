<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - TripTock</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<style>
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

    .error-message {
        color: red;
        font-size: 0.9em;
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

    /* Loading spinner */
    .spinner-border {
        display: none;
        width: 3rem;
        height: 3rem;
        border-width: 0.25em;
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
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow" style="width: 400px;">
            <div class="card-header text-center">
                <h4>{{ __('Reset Password') }}</h4>
            </div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" id="successMessage" style="display: none;">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" id="resetPasswordForm">
                    @csrf

                    <div class="form-group">
                        <label for="email">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group text-center mt-3">
                        <button type="submit" class="btn btn-primary w-100" id="submitButton">{{ __('Send Password Reset Link') }}</button>
                        <div class="spinner-border text-primary" id="loadingSpinner" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.getElementById('resetPasswordForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting immediately

            // Show the loading spinner and hide the submit button
            document.getElementById('loadingSpinner').style.display = 'inline-block';
            document.getElementById('submitButton').disabled = true;

            // Simulate a form submission process (you can remove this if using real backend logic)
            setTimeout(function() {
                // Hide the spinner and show the success message
                document.getElementById('loadingSpinner').style.display = 'none';
                document.getElementById('successMessage').style.display = 'block';

                // Optionally reset the form or handle further UI updates here
                // document.getElementById('resetPasswordForm').reset();
            }, 2000); // Simulate a 2-second delay (you can adjust this as needed)
        });
    </script>
</body>
</html>

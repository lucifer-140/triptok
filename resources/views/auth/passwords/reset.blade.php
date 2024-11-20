<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - TripTock</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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

        /* Loading Screen */
        #loadingScreen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            backdrop-filter: blur(10px);
            display: none;
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
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" style="max-height: 100px; width: auto;">
            <p class="mt-3" style="font-size: 1.2rem; color: #333;">
                Processing<span class="dots">.</span><span class="dots">.</span><span class="dots">.</span>
            </p>
        </div>
    </div>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow" style="width: 400px;">
            <div class="card-header text-center">
                <h4>{{ __('Reset Password') }}</h4>
            </div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success">
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
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.getElementById('resetPasswordForm').addEventListener('submit', function (event) {
            // Show the loading screen and disable the button
            document.getElementById('loadingScreen').style.display = 'flex';
            document.getElementById('submitButton').disabled = true;
        });
    </script>
</body>
</html>

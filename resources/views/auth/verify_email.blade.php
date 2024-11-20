<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - TripTock</title>
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

        .card-header h4 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #343a40;
        }

        .error-message {
            color: red;
            font-size: 0.9em;
        }

        .form-control {
            border-radius: 8px;
            padding: 10px;
            font-size: 1rem;
        }

        .container {
            margin-top: 60px;
        }

        .text-center a {
            color: #007bff;
            text-decoration: none;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                margin-top: 20px;
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
    <div id="loadingScreen" style="display: none;">
        <div class="d-flex flex-column align-items-center">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="logo-img mt-3" style="max-height: 100px; width: auto;">
            <p class="mt-3 loading-text" style="font-size: 1.2rem; color: #333;">
                Loading, please wait<span class="dots">.</span><span class="dots">.</span><span class="dots">.</span>
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow" style="width: 400px;">
            <div class="card-header text-center">
                <h4>Email Verification</h4>
            </div>
            <div class="card-body">
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('verify-email.post') }}" method="POST" onsubmit="showLoadingScreen()">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="code" class="form-label">Verification Code</label>
                        <input type="text" id="code" name="code" class="form-control" required maxlength="6">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-100">Verify Email</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showLoadingScreen() {
            document.getElementById('loadingScreen').style.display = 'flex';
        }
    </script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>

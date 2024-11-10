@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Profile Card -->
            <div class="card p-4 shadow">
                <div class="text-center">
                    <!-- Profile Image -->
                    <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('assets/blankprofilepic.jpeg') }}" alt="Profile Image" class="profile-img">
                    <p></p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-warning">Edit Profile</a>

                </div>

                <!-- Personal Information Section -->
                <div class="mt-4">
                    <h5 class="section-title">Personal Information</h5>
                    <hr>
                    <div class="info-item">
                        <label>First Name:</label>
                        <span>{{ Auth::user()->first_name }}</span>
                    </div>
                    <div class="info-item">
                        <label>Last Name:</label>
                        <span>{{ Auth::user()->last_name }}</span>
                    </div>
                    <div class="info-item">
                        <label>Email:</label>
                        <span>{{ Auth::user()->email }}</span>
                    </div>
                    <div class="info-item">
                        <label>Phone Number:</label>
                        <span>{{ Auth::user()->phone_number ?? 'Not provided' }}</span>
                    </div>
                </div>

                <!-- Account Actions Section -->
                <div class="mt-4">
                    <hr>
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-outline-primary btn-action">View My Trips</a>
                        <a href="#" class="btn btn-outline-info btn-action">Friend lists</a>
                        <a href="#" class="btn btn-danger btn-action" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign Out</a>

                        <!-- Logout Form -->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    /* Profile Image Styling */
    .profile-img {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        object-fit: cover;
        margin: 20px auto;
    }

    /* Card Styling */
    .card {
        border-radius: 12px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
    }

    /* Edit Button */
    .btn-edit {
        background-color: #ffc107;
        border: none;
        color: white;
        padding: 8px 20px;
        border-radius: 25px;
    }

    .btn-edit:hover {
        background-color: #ffca2c;
    }

    /* Personal Information Section */
    .section-title {
        font-size: 1.25rem;
        font-weight: bold;
        color: #495057;
        margin-bottom: 10px;
        text-align: center;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        color: #495057;
        border-bottom: 1px solid #ddd;
    }

    .info-item label {
        font-weight: 600;
    }

    .info-item span {
        font-weight: 400;
        color: #555;
    }

    /* Account Actions Section */
    .btn-action {
        border-radius: 8px;
        padding: 10px;
        font-weight: bold;
        margin: 5px 0;
        transition: all 0.3s ease;
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
    }

    .btn-outline-primary {
        border: 2px solid #007bff;
        color: #007bff;
    }

    .btn-outline-primary:hover {
        background-color: #007bff;
        color: white;
    }

    .btn-outline-secondary {
        border: 2px solid #6c757d;
        color: #6c757d;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }
</style>

@endsection


@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Profile Card -->
            <div class="card p-4 shadow">
                <div class="text-center">
                    <!-- Profile Image -->
                    <img src="{{ asset('assets/blankprofilepic.jpeg') }}" alt="Profile Image" class="profile-img">
                    <h3>John Doe</h3>
                    <p class="text-muted">Traveler</p>
                    <a href="" class="btn btn-edit">Edit Profile</a>
                </div>

                <!-- Personal Information Section -->
                <div class="mt-4">
                    <h5 class="section-title">Personal Information</h5>
                    <hr>
                    <div class="info-item">
                        <label>First Name:</label>
                        <span>John</span>
                    </div>
                    <div class="info-item">
                        <label>Last Name:</label>
                        <span>Doe</span>
                    </div>
                    <div class="info-item">
                        <label>Email:</label>
                        <span>john.doe@example.com</span>
                    </div>
                    <div class="info-item">
                        <label>Phone Number:</label>
                        <span>+1234567890</span>
                    </div>
                </div>

                <!-- Account Actions Section -->
                <div class="mt-4">
                    <h5 class="section-title">Account Settings</h5>
                    <hr>
                    <div class="d-grid gap-2">
                        <a href="" class="btn btn-outline-primary btn-action">View My Trips</a>
                        <a href="" class="btn btn-outline-secondary btn-action">Account Settings</a>
                        <a href="" class="btn btn-danger btn-action">Sign Out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<style>
    /* Navbar Styling */
    .navbar {
        background-color: #f8f9fa;
    }
    
    /* Profile Image Style */
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
    }

    /* Edit Button */
    .btn-edit {
        background-color: #ffc107;
        border: none;
        color: white;
        padding: 8px 20px;
    }

    .btn-edit:hover {
        background-color: #ffca2c;
    }

    /* Personal Information and Settings */
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
    }

    /* Account Actions */
    .btn-action {
        border-radius: 8px;
        padding: 10px;
        font-weight: bold;
        margin: 5px 0;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
    }
</style>

@endsection

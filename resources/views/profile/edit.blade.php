@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Edit Profile Card -->
            <div class="card p-4 shadow">
                <div class="text-center">
                    <!-- Profile Image Button -->
                    <img id="profileImagePreview" src="{{ asset('assets/blankprofilepic.jpeg') }}" alt="Profile Image" class="profile-img" onclick="document.getElementById('profileImageInput').click()">
                    <input type="file" id="profileImageInput" class="d-none" accept="image/*">
                    <p class="text-muted mt-2">Click on the image to upload a new photo</p>
                </div>

                <form action="#" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Personal Information Section -->
                    <div class="mt-4">
                        <h5 class="section-title">Personal Information</h5>
                        <hr>
                        <div class="form-group mb-3">
                            <label for="first_name">First Name:</label>
                            <input type="text" name="first_name" id="first_name" class="form-control" value="John" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="last_name">Last Name:</label>
                            <input type="text" name="last_name" id="last_name" class="form-control" value="Doe" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" value="john.doe@example.com" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone">Phone Number:</label>
                            <input type="tel" name="phone" id="phone" class="form-control" value="+1234567890" required>
                        </div>
                    </div>

                    <!-- Save and Cancel Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="#" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Profile Image Style */
    .profile-img {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        object-fit: cover;
        margin: 20px auto;
        cursor: pointer;
        transition: opacity 0.2s;
    }

    .profile-img:hover {
        opacity: 0.8;
    }

    /* Card Styling */
    .card {
        border-radius: 12px;
    }

    /* Personal Information and Settings */
    .section-title {
        font-size: 1.25rem;
        font-weight: bold;
        color: #495057;
        margin-bottom: 10px;
        text-align: center;
    }

    .form-group label {
        font-weight: bold;
        color: #495057;
    }

    /* Buttons */
    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
    }
</style>

<script>
    // Image Preview Script
    document.getElementById('profileImageInput').addEventListener('change', function(event) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('profileImagePreview').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });
</script>

@endsection

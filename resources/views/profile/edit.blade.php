@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4 shadow">
                <div class="text-center">
                    <!-- Profile Image -->
                    <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('assets/blankprofilepic.jpeg') }}"
    alt="Profile Image" class="profile-img" style="width: 130px; height: 130px; border-radius: 50%; object-fit: cover; margin: 20px auto;">
                    <h3>{{ $user->first_name }} {{ $user->last_name }}</h3>
                    <p class="text-muted">{{ $user->email }}</p>
                </div>

                <!-- Profile Edit Form -->
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- First Name -->
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}">
                        @error('first_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}">
                        @error('last_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $user->phone_number) }}">
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Profile Image -->
                    <div class="form-group">
                        <label for="profile_image">Profile Image</label>
                        <input type="file" id="profile_image" name="profile_image" class="form-control-file">
                        @error('profile_image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .profile-img {
        width: 100px; /* Adjust width */
        height: 100px; /* Adjust height */
        border-radius: 50%;
        object-fit: cover;
        margin: 20px auto;
    }

</style>
@endsection

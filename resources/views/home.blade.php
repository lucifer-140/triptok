<!-- In resources/views/home.blade.php -->
@extends('layouts.app')

@section('title', 'TripTock - Homepage')

@section('content')
    <!-- Welcome Section -->
    <div class="container text-center mt-5 welcome-section">
        <h1 class="welcome-message">Welcome to TripTock</h1>
        <p class="welcome-subtitle">Your journey begins here!</p>
        <a href="{{ url('trip/create-trip') }}" class="btn btn-primary create-trip-btn">Plan Your Trip</a>
    </div>

    <!-- Popular Destinations Section -->
    <div class="container mt-5">
        <h3 class="section-title">Popular Destinations</h3>
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="destination-card">
                    <img src="{{ asset('assets/paris.jpg') }}" class="img-fluid" alt="Paris">
                    <p class="destination-name">Paris</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="destination-card">
                    <img src="{{ asset('assets/tokyo.jpg') }}" class="img-fluid" alt="Tokyo">
                    <p class="destination-name">Tokyo</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="destination-card">
                    <img src="{{ asset('assets/sydney.jpg') }}" class="img-fluid" alt="Sydney">
                    <p class="destination-name">Sydney</p>
                </div>
            </div>
        </div>
    </div>
@endsection

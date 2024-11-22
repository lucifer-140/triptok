@extends('layouts.app')

@section('title', 'TripTock - Your Trip Planner')

@section('content')
    <!-- Hero Section -->
    <div class="container-fluid hero-section">
        <div class="container hero-content text-white">
            <div class="hero-text-wrapper">
                <h1 class="welcome-message">Adventure Awaits, {{ Auth::user()->first_name }}!</h1>
                <p class="welcome-subtitle">Start planning your dream trip today. Discover new places and experiences.</p>
            </div>
            <div class="hero-button-wrapper">
                <a href="{{ url('trip/create-trip') }}" class="btn btn-primary btn-lg create-trip-btn">Plan Your Trip</a>
            </div>
        </div>
    </div>

    <!-- Explore Destinations -->
    <div class="container my-5">
        <h3 class="section-title text-center mb-4">Explore Destinations</h3>
        <div class="row justify-content-center">
            @foreach (['paris', 'tokyo', 'sydney'] as $city)
                <div class="col-md-4 mb-4">
                    <div class="destination-card">
                        <img src="{{ asset("assets/{$city}.jpg") }}" class="img-fluid rounded-top" alt="{{ ucfirst($city) }}" loading="lazy">
                        <div class="destination-info py-3">
                            <h5 class="destination-name fs-5 mb-2">{{ ucfirst($city) }}</h5>
                            <p class="destination-description">Discover the beauty of {{ ucfirst($city) }}. Explore its iconic landmarks and hidden gems.</p>
                            <a href="#" class="btn btn-outline-primary explore-btn">Explore</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Plan Your Trip Features -->
    <div class="container my-5">
        <h3 class="section-title text-center mb-4">Plan Your Trip With Ease</h3>
        <div class="row text-center">
            @foreach ([
                ['icon' => 'calendar-heart', 'title' => 'Craft Your Itinerary', 'text' => 'Design your perfect trip, adding exciting activities and must-see destinations.'],
                ['icon' => 'heart', 'title' => 'Save Your Favorites', 'text' => 'Keep track of your favorite places and activities for quick access later.'],
                ['icon' => 'people', 'title' => 'Share the Joy', 'text' => 'Invite friends and family to collaborate on your trip planning.'],
            ] as $feature)
                <div class="col-md-4 mb-4">
                    <div class="feature-card p-4">
                        <i class="bi bi-{{ $feature['icon'] }} icon mb-3"></i>
                        <h4>{{ $feature['title'] }}</h4>
                        <p>{{ $feature['text'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Get Inspired Section -->
    <div class="container my-5">
        <h3 class="section-title text-center mb-4">Get Inspired</h3>
        <div class="row">
            @foreach ([
                ['image' => 'inspiration-1', 'title' => 'Unforgettable Adventures', 'text' => 'Create memories by visiting hidden gems and experiencing unique adventures.'],
                ['image' => 'inspiration-2', 'title' => 'Explore the World', 'text' => 'From bustling cities to serene landscapes, find your perfect getaway.'],
            ] as $inspiration)
                <div class="col-md-6 mb-4">
                    <div class="inspiration-card">
                        <img src="{{ asset("assets/{$inspiration['image']}.jpg") }}" class="img-fluid rounded-top" alt="Inspiration Image" loading="lazy">
                        <div class="inspiration-info p-3">
                            <h5 class="fw-bold">{{ $inspiration['title'] }}</h5>
                            <p>{{ $inspiration['text'] }}</p>
                            <a href="#" class="btn btn-outline-primary">Read More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

<style>
    /* Hero Section Styling */
    .hero-section {
        background-image: url("{{ asset('assets/hero-banner.jpg') }}");
        background-size: cover;
        background-position: center;
        min-height: 400px;
        display: flex;
        align-items: center;
        color: #fff;
        background-attachment: fixed;
    }

    .hero-content {
        padding: 3rem;
        text-align: center;
    }

    .hero-text-wrapper h1 {
        font-size: 3.5rem;
        font-weight: 600;
    }

    .hero-button-wrapper .create-trip-btn {
        margin-top: 20px;
        font-size: 1.2rem;
        padding: 12px 24px;
    }

    /* Destination Cards */
    .destination-card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }

    .destination-card img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .destination-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.15);
    }

    .destination-info {
        background-color: rgba(255, 255, 255, 0.9);
        padding: 15px;
    }

    .destination-name {
        font-weight: 600;
        font-size: 1.2rem;
    }

    .explore-btn {
        margin-top: 15px;
        color: #246351;
        border-color: #246351;
    }

    .explore-btn:hover {
        background-color: #246351;
        color: white;
    }

    /* Plan Your Trip Features */
    .feature-card {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 300px; /* Set a consistent height for feature cards */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        text-align: center;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .feature-card .icon {
        font-size: 2.5rem;
        color: #246351;
    }

    .feature-card h4 {
        margin-top: 20px;
        font-weight: bold;
    }

    /* Inspiration Cards */
    .inspiration-card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }

    .inspiration-card img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .inspiration-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.15);
    }

    .inspiration-info {
        background-color: rgba(255, 255, 255, 0.85);
        padding: 20px;
        text-align: center;
    }

    .inspiration-info h5 {
        font-size: 1.25rem;
        font-weight: 700;
    }

    .inspiration-info p {
        font-size: 1rem;
        margin-bottom: 20px;
    }

    .btn-outline-primary {
        border-color: #246351;
        color: #246351;
    }

    .btn-outline-primary:hover {
        background-color: #246351;
        color: #fff;
    }

    /* Consistent image size across the sections */
    .destination-card, .inspiration-card {
        height: 100%;
    }

    /* Ensure all feature cards have consistent height */
    .feature-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 300px; /* Keeps feature card size consistent */
    }

    .feature-card .icon {
        font-size: 3rem;
        color: #246351;
    }

    .feature-card h4 {
        margin-top: 20px;
        font-weight: bold;
    }

</style>

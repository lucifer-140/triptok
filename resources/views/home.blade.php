@extends('layouts.app')

@section('title', 'TripTock - Homepage')

@section('content')
    <div class="container-fluid hero-section">
        <div class="container hero-content text-white">
            <div class="hero-text-wrapper">
                <h1 class="welcome-message">Adventure Awaits, {{ Auth::user()->first_name }}!</h1>
                <p class="welcome-subtitle">Start planning your dream trip today.</p>
            </div>
            <div class="hero-button-wrapper">
                <a href="{{ url('trip/create-trip') }}" class="btn btn-primary btn-lg mt-3 create-trip-btn">Plan Your Trip</a>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <h3 class="section-title text-center mb-4">Explore Destinations</h3>
        <div class="row justify-content-center">
            @foreach (['paris', 'tokyo', 'sydney'] as $city)
                <div class="col-md-4 mb-4">
                    <div class="destination-card">
                        <img src="{{ asset("assets/{$city}.jpg") }}" class="img-fluid rounded-top" alt="{{ ucfirst($city) }}">
                        <div class="destination-info py-3">
                            <p class="destination-name fs-5 mb-2">{{ ucfirst($city) }}</p>
                            <a href="#" class="btn btn-outline-primary">Explore</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="container my-5">
        <h3 class="section-title text-center mb-4">Plan Your Trip With Ease</h3>
        <div class="row text-center">
            @foreach ([
                ['icon' => 'calendar-heart', 'title' => 'Craft Your Itinerary', 'text' => 'Design your perfect trip day by day, adding exciting activities and must-see destinations.'],
                ['icon' => 'heart', 'title' => 'Save Your Favorites', 'text' => 'Keep track of the places you love and the activities you want to experience.'],
                ['icon' => 'people', 'title' => 'Share the Joy', 'text' => 'Invite your friends and family to collaborate on your travel plans.'],
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

    <div class="container my-5">
        <h3 class="section-title text-center mb-4">Get Inspired</h3>
        <div class="row">
            @foreach ([
                ['image' => 'inspiration-1', 'title' => 'Unforgettable Adventures', 'text' => 'Discover hidden gems and create memories that will last a lifetime.'],
                ['image' => 'inspiration-2', 'title' => 'Explore the World', 'text' => 'From bustling cities to serene landscapes, find your perfect escape.'],
            ] as $inspiration)
                <div class="col-md-6 mb-4">
                    <div class="inspiration-card">
                        <img src="{{ asset("assets/{$inspiration['image']}.jpg") }}" class="img-fluid rounded-top" alt="Inspiration Image">
                        <div class="inspiration-info p-3">
                            <h4 class="fw-bold">{{ $inspiration['title'] }}</h4>
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
        color: #343a40;
    }

    .hero-content {
        padding: 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .hero-text-wrapper {
        text-align: center;
    }

    .hero-button-wrapper {
        display: flex;
        justify-content: center;
        width: 100%;
    }

    .welcome-message {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .welcome-subtitle {
        font-size: 1.5rem;
    }

    /* Destination Cards */
    .destination-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    .destination-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }
    .destination-card img {
        transition: transform 0.3s ease;
    }
    .destination-card:hover img {
        transform: scale(1.1);
    }
    .destination-info {
        background-color: #f9f9f9;
        padding: 1rem;
    }

    /* Feature Cards */
    .feature-card {
        background-color: #f9f9f9;
        border-radius: 8px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }
    .feature-card .icon {
        font-size: 3rem;
        color: #007bff;
    }

    /* Inspiration Cards */
    .inspiration-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    .inspiration-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }
    .inspiration-info {
        background-color: #f9f9f9;
        padding: 1rem;
    }
</style>

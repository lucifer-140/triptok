@extends('layouts.app')

@section('title', 'TripTock - Homepage')

@section('content')
    <div class="container-fluid hero-section">
        <div class="container text-center">
            <h1 class="welcome-message">Welcome to TripTock</h1>
            <p class="welcome-subtitle">Your journey begins here!</p>
            <a href="{{ url('trip/create-trip') }}" class="btn btn-primary create-trip-btn">Plan Your Trip</a>
        </div>
    </div>

    <div class="container mt-5">
        <h3 class="section-title">Explore Destinations</h3>
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="destination-card">
                    <img src="{{ asset('assets/paris.jpg') }}" class="img-fluid" alt="Paris">
                    <div class="destination-info">
                        <p class="destination-name">Paris</p>
                        <a href="#" class="btn btn-outline-primary">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="destination-card">
                    <img src="{{ asset('assets/tokyo.jpg') }}" class="img-fluid" alt="Tokyo">
                    <div class="destination-info">
                        <p class="destination-name">Tokyo</p>
                        <a href="#" class="btn btn-outline-primary">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="destination-card">
                    <img src="{{ asset('assets/sydney.jpg') }}" class="img-fluid" alt="Sydney">
                    <div class="destination-info">
                        <p class="destination-name">Sydney</p>
                        <a href="#" class="btn btn-outline-primary">Explore</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h3 class="section-title">Plan Your Trip</h3>
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="feature-card">
                    <i class="bi bi-calendar-heart icon"></i>
                    <h4>Create a Custom Itinerary</h4>
                    <p>Plan your trip day by day, adding activities and destinations.</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="feature-card">
                    <i class="bi bi-heart icon"></i>
                    <h4>Save Your Favorites</h4>
                    <p>Bookmark destinations and activities for later.</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="feature-card">
                    <i class="bi bi-people icon"></i>
                    <h4>Share with Friends</h4>
                    <p>Invite friends to collaborate on your trip planning.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h3 class="section-title">Travel Inspiration</h3>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="inspiration-card">
                    <img src="{{ asset('assets/inspiration-1.jpg') }}" class="img-fluid" alt="Travel Inspiration">
                    <div class="inspiration-info">
                        <h4>10 Best Beaches in Europe</h4>
                        <p>Discover stunning beaches and hidden coves along Europe's coastline.</p>
                        <a href="#" class="btn btn-outline-primary">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="inspiration-card">
                    <img src="{{ asset('assets/inspiration-2.jpg') }}" class="img-fluid" alt="Travel Inspiration">
                    <div class="inspiration-info">
                        <h4>Top 5 Hiking Trails in the Alps</h4>
                        <p>Explore breathtaking mountain scenery on these unforgettable hikes.</p>
                        <a href="#" class="btn btn-outline-primary">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .hero-section {
        background-image: url("{{ asset('assets/hero-banner.jpg') }}");
        background-size: cover;
        background-position: center;
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .hero-section .welcome-message {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .hero-section .welcome-subtitle {
        font-size: 1.5rem;
        margin-bottom: 2rem;
    }

    .destination-card {
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: hidden;
    }

    .destination-card img {
        transition: transform 0.3s ease;
    }

    .destination-card:hover img {
        transform: scale(1.1);
    }

    .destination-info {
        padding: 1rem;
        text-align: center;
    }

    .feature-card {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 2rem;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .feature-card .icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #007bff;
    }

    .inspiration-card {
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: hidden;
    }

    .inspiration-card img {
        transition: transform 0.3s ease;
    }

    .inspiration-card:hover img {
        transform: scale(1.1);
    }

    .inspiration-info {
        padding: 1rem;
    }
</style>

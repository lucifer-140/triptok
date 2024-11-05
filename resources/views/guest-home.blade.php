@extends('layouts.guest')

@section('title', 'TripTock - Welcome')

@section('content')
    <div class="container-fluid hero-section">
        <div class="container text-center">
            <h1 class="welcome-message">Explore the World with TripTock</h1>
            <p class="welcome-subtitle">Plan your dream vacation with ease.</p>
            <a href="{{ route('signup') }}" class="btn btn-primary">Start Planning</a>
        </div>
    </div>

    <div class="container mt-5">
        <h3 class="section-title">Popular Destinations</h3>
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
        <h3 class="section-title">Why Choose TripTock?</h3>
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="feature-card">
                    <i class="bi bi-calendar-heart icon"></i>
                    <h4>Personalized Itineraries</h4>
                    <p>Create custom itineraries tailored to your interests and travel style.</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="feature-card">
                    <i class="bi bi-heart icon"></i>
                    <h4>Save Your Favorites</h4>
                    <p>Bookmark destinations, activities, and accommodations for later.</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="feature-card">
                    <i class="bi bi-people icon"></i>
                    <h4>Share with Friends</h4>
                    <p>Collaborate with friends and family on your travel plans.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5 testimonials-section">
        <h3 class="section-title">What Our Users Say</h3>
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="testimonial-card">
                    <p>"TripTock made planning my trip so much easier! I loved the ability to create a custom itinerary and share it with my friends."</p>
                    <p class="testimonial-author">- John Doe</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="testimonial-card">
                    <p>"I was amazed by how many destinations and activities TripTock had to offer. I found some hidden gems I never would have discovered on my own."</p>
                    <p class="testimonial-author">- Jane Smith</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="testimonial-card">
                    <p>"TripTock is the perfect tool for anyone who wants to plan a stress-free vacation. I highly recommend it!"</p>
                    <p class="testimonial-author">- David Lee</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid cta-section">
        <div class="container text-center">
            <h3>Ready to start planning your adventure?</h3>
            <a href="{{ route('signup') }}" class="btn btn-primary">Sign Up Now</a>
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

    .testimonial-card {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 2rem;
    }

    .testimonial-author {
        font-style: italic;
        text-align: right;
        margin-top: 1rem;
    }

    .cta-section {
        background-color: #f8f9fa;
        padding: 3rem 0;
    }
</style>

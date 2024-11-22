@extends('layouts.guest')

@section('title', 'TripTock - Welcome')

@section('content')
    <!-- Hero Section -->
    <div class="container-fluid hero-section">
        <div class="container hero-content text-white">
            <div class="hero-text-wrapper text-center">
                <h1 class="welcome-message">Explore the World with TripTock</h1>
                <p class="welcome-subtitle">Plan your dream vacation with ease.</p>
                <a href="{{ route('signup') }}" class="btn btn-primary btn-lg create-trip-btn">Start Planning</a>
            </div>
        </div>
    </div>

    <!-- Popular Destinations -->
    <div class="container my-5">
        <h3 class="section-title text-center mb-4">Popular Destinations</h3>
        <div class="row justify-content-center">
            @foreach (['paris', 'tokyo', 'sydney'] as $city)
                <div class="col-md-4 mb-4">
                    <div class="destination-card">
                        <img src="{{ asset("assets/{$city}.jpg") }}" class="img-fluid rounded-top" alt="{{ ucfirst($city) }}" loading="lazy">
                        <div class="destination-info py-3">
                            <h5 class="destination-name fs-5 mb-2">{{ ucfirst($city) }}</h5>
                            <p class="destination-description">Explore the wonders of {{ ucfirst($city) }}.</p>
                            <a href="#" class="btn btn-outline-primary explore-btn">Explore</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Why Choose TripTock? -->
    <div class="container my-5">
        <h3 class="section-title text-center mb-4">Why Choose TripTock?</h3>
        <div class="row text-center">
            @foreach ([
                ['icon' => 'calendar-heart', 'title' => 'Personalized Itineraries', 'text' => 'Create custom itineraries tailored to your interests.'],
                ['icon' => 'heart', 'title' => 'Save Your Favorites', 'text' => 'Bookmark destinations and activities for later.'],
                ['icon' => 'people', 'title' => 'Share with Friends', 'text' => 'Collaborate with friends and family on your plans.'],
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

    <!-- Testimonials Section -->
    <div class="container my-5 testimonials-section">
        <h3 class="section-title text-center mb-4">What Our Users Say</h3>
        <div class="row">
            @foreach ([
                ['quote' => 'TripTock made planning my trip so much easier! I loved the ability to create a custom itinerary.', 'author' => 'John Doe'],
                ['quote' => 'I was amazed by how many destinations and activities TripTock had to offer.', 'author' => 'Jane Smith'],
                ['quote' => 'TripTock is the perfect tool for stress-free vacation planning!', 'author' => 'David Lee'],
            ] as $testimonial)
                <div class="col-md-4 mb-4">
                    <div class="testimonial-card p-3">
                        <p>"{{ $testimonial['quote'] }}"</p>
                        <p class="testimonial-author">- {{ $testimonial['author'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Call to Action -->
    <div class="container-fluid cta-section text-white">
        <div class="container text-center py-4">
            <h3>Ready to start planning your adventure?</h3>
            <a href="{{ route('signup') }}" class="btn btn-primary btn-lg mt-3">Sign Up Now</a>
        </div>
    </div>
@endsection

<style>
    /* Hero Section */
    .hero-section {
        background-image: url("{{ asset('assets/hero-banner.jpg') }}");
        background-size: cover;
        background-position: center;
        min-height: 400px;
        display: flex;
        align-items: center;
    }

    .hero-content {
        padding: 3rem;
        text-align: center;
    }

    .hero-text-wrapper h1 {
        font-size: 3.5rem;
        font-weight: 600;
    }

    .hero-text-wrapper .welcome-subtitle {
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .create-trip-btn {
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
    }

    .destination-card img {
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
    }

    /* Features Section */
    .feature-card {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .feature-card .icon {
        font-size: 3rem;
        color: #246351;
    }

    .feature-card h4 {
        margin-top: 20px;
        font-weight: bold;
    }

    /* Testimonials Section */
    .testimonial-card {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .testimonial-author {
        font-style: italic;
        text-align: right;
        margin-top: 10px;
    }

    /* CTA Section */
    .cta-section {
        background-color: #f8f9fa;
        border-radius: 8px;
    }
</style>

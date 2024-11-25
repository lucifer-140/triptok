
@extends('layouts.app')

@section('title', 'Dashboard - TripTock')

@section('content')
    <!-- Dashboard Hero Section -->
    <div class="container-fluid hero-section">
        <div class="container hero-content text-white">
            <div class="hero-text-wrapper">
                <h1 class="welcome-message">Hello, {{ Auth::user()->first_name }}!</h1>
                <p class="welcome-subtitle">Your next adventure is just a click away!</p>
            </div>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div class="container my-5">
        <div class="row">
            <!-- User Overview Section -->
            <div class="col-lg-4 mb-4">
                <div class="card overview-card p-4">
                    <h4 class="mb-3">Your Trips Overview</h4>
                    <p class="text-muted">Planned Trips: <strong>3</strong></p>
                    <p class="text-muted">Completed Trips: <strong>5</strong></p>
                    <p class="text-muted">Upcoming Trips: <strong>1</strong></p>
                    <a href="{{ url('trips') }}" class="btn btn-primary w-100 mt-3">View All Trips</a>
                </div>
            </div>

            <!-- Quick Actions Section -->
            <div class="col-lg-4 mb-4">
                <div class="card quick-actions-card p-4">
                    <h4 class="mb-3">Quick Actions</h4>
                    <a href="{{ url('trip/create-trip') }}" class="btn btn-success w-100 mb-2">+ Plan a New Trip</a>
                    <a href="{{ url('favorites') }}" class="btn btn-outline-primary w-100 mb-2">View Saved Destinations</a>
                    <a href="{{ url('friends') }}" class="btn btn-outline-secondary w-100">Invite Friends</a>
                </div>
            </div>

            <!-- Budget Overview Section -->
            <div class="col-lg-4 mb-4">
                <div class="card budget-overview-card p-4">
                    <h4 class="mb-3">Budget Overview</h4>
                    <p class="text-muted">Budget for Current Trips: <strong>$2000</strong></p>
                    <p class="text-muted">Spent So Far: <strong>$800</strong></p>
                    <p class="text-muted">Remaining Budget: <strong>$1200</strong></p>
                    <a href="{{ url('budget') }}" class="btn btn-outline-primary w-100">Manage Budget</a>
                </div>
            </div>
        </div>

        <!-- Upcoming Trips Section -->
        <div class="upcoming-trips-section mt-5">
            <h3 class="section-title text-center mb-4">Upcoming Trips</h3>
            <div class="row justify-content-center">
                @foreach ([['destination' => 'Rome', 'date' => 'Dec 25, 2024', 'status' => 'In Progress'], ['destination' => 'Bali', 'date' => 'Jan 10, 2025', 'status' => 'Planned']] as $trip)
                    <div class="col-md-6 mb-4">
                        <div class="upcoming-trip-card card p-3">
                            <h5 class="trip-destination fw-bold">{{ $trip['destination'] }}</h5>
                            <p class="trip-date text-muted">Date: {{ $trip['date'] }}</p>
                            <p class="trip-status">Status: <span class="badge bg-success">{{ $trip['status'] }}</span></p>
                            <a href="#" class="btn btn-outline-primary mt-2">View Details</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Travel Tips & Reminders Section -->
        <div class="travel-tips-section mt-5">
            <h3 class="section-title text-center mb-4">Travel Tips & Reminders</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="card tips-card p-4">
                        <h5 class="mb-3">Essential Travel Tips</h5>
                        <ul class="list-unstyled">
                            <li>✔ Check your travel documents and visa requirements.</li>
                            <li>✔ Pack light but include essentials like a first-aid kit.</li>
                            <li>✔ Notify your bank about international travel.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card reminders-card p-4">
                        <h5 class="mb-3">Upcoming Deadlines</h5>
                        <ul class="list-unstyled">
                            <li>📌 Book Rome accommodations by Dec 10, 2024.</li>
                            <li>📌 Bali trip insurance confirmation by Jan 5, 2025.</li>
                            <li>📌 Complete vaccinations before your next trip.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Travel Stats Section -->
        <div class="travel-stats-section mt-5">
            <h3 class="section-title text-center mb-4">Your Travel Stats</h3>
            <div class="row">
                <div class="col-md-4">
                    <div class="card stats-card p-4 text-center">
                        <h4>Total Trips</h4>
                        <p class="display-4 text-primary">8</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stats-card p-4 text-center">
                        <h4>Countries Visited</h4>
                        <p class="display-4 text-success">12</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stats-card p-4 text-center">
                        <h4>Activities Done</h4>
                        <p class="display-4 text-danger">25</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    /* General Styling */
    .overview-card, .quick-actions-card, .budget-overview-card, .tips-card, .reminders-card, .upcoming-trip-card, .stats-card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .overview-card h4, .quick-actions-card h4, .budget-overview-card h4, .section-title {
        font-weight: bold;
        color: #246351;
    }

    .stats-card p {
        font-weight: bold;
        font-size: 2.5rem;
    }
</style>

@extends('layouts.app')

@section('content')
<div class="container mt-5" style="background: linear-gradient(to right, #f0f4f8, #e3e9f1); border-radius: 10px; padding: 20px;">
    <h2 class="mb-4 text-center">Manage Your Trips</h2>

    <!-- Search Bar -->
    <div class="mb-4">
        <input type="text" class="form-control" id="searchTrip" placeholder="Search for trips...">
    </div>

    <!-- Pending Trips Section -->
    <div class="mb-5">
        <h3 class="section-title">Pending Trips</h3>
        <div class="row" id="pendingTrips">
            @forelse ($pendingTrips as $trip)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm" style="border-radius: 15px;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $trip->tripTitle }}</h5>
                            <p class="card-text"><strong>Destination:</strong> {{ $trip->tripDestination }}</p>
                            <p class="card-text"><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($trip->tripStartDate)->format('F d, Y') }}</p>
                            <p class="card-text"><strong>End Date:</strong> {{ \Carbon\Carbon::parse($trip->tripEndDate)->format('F d, Y') }}</p>
                            <span class="badge bg-warning mb-2">Pending</span>

                            <hr class="my-3">

                            <div class="d-flex justify-content-between">
                                <div>
                                    <!-- Edit Button: Redirects to itinerary.create route with trip ID -->
                                    <a href="#" class="btn btn-outline-primary btn-sm me-2">View <i class="fas fa-eye"></i></a>
                                    <a href="{{ route('itinerary.create', $trip->id) }}" class="btn btn-outline-secondary btn-sm me-2">Edit <i class="fas fa-edit"></i></a>
                                </div>
                                <a href="#" class="btn btn-outline-info btn-sm">Share <i class="fas fa-share-alt"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>No pending trips available.</p>
            @endforelse
        </div>
    </div>

    <!-- Ongoing Trips Section -->
    <div class="mb-5">
        <h3 class="section-title">Ongoing Trips</h3>
        <div class="row" id="ongoingTrips">
            @forelse ($ongoingTrips as $trip)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm" style="border-radius: 15px;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $trip->tripTitle }}</h5>
                            <p class="card-text"><strong>Destination:</strong> {{ $trip->tripDestination }}</p>
                            <p class="card-text"><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($trip->tripStartDate)->format('F d, Y') }}</p>
                            <p class="card-text"><strong>End Date:</strong> {{ \Carbon\Carbon::parse($trip->tripEndDate)->format('F d, Y') }}</p>
                            <span class="badge bg-success mb-2">Ongoing</span>

                            <hr class="my-3">

                            <div class="d-flex justify-content-between">
                                <div>
                                    <!-- Edit Button: Redirects to itinerary.create route with trip ID -->
                                    <a href="{{ route('trips.details', $trip->id) }}" class="btn btn-outline-primary btn-sm me-2">View <i class="fas fa-eye"></i></a>

                                    <a href="{{ route('itinerary.create', $trip->id) }}" class="btn btn-outline-secondary btn-sm me-2">Edit <i class="fas fa-edit"></i></a>
                                </div>
                                <a href="#" class="btn btn-outline-info btn-sm">Share <i class="fas fa-share-alt"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>No ongoing trips available.</p>
            @endforelse
        </div>
    </div>

    <!-- Finished Trips Section -->
    <div class="mb-5">
        <h3 class="section-title">Finished Trips</h3>
        <div class="row" id="finishedTrips">
            @forelse ($finishedTrips as $trip)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm" style="border-radius: 15px;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $trip->tripTitle }}</h5>
                            <p class="card-text"><strong>Destination:</strong> {{ $trip->tripDestination }}</p>
                            <p class="card-text"><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($trip->tripStartDate)->format('F d, Y') }}</p>
                            <p class="card-text"><strong>End Date:</strong> {{ \Carbon\Carbon::parse($trip->tripEndDate)->format('F d, Y') }}</p>
                            <span class="badge bg-secondary mb-2">Finished</span>

                            <hr class="my-3">

                            <div class="d-flex justify-content-between">
                                <div>
                                    <!-- Edit Button: Redirects to itinerary.create route with trip ID -->
                                    <a href="{{ route('itinerary.create', $trip->id) }}" class="btn btn-outline-secondary btn-sm">Edit <i class="fas fa-edit"></i></a>
                                </div>
                                <a href="#" class="btn btn-outline-info btn-sm">Share <i class="fas fa-share-alt"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>No finished trips available.</p>
            @endforelse
        </div>
    </div>

    <!-- Plan New Trip Button -->
    <div class="text-center mt-4">
        <a href="{{ route('trips.create') }}" class="btn btn-lg btn-success shadow-lg">Plan New Trip <i class="fas fa-plus-circle"></i></a>
    </div>
</div>

<style>
    .section-title {
        font-size: 1.5rem;
        margin-bottom: 20px;
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
        color: #333;
    }
    .card:hover {
        transform: scale(1.02);
        transition: transform 0.3s;
    }
</style>
@endsection

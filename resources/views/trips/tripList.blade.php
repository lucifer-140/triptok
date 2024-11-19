@extends('layouts.app')

@section('content')
<div class="container mt-5" style="background: linear-gradient(to right, #f0f4f8, #e3e9f1); border-radius: 10px; padding: 20px;">
    <h2 class="mb-4 text-center">Manage Your Trips</h2>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    <!-- Search Bar -->
    <div class="mb-4 position-relative">
        <input type="text" class="form-control" id="searchTrip" placeholder="Search for trips...">
        <div id="spinner" class="spinner-border text-primary position-absolute end-0 top-50 translate-middle-y d-none" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Pending Trips Section -->
    <div class="mb-5">
        <h3 class="section-title">Pending Trips</h3>
        <div class="row" id="pendingTrips">
            @forelse ($pendingTrips as $index => $trip)
                <div class="col-md-6 mb-4 trip-card @if($index >= 2) d-none @endif" data-trip-title="{{ strtolower($trip->tripTitle) }}" data-trip-destination="{{ strtolower($trip->tripDestination) }}">
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
                                    <a href="{{ route('trips.details', $trip->id) }}" class="btn btn-outline-primary btn-sm me-2">View <i class="fas fa-eye"></i></a>
                                    <a href="{{ route('itinerary.create', $trip->id) }}" class="btn btn-outline-secondary btn-sm me-2">Edit <i class="fas fa-edit"></i></a>
                                </div>
                                <a href="#" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#shareModal" data-trip-id="{{ $trip->id }}">Share <i class="fas fa-share-alt"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>No pending trips available.</p>
            @endforelse
        </div>
        @if(count($pendingTrips) > 2)
            <div class="text-center">
                <button class="btn btn-link show-more" data-target="#pendingTrips">Show More</button>
            </div>
        @endif
    </div>






    <!-- Ongoing Trips Section -->
    <div class="mb-5">
        <h3 class="section-title">Ongoing Trips</h3>
        <div class="row" id="ongoingTrips">
            @forelse ($ongoingTrips as $index => $trip)
                <div class="col-md-6 mb-4 trip-card @if($index >= 2) d-none @endif" data-trip-title="{{ strtolower($trip->tripTitle) }}" data-trip-destination="{{ strtolower($trip->tripDestination) }}">
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
                                    <a href="{{ route('trips.details', $trip->id) }}" class="btn btn-outline-primary btn-sm me-2">View <i class="fas fa-eye"></i></a>
                                    <a href="{{ route('itinerary.create', $trip->id) }}" class="btn btn-outline-secondary btn-sm me-2">Edit <i class="fas fa-edit"></i></a>
                                </div>
                                <a href="#" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#shareModal" data-trip-id="{{ $trip->id }}">Share <i class="fas fa-share-alt"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>No ongoing trips available.</p>
            @endforelse
        </div>
        @if(count($ongoingTrips) > 2)
            <div class="text-center">
                <button class="btn btn-link show-more" data-target="#ongoingTrips">Show More</button>
            </div>
        @endif
    </div>

    <!-- Finished Trips Section -->
    <div class="mb-5">
        <h3 class="section-title">Finished Trips</h3>
        <div class="row" id="finishedTrips">
            @forelse ($finishedTrips as $index => $trip)
                <div class="col-md-6 mb-4 trip-card @if($index >= 2) d-none @endif" data-trip-title="{{ strtolower($trip->tripTitle) }}" data-trip-destination="{{ strtolower($trip->tripDestination) }}">
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
                                    <a href="{{ route('itinerary.create', $trip->id) }}" class="btn btn-outline-secondary btn-sm me-2">Edit <i class="fas fa-edit"></i></a>
                                </div>
                                <a href="#" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#shareModal" data-trip-id="{{ $trip->id }}">Share <i class="fas fa-share-alt"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>No finished trips available.</p>
            @endforelse
        </div>
        @if(count($finishedTrips) > 2)
            <div class="text-center">
                <button class="btn btn-link show-more" data-target="#finishedTrips">Show More</button>
            </div>
        @endif
    </div>

    <!-- Plan New Trip Button -->
    <div class="text-center mt-4">
        <a href="{{ route('trips.create') }}" class="btn btn-lg btn-success shadow-lg">Plan New Trip <i class="fas fa-plus-circle"></i></a>
    </div>


    <!-- Include the modal component -->
    @include('components.share-trip-modal', ['friends' => $friends])
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
    .show-more {
        font-size: 1rem;
        color: #007bff;
        cursor: pointer;
        text-decoration: none;
        border: none;
        background: none;
    }
    .show-more:hover {
        text-decoration: underline;
    }
    /* Spinner Style */
    .spinner-border {
        width: 2rem;
        height: 2rem;
        color: grey !important;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Search functionality
        const searchInput = document.getElementById("searchTrip");
        const spinner = document.getElementById("spinner");
        const tripCards = document.querySelectorAll(".trip-card");

        searchInput.addEventListener("input", function() {
            // Show the spinner when typing starts
            spinner.classList.remove("d-none");

            // Delay to simulate loading time (optional)
            setTimeout(function() {
                const searchTerm = searchInput.value.toLowerCase();

                tripCards.forEach(function(card) {
                    const tripTitle = card.getAttribute("data-trip-title");
                    const tripDestination = card.getAttribute("data-trip-destination");

                    if (tripTitle.includes(searchTerm) || tripDestination.includes(searchTerm)) {
                        card.classList.remove("d-none");
                    } else {
                        card.classList.add("d-none");
                    }
                });

                // Hide the spinner after search is complete
                spinner.classList.add("d-none");
            }, 500); // Adjust the timeout as needed
        });

        // Show more functionality
        const showMoreButtons = document.querySelectorAll(".show-more");
        showMoreButtons.forEach(button => {
            button.addEventListener("click", function() {
                const target = document.querySelector(button.getAttribute("data-target"));
                const hiddenCards = target.querySelectorAll(".d-none");
                hiddenCards.forEach(card => {
                    card.classList.remove("d-none");
                });
                button.classList.add("d-none");
            });
        });
    });
</script>
@endsection

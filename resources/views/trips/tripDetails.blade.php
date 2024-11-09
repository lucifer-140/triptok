@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card" style="height: auto;">
        <!-- Card Header: Title and Back Button -->
        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <div class="d-flex align-items-center">
                <!-- Back Button -->
                <a href="{{ url('/trip/list') }}" class="btn btn-secondary btn-sm me-3"><i class="bi bi-arrow-left-circle"></i></a>
                <h1 class="mb-0">{{ $trip->tripTitle }} - Trip Details</h1>
            </div>
        </div>

        <!-- Carousel for Days (No Indicator) -->
        <div class="card-body p-0">
            <div id="itinerary" class="carousel slide" data-bs-ride="carousel">
                <!-- Removed Carousel Indicators -->

                <div class="carousel-inner" style="max-height: 80vh; overflow-y: auto;">
                    @foreach ($days as $day)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <div class="day-content p-3">
                                <h3 class="day-heading mb-3">Day {{ $day->day }} - {{ \Carbon\Carbon::parse($day->date)->format('d M, Y') }}</h3>

                                <!-- Day Content: Activities, Accommodation, Transport, Flights -->
                                <div class="day-details">
                                    <h5>Activities</h5>
                                    @include('trips.partials.activity-list', ['activities' => $day->activities])

                                    <h5 class="mt-4">Accommodation</h5>
                                    @include('trips.partials.accommodation-list', ['accommodations' => $day->accommodations])

                                    <h5 class="mt-4">Transport</h5>
                                    @include('trips.partials.transport-list', ['transports' => $day->transports])

                                    <h5 class="mt-4">Flights</h5>
                                    @include('trips.partials.flight-list', ['flights' => $day->flights])

                                    @if ($day->activities->isEmpty() && $day->accommodations->isEmpty() && $day->transports->isEmpty() && $day->flights->isEmpty())
                                        <p class="text-center">No activities, accommodations, transport, or flights planned for this day.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#itinerary" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#itinerary" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

        <!-- Floating Action Buttons for Edit, Share, Delete -->
        <div class="fixed-bottom d-flex justify-content-center p-3">
            <div class="btn-group w-100">
                <a href="#" class="btn btn-primary btn-lg flex-fill"><i class="bi bi-pencil"></i> Edit</a>
                <a href="#" class="btn btn-success btn-lg flex-fill"><i class="bi bi-share"></i> Share</a>
                <a href="#" class="btn btn-danger btn-lg flex-fill"><i class="bi bi-trash"></i> Delete</a>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styling -->
<style>
    /* Basic Styling */
    .card {
        border-radius: 10px;
        overflow: hidden;
        margin-top: 20px;
        height: 85vh; /* Increased card height for better display */
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #ddd;
        padding: 15px;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-group .btn {
        font-size: 14px;
    }

    /* Carousel Inner Styling */
    .carousel-item {
        padding: 15px;
        background-color: #fafafa;
        height: auto;  /* Ensure item expands with content */
    }

    /* Day Content */
    .day-content {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .day-heading {
        font-size: 1.5rem;
        color: #343a40;
    }

    /* Activity/Accommodation/Transport/Flight Lists */
    .day-details h5 {
        color: #343a40;  /* Neutral color */
    }

    .day-details ul {
        padding-left: 20px;
    }

    /* Removed Carousel Indicators */
    /* Carousel Controls */
    .carousel-control-prev-icon, .carousel-control-next-icon {
        background-color: transparent;
    }

    /* Floating Action Buttons */
    .fixed-bottom .btn-group {
        position: fixed;
        bottom: 20px;
        width: 100%;
        justify-content: space-between;
        padding: 0 15px;
    }

    .flex-fill {
        flex: 1;
    }

    /* Responsive Design: Stack on mobile */
    @media (max-width: 768px) {
        .carousel-item {
            padding: 10px;
        }

        .carousel-inner {
            max-height: 400px;
        }

        .day-heading {
            font-size: 1.2rem;
        }

        .day-details {
            padding: 10px;
        }

        .btn-group {
            width: 100%;
            justify-content: space-between;
        }
    }
</style>

@endsection

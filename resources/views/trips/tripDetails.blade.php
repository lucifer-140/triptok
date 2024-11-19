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
        <div class="">
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

        <div class="fixed-bottom d-flex justify-content-center p-3">
            <div class="btn-group w-100">
                <a href="{{ route('itinerary.create', $trip->id) }}" class="btn btn-primary btn-lg flex-fill">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="#" class="btn btn-success btn-lg flex-fill"  data-toggle="modal" data-target="#shareModal" data-trip-id="{{ $trip->id }}">
                    <i class="bi bi-share"></i> Share
                </a>
                <a href="{{ route('trip.downloadICS', ['itineraryId' => $itinerary->id]) }}" class="btn btn-warning btn-lg flex-fill" style="color: white">
                    <i class="bi bi-bell"></i> Reminder
                </a>
                <a href="#" class="btn btn-danger btn-lg flex-fill" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal">
                    <i class="bi bi-trash"></i> Delete
                </a>
            </div>
        </div>
    </div>
</div>


<!-- Include the modal component -->
@include('components.share-trip-modal', ['friends' => $friends])


<!-- Modal for Confirming Deletion -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this trip? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteTripForm" action="{{ route('trip.delete', $trip_id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Trip</button>
                </form>
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

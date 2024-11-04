@extends('layouts.app')

@section('title', 'Day Plan')

@section('content')

<div class="container mt-5">


    <h2 class="text-center mb-4">Day plan for Your Trip</h2>
    <p class="text-center mb-4">Plan your adventure day by day with details of activities, transport, accommodation, and more.</p>

    <div class="mb-4 border rounded p-3">
        <p><strong>DEBUG</strong></p>
        <h1>Day Plan for Day {{ $day->day }}</h1>
        <p>Date: {{ $day->date }}</p>

        <h2>Itinerary Details</h2>
        <p>Trip ID: {{ $itinerary->trip_id }}</p>

        @if($currency)
            <label for="tripCurrency">Currency:</label>
            <input type="text" class="form-control" id="tripCurrency" value="{{ $currency }}" readonly>
        @else
            <p>No currency data available.</p>
        @endif


    </div>



    <!-- Itinerary List -->
    <div id="itineraryList" class="mb-4 border rounded p-3">
        <h3 class="section-title">Your Itinerary</h3>
        <div class="row">
            <div class="col mb-3" id="itineraryItems">
                <div class="border rounded p-3 text-center" id="emptyItinerary">
                    <p class="text-muted">No itinerary items added yet. Please add some!</p>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Save Itinerary</button>
        </div>
    </div>

    <!-- Button to Add Itinerary -->
    <div class="text-center mb-4 d-flex align-items-center justify-content-center">
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="manageItineraryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-plus-circle"></i> Add Itinerary
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="manageItineraryDropdown">
                <li>
                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#activitiesModal" aria-label="Add Activities">
                        <i class="bi bi-calendar-plus"></i> Add Activities
                    </button>
                </li>
                <li>
                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#transportModal" aria-label="Add Transport">
                        <i class="bi bi-car-front"></i> Add Transport
                    </button>
                </li>
                <li>
                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#accommodationModal" aria-label="Add Accommodation">
                        <i class="bi bi-house"></i> Add Accommodation
                    </button>
                </li>
                <li>
                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#flightModal" aria-label="Add Flight">
                        <i class="bi bi-airplane-engines"></i> Add Flight
                    </button>
                </li>
            </ul>
        </div>
    </div>



    <!-- Modals for Adding Itinerary Items -->
    @include('modals.activities') <!-- Include activities modal -->
    @include('modals.transport') <!-- Include transport modal -->
    @include('modals.accommodation') <!-- Include accommodation modal -->
    @include('modals.flight') <!-- Include flight modal -->



</div>

<script>



</script>


@endsection

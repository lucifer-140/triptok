@extends('layouts.app')

@section('content')
<div class="container mt-5" style="background: linear-gradient(to right, #e0f7fa, #fff3e0); border-radius: 10px; padding: 20px;">
    <h2 class="text-center mb-4">Trip Details</h2>

    <!-- Trip Header -->
    <div class="text-center mb-4">
        <h3 class="trip-title">Summer Vacation</h3>
        <p class="trip-destination"><strong>Destination:</strong> Paris, France</p>
    </div>

    <!-- Trip Information Section -->
    <div class="mb-4">
        <h4 class="section-title">Trip Information</h4>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Start Date:</strong> July 15, 2024</p>
                <p><strong>End Date:</strong> July 30, 2024</p>
            </div>
            <div class="col-md-6">
                <p><strong>Duration:</strong> 15 Days</p>
                <p><strong>Status:</strong> Upcoming</p>
            </div>
        </div>
    </div>

    <!-- Accommodations Section -->
    <div class="mb-4">
        <h4 class="section-title">Accommodations</h4>
        <ul class="list-group">
            <li class="list-group-item">Hotel XYZ - 5 nights</li>
            <li class="list-group-item">Airbnb - 10 nights</li>
        </ul>
    </div>

    <!-- Transportation Section -->
    <div class="mb-4">
        <h4 class="section-title">Transportation</h4>
        <ul class="list-group">
            <li class="list-group-item">Flight: ABC123 (July 14)</li>
            <li class="list-group-item">Train: Paris to Lyon (July 20)</li>
        </ul>
    </div>

    <!-- Itinerary Section -->
    <div class="mb-4">
        <h4 class="section-title">Itinerary</h4>
        <ul class="list-group">
            <li class="list-group-item">July 15: Arrive in Paris and explore the Eiffel Tower.</li>
            <li class="list-group-item">July 16: Visit the Louvre Museum.</li>
            <li class="list-group-item">July 17: Day trip to Versailles.</li>
            <li class="list-group-item">July 18: Enjoy a Seine River cruise.</li>
            <li class="list-group-item">July 19: Shopping in Le Marais.</li>
        </ul>
    </div>

    <!-- Notes Section -->
    <div class="mb-4">
        <h4 class="section-title">Notes</h4>
        <textarea class="form-control" rows="5" readonly>This trip is to celebrate my anniversary. Don't forget to book the Eiffel Tower dinner!</textarea>
    </div>

    <!-- Action Buttons -->
    <div class="text-center">
        <a href="#" class="btn btn-primary me-2">Edit Trip <i class="fas fa-edit"></i></a>
        <a href="#" class="btn btn-danger me-2">Delete Trip <i class="fas fa-trash-alt"></i></a>
        <a href="#" class="btn btn-info">Share Trip <i class="fas fa-share-alt"></i></a>
    </div>
</div>

<style>
    .section-title {
        font-size: 1.5rem;
        margin-bottom: 10px;
        color: #007bff;
    }
    .trip-title {
        font-size: 2rem;
        font-weight: bold;
    }
    .trip-destination {
        font-size: 1.2rem;
        color: #555;
    }
</style>
@endsection

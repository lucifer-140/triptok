@extends('layouts.app')

@section('title', 'Itinerary')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Itinerary for Your Trip</h2>
    <p class="text-center mb-4">Plan your adventure day by day with details of activities, transport, accommodation, and more.</p>

    <div class="mb-4 border rounded p-3">
        <p><strong>DEBUG</strong></p>
        <p><strong>Itinerary ID:</strong> {{ $itinerary->id  }}</p>
        <p><strong>Trip ID:</strong> {{ $trip_id }}</p>
        <div class="mb-4">
            <label for="tripCurrency" class="form-label">Trip Currency:</label>
            <input type="text" class="form-control" id="tripCurrency" value="{{ $currency }}" readonly>
        </div>
    </div>

    <!-- Select Day of the Trip -->
    <div class="mb-4">
        <input type="hidden" id="itineraryId" value="{{ $itinerary->id }}">
        <label for="tripDay" class="form-label">Select Day of Your Trip:</label>
        <div class="input-group">
            <select class="form-select" id="tripDay">
                @for ($day = 1; $day <= $totalDays; $day++)
                    @php
                        // Calculate the actual date for the current day
                        $currentDate = $startDate->copy()->addDays($day - 1);
                    @endphp
                    <option value="{{ $day }}">
                        Day {{ $day }} ({{ $currentDate->format('d - m - Y') }})
                    </option>
                @endfor
            </select>
            <button type="button" class="btn btn-primary" id="saveDayPlanButton">Save Day Plan</button>
        </div>
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




</div>

<script>


</script>


@endsection

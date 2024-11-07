@extends('layouts.app')

@section('title', 'Itinerary')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Itinerary for Your Trip</h2>
    <p class="text-center mb-4">Plan your adventure day by day with details of activities, transport, accommodation, and more.</p>

    <div class="mb-4 border rounded p-3">
        {{-- <p><strong>DEBUG</strong></p>
        <p><strong>Itinerary ID:</strong> {{ $itinerary->id  }}</p>
        <p><strong>Trip ID:</strong> {{ $trip_id }}</p>
        <div class="mb-4">
            <label for="tripCurrency" class="form-label">Trip Currency:</label>
            <input type="text" class="form-control" id="tripCurrency" value="{{ $currency }}" readonly>
        </div> --}}
        <!-- Display the grand total -->
        <h3 class="mt-4">Grand Total: {{ $grandTotal }} {{ $itinerary->trip->currency }}</h3>
        <h3 class="mt-4">
            Leftover Budget:
            <span class="{{ $leftover < 0 ? 'text-danger fw-bold' : '' }}">
                {{ $leftover }} {{ $currency }}
            </span>
        </h3>

        @if ($leftover < 0)
            <div class="alert alert-warning">
                Warning: Your budget is exceeded by {{ abs($leftover) }} {{ $currency }}. Please adjust your itinerary accordingly.
            </div>
        @endif


    </div>

    <form action="{{ route('day.store') }}" method="POST">
        @csrf
        <input type="hidden" name="itinerary_id" value="{{ $itinerary->id }}">

    <!-- Select Day of the Trip -->
    <div class="mb-4">
        <label for="tripDay" class="form-label">Select Day of Your Trip:</label>
        <div class="input-group">
            <select class="form-select" name="day" id="tripDay" required>
                <option value="" disabled selected>Select Day...</option> <!-- Default option -->
                @for ($day = 1; $day <= $totalDays; $day++)
                    @php
                        $currentDate = $startDate->copy()->addDays($day - 1);
                    @endphp
                    <option value="{{ $day }}" data-date="{{ $currentDate->format('Y-m-d') }}">
                        Day {{ $day }} ({{ $currentDate->format('d-m-Y') }})
                    </option>
                @endfor
            </select>
            <input type="hidden" name="date" id="selectedDate">
            <button type="submit" class="btn btn-primary">Create Day Plan</button>
        </div>
    </div>


    <div id="breakdownList" class="mb-4 border rounded p-3">
        <h3 class="section-title">Trip Breakdown</h3>
        <div class="row">
            <div class="col mb-3" id="breakdownItems">
                <div class="border rounded p-3 text-center" id="emptyBreakdown">
                    <p class="text-muted">No breakdown items added yet. Please add some!</p>
                </div>
            </div>
        </div>
    </div>


    <div class="d-flex justify-content-center">
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="tripActionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Trip Actions
            </button>
            <ul class="dropdown-menu" aria-labelledby="tripActionsDropdown">
                <li><a class="dropdown-item" href="#">Save as Final</a></li>
                <li><a class="dropdown-item" href="#">Save as Draft</a></li>
                <li><a class="dropdown-item" href="#">Share Trip</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="#">Delete Trip</a></li>
            </ul>
        </div>
    </div>



</div>

<script>
    document.getElementById('tripDay').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        document.getElementById('selectedDate').value = selectedOption.getAttribute('data-date');
    });

    // Set the date when the page first loads
    document.getElementById('tripDay').dispatchEvent(new Event('change'));
</script>


@endsection

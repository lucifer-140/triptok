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
                    <option value="" disabled selected>Select Day...</option>
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
            </div>
            <div class="d-flex justify-content-center mt-2">
                <button type="submit" class="btn btn-outline-primary me-2">Create Day Plan</button>
                <button type="button" class="btn btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#breakdownModal">Show Breakdown</button>
                <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editTripModal">Edit Trip Details</button>
            </div>
        </div>
    </form>


    <div class="d-flex justify-content-center">
        <div class="btn-group">
            <button type="button" class="btn btn-primary">Save as Final</button>
            <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Save as Draft</a></li>
                <li><a class="dropdown-item" href="#">Share Trip</a></li>
                <li><a class="dropdown-item" href="#">Duplicate Trip</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="#">Delete Trip</a></li>
            </ul>
        </div>
    </div>

    
    <!-- Modal for Editing Trip Details -->
    <div class="modal fade" id="editTripModal" tabindex="-1" aria-labelledby="editTripModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('trips.update', $trip_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTripModalLabel">Edit Trip Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tripTitle" class="form-label">Trip Title</label>
                            <input type="text" class="form-control" id="tripTitle" name="tripTitle" value="{{ $itinerary->trip->tripTitle }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="tripDestination" class="form-label">Destination</label>
                            <input type="text" class="form-control" id="tripDestination" name="tripDestination" value="{{ $itinerary->trip->tripDestination }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="tripStartDate" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="tripStartDate" name="tripStartDate" value="{{ $itinerary->trip->tripStartDate }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="tripEndDate" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="tripEndDate" name="tripEndDate" value="{{ $itinerary->trip->tripEndDate }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="totalBudget" class="form-label">Total Budget</label>
                            <input type="number" class="form-control" id="totalBudget" name="totalBudget" value="{{ $itinerary->trip->totalBudget }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="currency" class="form-label">Currency</label>
                            <select class="form-select" id="currency" name="currency" required>
                                <option value="" disabled>Select currency</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->code }}" {{ $itinerary->trip->currency == $currency->code ? 'selected' : '' }}>
                                        {{ $currency->name }} ({{ $currency->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Modal for Breakdown -->
    <div class="modal fade" id="breakdownModal" tabindex="-1" aria-labelledby="breakdownModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="breakdownModalLabel">Trip Breakdown</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        @foreach($days as $key => $day)
                        <div id="day{{ $day->day }}" class="day-breakdown col-md-4 mb-4">
                            <div class="card">
                                <div class="card-header" style="background-color: #246351;">
                                    <h5 class="mb-0 text-white">Day {{ $day->day }} ({{ \Carbon\Carbon::parse($day->date)->format('d-m-Y') }})</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="font-weight-bold text-black">Activities:</span>
                                        <span class="badge badge-pill badge-primary">{{ $day->activities->count() }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="font-weight-bold text-black">Accommodation:</span>
                                        <span class="badge badge-pill badge-success">{{ $day->accommodations->count() }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="font-weight-bold text-black">Transport:</span>
                                        <span class="badge badge-pill badge-info">{{ $day->transports->count() }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="font-weight-bold text-black">Flights:</span>
                                        <span class="badge badge-pill badge-warning">{{ $day->flights->count() }}</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="font-weight-bold text-black">Total Cost:</span>
                                        <span class="h5 mb-0 text-black">{{ $dayGrandTotals[$key] }} {{ $currency->code }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
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


    // Initialize scrollspy
    const dataSpyList = document.querySelector('#dayTabs');
                    const scrollSpy = new bootstrap.ScrollSpy(document.body, {
                        target: '#dayTabs',
                        offset: 100
                    });
</script>

@endsection

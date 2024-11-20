@extends('layouts.app')

@section('title', 'Itinerary')

@section('content')

<div class="container mt-5">
    <h2 class="text-center mb-4">Itinerary for Your Trip</h2>
    <p class="text-center mb-4">Plan your adventure day by day with details of activities, transport, accommodation, and more.</p>
    {{-- <div class="mb-4 mb-4 border rounded p-3">
        <p><strong>DEBUG</strong></p>
        <p><strong>Itinerary ID:</strong> {{ $itinerary->id  }}</p>
        <p><strong>Trip ID:</strong> {{ $trip_id }}</p>
        <div class="mb-4">
            <label for="tripCurrency" class="form-label">Trip Currency:</label>
            <input type="text" class="form-control" id="tripCurrency" value="{{ $currency }}" readonly>
        </div>
    </div> --}}



    <div class="mb-4 border rounded p-4 bg-light shadow-sm">
        {{-- Trip Status Section --}}
        <div class="mb-3">
            {{-- <label for="tripStatus" class="form-label text-muted">Trip Status</label> --}}

            @if (is_object($tripStatus))
                <span class="badge rounded-pill px-3 py-2" style="
                    background-color:
                        {{ $tripStatus->status == 'ongoing' ? '#28a745' :
                        ($tripStatus->status == 'pending' ? '#ffc107' :
                        ($tripStatus->status == 'Status not set yet' ? '#dc3545' :
                        ($tripStatus->status == 'finished' ? '#6c757d' : '#ffc107'))) }};
                    color: white;">
                    {{ $tripStatus->status }}
                </span>
            @else  {{-- Otherwise, treat it as a string --}}
                <span class="badge rounded-pill px-3 py-2" style="
                    background-color:
                        {{ $tripStatus == 'ongoing' ? '#28a745' :
                        ($tripStatus == 'pending' ? '#ffc107' :
                        ($tripStatus == 'Status not set yet' ? '#dc3545' :
                        ($tripStatus == 'finished' ? '#6c757d' : '#ffc107'))) }};
                    color: white;">
                    {{ $tripStatus }}
                </span>
            @endif
        </div>


        <!-- Grand Total Section -->
        <div class="mb-4">
            <h3 class="text-dark fw-bold mb-2">Grand Total:</h3>
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <span class="h4 text-primary">
                        {{ $itinerary->trip->currency }} {{ number_format($grandTotal, 2, '.', ',') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Leftover Budget Section -->
        <div class="mb-4">
            <h4 class="fw-bold text-dark mt-4">Leftover Budget:</h4>
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <span class="h4 {{ $leftover < 0 ? 'text-danger fw-bold' : 'text-success' }}">
                        {{ $currency }} {{ number_format($leftover, 2, '.', ',') }}
                    </span>
                </div>
            </div>
        </div>


        <!-- Budget Exceeded Warning -->
        @if ($leftover < 0)
            <div class="alert alert-warning">
                <strong>Warning:</strong> Your budget is exceeded by {{ abs($leftover) }} {{ $currency }}. Please adjust your itinerary accordingly.
            </div>
        @endif

        <!-- Error Alert -->
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


    </div>



    <div class="mb-4 border rounded p-3 bg-gray-50 !important">
        <h3 class="text-xl font-semibold text-gray-900 !important">Trip Suggestions</h3>
        <div class="space-y-4 !important">
            <details class="bg-gray-100 p-2 rounded-md hover:bg-gray-200 transition !important">
                <summary class="font-semibold text-gray-800 cursor-pointer !important">Budget</summary>
                <ul class="text-gray-700 list-none pl-5 space-y-1 !important">
                    @foreach (explode("\n", $budgetTips) as $item)
                        @if (trim($item) !== "")
                            <li class="text-sm !important">{{ str_replace(['*', '**', '***'], '', $item) }}</li>
                        @endif
                    @endforeach
                </ul>
            </details>
            <details class="bg-gray-100 p-2 rounded-md hover:bg-gray-200 transition !important">
                <summary class="font-semibold text-gray-800 cursor-pointer !important">Weather</summary>
                <ul class="text-gray-700 list-none pl-5 space-y-1 !important">
                    @foreach (explode("\n", str_replace(['*', '**', '***'], '', $weatherInfo)) as $weatherPoint)
                        @if (trim($weatherPoint) !== "")
                            <li class="text-sm !important">{{ $weatherPoint }}</li>
                        @endif
                    @endforeach
                </ul>
            </details>
            <details class="bg-gray-100 p-2 rounded-md hover:bg-gray-200 transition !important">
                <summary class="font-semibold text-gray-800 cursor-pointer !important">Culture Tips</summary>
                <ul class="text-gray-700 list-none pl-5 space-y-1 !important">
                    @foreach (explode("\n", str_replace('- ', '', $cultureTips)) as $tip)
                        @if (trim($tip) !== "")
                            <li class="text-sm !important">{{ str_replace(['*', '**', '***'], '', $tip) }}</li>
                        @endif
                    @endforeach
                </ul>
            </details>
        </div>
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
                <button type="submit" class="btn btn-outline-primary me-2">Edit Day Plan</button>
                <button type="button" class="btn btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#breakdownModal">Show Breakdown</button>
                <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editTripModal">Edit Trip Details</button>
            </div>
        </div>
    </form>


    <div class="d-flex justify-content-center mt-3">
        <div class="btn-group">
            <!-- Save as Final (Ongoing) -->
            <form action="{{ route('trip.updateStatus', ['trip' => $trip_id, 'status' => 'ongoing']) }}" method="POST" style="margin-right: 10px;">
                @csrf
                <button type="submit" class="btn btn-gradient btn-sm rounded shadow-sm" style="background: linear-gradient(90deg, #4CAF50 0%, #81C784 100%); border: none;">
                    <i class="fas fa-play me-1"></i> Finalize Trip
                </button>
            </form>

            <!-- Dropdown button for other actions -->
            <div class="dropdown">
                <button type="button" class="btn btn-light dropdown-toggle btn-sm rounded shadow-sm" data-bs-toggle="dropdown" aria-expanded="false" id="actionDropdown" style="border: 1px solid #dee2e6;">
                    <i class="fas fa-ellipsis-v me-1"></i> More Actions
                </button>

                <ul class="dropdown-menu" aria-labelledby="actionDropdown" style="min-width: 200px;">
                    <!-- Save as Draft (Pending) -->
                    <li>
                        <form action="{{ route('trip.updateStatus', ['trip' => $trip_id, 'status' => 'pending']) }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center">
                                <i class="fas fa-file-alt text-secondary me-2"></i>
                                Save as Draft
                            </button>
                        </form>
                    </li>

                    <!-- Only show End Trip (Finished) if status is not null -->
                    @if($tripStatus !== null)
                        <li>
                            <form action="{{ route('trip.updateStatus', ['trip' => $trip_id, 'status' => 'finished']) }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center">
                                    <i class="fas fa-stop-circle text-danger me-2"></i>
                                    End Trip
                                </button>
                            </form>
                        </li>

                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item d-flex align-items-center" href="#"><i class="fas fa-copy text-primary me-2"></i> Duplicate Trip</a></li>
                        <li><a class="dropdown-item d-flex align-items-center" href="#" data-toggle="modal" data-target="#shareModal" data-trip-id="{{ $trip->id }}"><i class="fas fa-share-alt text-info me-2"></i> Share Trip</a></li>
                        <li><a class="dropdown-item d-flex align-items-center" href="{{ route('trip.downloadICS', ['itineraryId' => $itinerary->id]) }}"><i class="fas fa-calendar-plus text-success me-2"></i> Create Reminder</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal"><i class="fas fa-trash-alt me-2"></i> Delete Trip</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>



    <!-- Include the modal component -->
    @include('components.share-trip-modal', ['friends' => $friends])


    <!-- Modal for Confirming Deletion -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 90%; max-height: 90vh;">
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
                        <div class="mb-3">
                            <label for="goals" class="form-label">Goals</label>
                            <textarea class="form-control" id="goals" name="goals" rows="3">{{ $itinerary->trip->goals }}</textarea>
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
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 90%; max-height: 90vh;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="breakdownModalLabel">Trip Breakdown</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        @foreach($days as $key => $day)
                            <div id="day{{ $day->day }}" class="day-breakdown col mb-4">
                                <div class="card h-100">
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
                                            <span class="h5 mb-0 text-black">{{ $dayGrandTotals[$key] ?? 'N/A' }} {{ $trip->currency }}</span>
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

<style>

    /* Ensure modal body handles overflow correctly */
    .modal-body {
        max-height: 80vh;
        overflow-y: auto;
        padding-right: 15px; /* Ensure padding doesn't cause horizontal scroll */
    }

    /* Optional: Modify max-height to fit design */
    .modal-dialog {
        max-width: 90%; /* Ensure the modal isn't too wide */
    }

    .modal-content {
        border-radius: 0.5rem; /* Optional: Improve the modal's appearance */
    }

    .card-header {
        background-color: #246351 !important;
        color: white !important;
    }

    .mb-4.border.rounded.p-3.bg-gray-50 {
        background-color: #f9fafb !important; /* Light gray background for sections */
    }

    h3.text-xl.font-semibold.text-gray-900 {
        color: #1f2937 !important; /* Dark gray color for headings */
    }

    .details.bg-gray-100.p-2.rounded-md.hover\:bg-gray-200.transition {
        background-color: #f3f4f6 !important; /* Light gray for details background */
    }

    .details:hover {
        background-color: #e5e7eb !important; /* Hover effect for details */
    }

    ul.text-gray-700.list-none.pl-5.space-y-1 li {
        color: #4b5563 !important; /* Dark gray color for list items */
        font-size: 0.875rem !important; /* Slightly smaller font size for list items */
    }

    h3.mt-4, .h5.mb-0, .text-black {
        color: #1f2937 !important; /* Uniform text color for headings and important text */
    }

    .badge {
        font-size: 14px;  /* Adjust font size */
        font-weight: bold;
    }

    .badge-primary {
        background-color: #007bff;
        color: white !important; /* Ensure text inside is white */
    }

    .badge-success {
        background-color: #28a745;
        color: white !important; /* Ensure text inside is white */
    }

    .badge-info {
        background-color: #17a2b8;
        color: white !important; /* Ensure text inside is white */
    }

    .badge-warning {
        background-color: #ffc107;
        color: black !important; /* Ensure text inside is black */
    }



    .dropdown-menu {
        background-color: #f8f9fa !important;
    }

    .dropdown-item:hover {
        background-color: #e9ecef !important;
    }

    .card-header {
        background-color: #246351 !important; /* Deep teal for card headers */
        color: #fff !important; /* White text for contrast */
    }

    .card-body {
        background-color: #f3f4f6 !important; /* Light gray for the card body */
    }

    .text-danger {
        color: #dc3545 !important; /* Red for danger messages */
    }

    .text-warning {
        color: #ffc107 !important; /* Yellow for warnings */
    }

    .text-success {
        color: #28a745 !important; /* Green for success messages */
    }

    .dropdown-item {
        padding: 0.5rem 1rem; /* Adjust padding for better spacing */
    }
    .btn {
        margin: 0 5px; /* Margin for buttons */
    }

    .btn:hover {
       opacity: 0.9;
    }
    .dropdown-item:hover {
        background-color: #f7f7f7;
    }




</style>

<script>
    document.getElementById('tripDay').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        document.getElementById('selectedDate').value = selectedOption.getAttribute('data-date');
    });

    // Set the date when the page first loads
    document.getElementById('tripDay').dispatchEvent(new Event('change'));

    function toggleSection(button) {
        const section = button.nextElementSibling;
        section.classList.toggle('hidden');
    }

    $('#shareModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var tripId = button.data('trip-id'); // Extract the trip_id from the data-trip-id attribute

        var modal = $(this);
        modal.find('#trip_id').val(tripId); // Set the trip_id input field with the trip ID
    });

    // Initialize scrollspy
    const dataSpyList = document.querySelector('#dayTabs');
                    const scrollSpy = new bootstrap.ScrollSpy(document.body, {
                        target: '#dayTabs',
                        offset: 100
                    });


</script>



@endsection


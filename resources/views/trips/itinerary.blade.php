@extends('layouts.app')

@section('title', 'Itinerary')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
<div class="container mt-5">
    <h2 class="text-center mb-4">Itinerary for Your Trip</h2>
    <p class="text-center mb-4">Plan your adventure day by day with details of activities, transport, accommodation, and more.</p>

    <!-- Select Day of the Trip -->
    <div class="mb-4">
        <label for="tripDay" class="form-label">Select Day of Your Trip:</label>
        <select class="form-select" id="tripDay">
            @for ($day = 1; $day <= $trip->total_days; $day++)
                <option value="{{ $day }}">Day {{ $day }}</option>
            @endfor
        </select>
    </div>



    <div id="itineraryList" class="mb-4 border rounded p-3">
        <h3 class="section-title">Your Itinerary</h3>
        <div class="row">
            <div class="col-md-4 mb-3" id="itineraryItems">
                <div class="border rounded p-3 text-center" id="emptyItinerary" style="display: none;">
                    <p class="text-muted">No itinerary items added yet. Please add some!</p>
                </div>

                <!-- Existing itinerary items -->
                <div class="card border-primary mb-3">
                    <div class="card-header text-center">
                        <h5>Activities</h5>
                    </div>
                    <div class="card-body text-center">
                        <p class="card-text">Start Time - End Time</p>
                        <p class="card-text">Budget: $...</p>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#activitiesModal" onclick="editItinerary('Activity details...')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteItem(this)">Delete</button>
                    </div>
                </div>

                <!-- Additional cards for Transport, Accommodation, and Flights -->
                <div class="card border-success mb-3">
                    <div class="card-header text-center">
                        <h5>Transport</h5>
                    </div>
                    <div class="card-body text-center">
                        <p class="card-text">Start Time - End Time</p>
                        <p class="card-text">Budget: $...</p>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#transportModal" onclick="editTransport('Transport details...')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteItem(this)">Delete</button>
                    </div>
                </div>

                <div class="card border-info mb-3">
                    <div class="card-header text-center">
                        <h5>Accommodation</h5>
                    </div>
                    <div class="card-body text-center">
                        <p class="card-text">Check-in/Check-out</p>
                        <p class="card-text">Budget: $...</p>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#accommodationModal" onclick="editAccommodation('Accommodation details...')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteItem(this)">Delete</button>
                    </div>
                </div>

                <div class="card border-warning mb-3">
                    <div class="card-header text-center">
                        <h5>Flight</h5>
                    </div>
                    <div class="card-body text-center">
                        <p class="card-text">Flight Number: XYZ123</p>
                        <p class="card-text">Departure: 10:00 AM</p>
                        <p class="card-text">Arrival: 12:00 PM</p>
                        <p class="card-text">Cost: $200</p>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#flightModal" onclick="editFlight('Flight details...')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteItem(this)">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mb-4 d-flex align-items-center justify-content-center">
        <!-- Dropdown for managing itinerary -->
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

    <!-- Estimated Total Cost Section -->
    <div class="border rounded p-3 mb-4">
        <h4 class="text-center">Estimated Total Cost</h4>
        <p>Transport: $...</p>
        <p>Accommodation: $...</p>
        <p>Activities & Entrance Fees: $...</p>
        <p>Food: $...</p>
        <hr>
        <h5 class="text-danger">Total: $...</h5>
    </div>

    <!-- Notes Section -->
    <div class="border rounded p-3">
        <h4 class="text-center">Notes</h4>
        <textarea class="form-control" rows="5" placeholder="Write additional notes or reminders here..."></textarea>
    </div>

    <!-- button save itinarary and button submit itianry Section -->
    <div>

    </div>

</div>

<!-- Activities Modal -->
<div class="modal fade" id="activitiesModal" tabindex="-1" aria-labelledby="activitiesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="activitiesModalLabel">Add/Edit Activities</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="activitiesForm">
                    <div class="mb-3">
                        <label for="activityTitle" class="form-label">Activity Title</label>
                        <input type="text" class="form-control" id="activityTitle" placeholder="Enter activity title" required>
                    </div>

                    <!-- Start Time and End Time Inputs Side by Side -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="startTime" class="form-label">Start Time</label>
                            <input type="time" class="form-control" id="activityStartTime" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="endTime" class="form-label">End Time</label>
                            <input type="time" class="form-control" id="activityEndTime" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="activityBudget" class="form-label">Estimated Budget</label>
                        <input type="number" class="form-control" id="activityBudget" placeholder="Enter budget" required>
                    </div>

                    <div class="mb-3">
                        <label for="activityDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="activityDescription" rows="3" placeholder="Add more details about the activity..." required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveActivityButton">Save Activity</button>
            </div>
        </div>
    </div>
</div>

<!-- Transport Modal -->
<div class="modal fade" id="transportModal" tabindex="-1" aria-labelledby="transportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transportModalLabel">Add/Edit Transport</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="transportForm">
                    <div class="mb-3">
                        <label for="transportType" class="form-label">Transport Type</label>
                        <input type="text" class="form-control" id="transportType" placeholder="Enter transport type" required>
                    </div>

                    <div class="mb-3">
                        <label for="transportStartTime" class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="transportStartTime" required>
                    </div>

                    <div class="mb-3">
                        <label for="transportEndTime" class="form-label">End Time</label>
                        <input type="time" class="form-control" id="transportEndTime" required>
                    </div>

                    <div class="mb-3">
                        <label for="transportBudget" class="form-label">Estimated Budget</label>
                        <input type="number" class="form-control" id="transportBudget" placeholder="Enter budget" required>
                    </div>

                    <div class="mb-3">
                        <label for="transportDetails" class="form-label">Details</label>
                        <textarea class="form-control" id="transportDetails" rows="3" placeholder="Add more details about the transport..." required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveTransportButton">Save Transport</button>
            </div>
        </div>
    </div>
</div>

<!-- Accommodation Modal -->
<div class="modal fade" id="accommodationModal" tabindex="-1" aria-labelledby="accommodationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="accommodationModalLabel">Add/Edit Accommodation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="accommodationForm">
                    <div class="mb-3">
                        <label for="accommodationName" class="form-label">Accommodation Name</label>
                        <input type="text" class="form-control" id="accommodationName" placeholder="Enter accommodation name" required>
                    </div>

                    <div class="mb-3">
                        <label for="checkIn" class="form-label">Check-in Date</label>
                        <input type="date" class="form-control" id="checkIn" required>
                    </div>

                    <div class="mb-3">
                        <label for="checkOut" class="form-label">Check-out Date</label>
                        <input type="date" class="form-control" id="checkOut" required>
                    </div>

                    <div class="mb-3">
                        <label for="accommodationBudget" class="form-label">Estimated Budget</label>
                        <input type="number" class="form-control" id="accommodationBudget" placeholder="Enter budget" required>
                    </div>

                    <div class="mb-3">
                        <label for="accommodationDetails" class="form-label">Details</label>
                        <textarea class="form-control" id="accommodationDetails" rows="3" placeholder="Add more details about the accommodation..." required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveAccommodationButton">Save Accommodation</button>
            </div>
        </div>
    </div>
</div>

<!-- Flight Modal -->
<div class="modal fade" id="flightModal" tabindex="-1" aria-labelledby="flightModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="flightModalLabel">Add/Edit Flight</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="flightForm">
                    <div class="mb-3">
                        <label for="flightNumber" class="form-label">Flight Number</label>
                        <input type="text" class="form-control" id="flightNumber" placeholder="Enter flight number" required>
                    </div>

                    <div class="mb-3">
                        <label for="departureTime" class="form-label">Departure Time</label>
                        <input type="time" class="form-control" id="departureTime" required>
                    </div>

                    <div class="mb-3">
                        <label for="arrivalTime" class="form-label">Arrival Time</label>
                        <input type="time" class="form-control" id="arrivalTime" required>
                    </div>

                    <div class="mb-3">
                        <label for="flightCost" class="form-label">Flight Cost</label>
                        <input type="number" class="form-control" id="flightCost" placeholder="Enter flight cost" required>
                    </div>

                    <div class="mb-3">
                        <label for="flightDetails" class="form-label">Details</label>
                        <textarea class="form-control" id="flightDetails" rows="3" placeholder="Add more details about the flight..." required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveFlightButton">Save Flight</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to delete an item from the itinerary
    function deleteItem(button) {
        const card = button.closest('.card');
        card.remove();

        // Show empty itinerary message if no items left
        checkIfItineraryEmpty();
    }

    // Function to check if the itinerary is empty
    function checkIfItineraryEmpty() {
        const itineraryItems = document.getElementById('itineraryItems');
        const emptyItinerary = document.getElementById('emptyItinerary');
        emptyItinerary.style.display = itineraryItems.children.length === 0 ? 'block' : 'none';
    }

    // Function to reset the itinerary form
    function resetItineraryForm() {
        document.getElementById('itineraryForm').reset();
        const itineraryModal = new bootstrap.Modal(document.getElementById('itineraryModal'));
        itineraryModal.hide();

        // Hide empty itinerary message
        document.getElementById('emptyItinerary').style.display = 'none';
    }

    // Similar event listeners for transport, accommodation, and flight modals can be added here.
</script>


@endsection

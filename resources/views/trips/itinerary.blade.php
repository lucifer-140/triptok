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
            <button type="button" class="btn btn-primary">Save Day Plan</button>
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

    <!-- Accomodation Modal -->
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
                            <div class="input-group">
                                <input type="number" class="form-control" id="activityBudget" placeholder="Enter budget" required>
                                <span class="input-group-text">{{ $currency }}</span> <!-- Add currency here -->
                            </div>
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
                            <input type="text" class="form-control" id="transportType" placeholder="e.g., Train, Bus" required>
                        </div>
                        <div class="mb-3">
                            <label for="transportTime" class="form-label">Departure Time</label>
                            <input type="time" class="form-control" id="transportTime" required>
                        </div>
                        <div class="mb-3">
                            <label for="transportCost" class="form-label">Cost</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="transportCost" placeholder="Enter cost" required>
                                <span class="input-group-text">{{ $currency }}</span> <!-- Add currency here -->
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="transportNotes" class="form-label">Notes</label>
                            <textarea class="form-control" id="transportNotes" rows="3" placeholder="Additional details..."></textarea>
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
                            <input type="text" class="form-control" id="accommodationName" placeholder="e.g., Hotel, Hostel" required>
                        </div>
                        <div class="mb-3">
                            <label for="accommodationCheckIn" class="form-label">Check-In Date</label>
                            <input type="date" class="form-control" id="accommodationCheckIn" required>
                        </div>
                        <div class="mb-3">
                            <label for="accommodationCheckOut" class="form-label">Check-Out Date</label>
                            <input type="date" class="form-control" id="accommodationCheckOut" required>
                        </div>
                        <div class="mb-3">
                            <label for="accommodationCost" class="form-label">Accommodation Cost</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="accommodationCost" placeholder="Enter Accommodation Cost" required>
                                <span class="input-group-text">{{ $currency }}</span> <!-- Add currency here -->
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="accommodationNotes" class="form-label">Notes</label>
                            <textarea class="form-control" id="accommodationNotes" rows="3" placeholder="Additional details..."></textarea>
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
                            <label for="flightDate" class="form-label">Flight Date</label>
                            <input type="date" class="form-control" id="flightDate" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="flightDepartureTime" class="form-label">Departure Time</label>
                                <input type="time" class="form-control" id="flightDepartureTime" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="flightArrivalTime" class="form-label">Estimated Arrival Time</label>
                                <input type="time" class="form-control" id="flightArrivalTime" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="flightCost" class="form-label">Cost</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="flightCost" placeholder="Enter flight cost" required>
                                <span class="input-group-text">{{ $currency }}</span> <!-- Add currency here -->
                            </div>
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




</div>

<script>

// JavaScript for dynamically adding itinerary items
document.getElementById('saveActivityButton').addEventListener('click', function() {
    const activityTitle = document.getElementById('activityTitle').value;
    const startTime = document.getElementById('activityStartTime').value;
    const endTime = document.getElementById('activityEndTime').value;
    const activityBudget = document.getElementById('activityBudget').value;
    const activityDescription = document.getElementById('activityDescription').value;

    // Update existing card or add new card
    const existingCard = document.querySelector('.card.border-primary'); // Assuming only one edit at a time
    if (existingCard) {
        // Update existing card's content
        existingCard.querySelector('.card-header h5').textContent = activityTitle;
        existingCard.querySelector('.card-body .card-text:nth-child(1)').textContent = `${startTime} - ${endTime}`;
        existingCard.querySelector('.card-body .card-text:nth-child(2)').textContent = `Budget: $${activityBudget}`;
        existingCard.querySelector('.card-body .card-text:nth-child(3)').textContent = activityDescription;
    } else {
        // Create a new card if not editing
        if (activityTitle && startTime && endTime && activityBudget && activityDescription) {
            const itineraryContainer = document.getElementById('itineraryItems');
            const emptyItinerary = document.getElementById('emptyItinerary');

            emptyItinerary.style.display = 'none';

            const newCard = document.createElement('div');
            newCard.classList.add('card', 'border-primary', 'mb-3');
            newCard.innerHTML = `
                <div class="card-header text-center">
                    <h5>${activityTitle}</h5>
                </div>
                <div class="card-body text-center">
                    <p class="card-text">${startTime} - ${endTime}</p>
                    <p class="card-text">Budget: $${activityBudget}</p>
                    <p class="card-text">${activityDescription}</p>
                </div>
                <div class="card-footer d-flex justify-content-center">
                    <button class="btn btn-warning btn-sm me-1" onclick="editItem(this)">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteItem(this)">Delete</button>
                </div>
            `;
            itineraryContainer.appendChild(newCard);
        }
    }

    // Clear the form and close the modal
    document.getElementById('activitiesForm').reset();
    const activitiesModal = bootstrap.Modal.getInstance(document.getElementById('activitiesModal'));
    activitiesModal.hide();
});

// JavaScript for dynamically adding Transport items
document.getElementById('saveTransportButton').addEventListener('click', function() {
    const transportType = document.getElementById('transportType').value;
    const transportTime = document.getElementById('transportTime').value;
    const transportCost = document.getElementById('transportCost').value;
    const transportNotes = document.getElementById('transportNotes').value;

    // Update existing card or add new card
    const existingCard = document.querySelector('.card.border-success');
    if (existingCard) {
        existingCard.querySelector('.card-header h5').textContent = transportType;
        existingCard.querySelector('.card-body .card-text:nth-child(1)').textContent = `Time: ${transportTime}`;
        existingCard.querySelector('.card-body .card-text:nth-child(2)').textContent = `Cost: $${transportCost}`;
        existingCard.querySelector('.card-body .card-text:nth-child(3)').textContent = transportNotes;
    } else {
        // Create a new card if not editing
        if (transportType && transportTime && transportCost) {
            const itineraryContainer = document.getElementById('itineraryItems');
            document.getElementById('emptyItinerary').style.display = 'none';

            const newCard = document.createElement('div');
            newCard.classList.add('card', 'border-success', 'mb-3');
            newCard.innerHTML = `
                <div class="card-header text-center">
                    <h5>${transportType}</h5>
                </div>
                <div class="card-body text-center">
                    <p class="card-text">Time: ${transportTime}</p>
                    <p class="card-text">Cost: $${transportCost}</p>
                    <p class="card-text">${transportNotes}</p>
                </div>
                <div class="card-footer d-flex justify-content-center">
                    <button class="btn btn-warning btn-sm me-1" onclick="editItem(this)">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteItem(this)">Delete</button>
                </div>
            `;
            itineraryContainer.appendChild(newCard);
        }
    }

    document.getElementById('transportForm').reset();
    const transportModal = bootstrap.Modal.getInstance(document.getElementById('transportModal'));
    transportModal.hide();
});

// JavaScript for dynamically adding Accommodation items
document.getElementById('saveAccommodationButton').addEventListener('click', function() {
    const accommodationName = document.getElementById('accommodationName').value;
    const checkIn = document.getElementById('accommodationCheckIn').value;
    const checkOut = document.getElementById('accommodationCheckOut').value;
    const accommodationCost = document.getElementById('accommodationCost').value;
    const accommodationNotes = document.getElementById('accommodationNotes').value;

    // Update existing card or add new card
    const existingCard = document.querySelector('.card.border-info');
    if (existingCard) {
        existingCard.querySelector('.card-header h5').textContent = accommodationName;
        existingCard.querySelector('.card-body .card-text:nth-child(1)').textContent = `Check-in: ${checkIn}`;
        existingCard.querySelector('.card-body .card-text:nth-child(2)').textContent = `Check-out: ${checkOut}`;
        existingCard.querySelector('.card-body .card-text:nth-child(3)').textContent = `Accommodation Cost: $${accommodationCost}`;
        existingCard.querySelector('.card-body .card-text:nth-child(4)').textContent = accommodationNotes;
    } else {
        // Create a new card if not editing
        if (accommodationName && checkIn && checkOut && accommodationCost) {
            const itineraryContainer = document.getElementById('itineraryItems');
            document.getElementById('emptyItinerary').style.display = 'none';

            const newCard = document.createElement('div');
            newCard.classList.add('card', 'border-info', 'mb-3');
            newCard.innerHTML = `
                <div class="card-header text-center">
                    <h5>${accommodationName}</h5>
                </div>
                <div class="card-body text-center">
                    <p class="card-text">Check-in: ${checkIn}</p>
                    <p class="card-text">Check-out: ${checkOut}</p>
                    <p class="card-text">Accommodation Cost: $${accommodationCost}</p>
                    <p class="card-text">${accommodationNotes}</p>
                </div>
                <div class="card-footer d-flex justify-content-center">
                    <button class="btn btn-warning btn-sm me-1" onclick="editItem(this)">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteItem(this)">Delete</button>
                </div>
            `;
            itineraryContainer.appendChild(newCard);
        }
    }

    document.getElementById('accommodationForm').reset();
    const accommodationModal = bootstrap.Modal.getInstance(document.getElementById('accommodationModal'));
    accommodationModal.hide();
});

// JavaScript for dynamically adding Flight items
document.getElementById('saveFlightButton').addEventListener('click', function() {
    const flightNumber = document.getElementById('flightNumber').value;
    const flightDate = document.getElementById('flightDate').value;
    const departureTime = document.getElementById('flightDepartureTime').value;
    const arrivalTime = document.getElementById('flightArrivalTime').value;
    const flightCost = document.getElementById('flightCost').value;

    // Update existing card or add new card
    const existingCard = document.querySelector('.card.border-warning');
    if (existingCard) {
        existingCard.querySelector('.card-header h5').textContent = `Flight ${flightNumber}`;
        existingCard.querySelector('.card-body .card-text:nth-child(1)').textContent = `Date: ${flightDate}`;
        existingCard.querySelector('.card-body .card-text:nth-child(2)').textContent = `Departure: ${departureTime}`;
        existingCard.querySelector('.card-body .card-text:nth-child(3)').textContent = `Arrival: ${arrivalTime}`;
        existingCard.querySelector('.card-body .card-text:nth-child(4)').textContent = `Cost: $${flightCost}`;
    } else {
        // Create a new card if not editing
        if (flightNumber && flightDate && departureTime && arrivalTime && flightCost) {
            const itineraryContainer = document.getElementById('itineraryItems');
            document.getElementById('emptyItinerary').style.display = 'none';

            const newCard = document.createElement('div');
            newCard.classList.add('card', 'border-warning', 'mb-3');
            newCard.innerHTML = `
                <div class="card-header text-center">
                    <h5>Flight ${flightNumber}</h5>
                </div>
                <div class="card-body text-center">
                    <p class="card-text">Date: ${flightDate}</p>
                    <p class="card-text">Departure: ${departureTime}</p>
                    <p class="card-text">Arrival: ${arrivalTime}</p>
                    <p class="card-text">Cost: $${flightCost}</p>
                </div>
                <div class="card-footer d-flex justify-content-center">
                    <button class="btn btn-warning btn-sm me-1" onclick="editItem(this)">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteItem(this)">Delete</button>
                </div>
            `;
            itineraryContainer.appendChild(newCard);
        }
    }

    document.getElementById('flightForm').reset();
    const flightModal = bootstrap.Modal.getInstance(document.getElementById('flightModal'));
    flightModal.hide();
});

// Function to edit an item
function editItem(button) {
    const card = button.closest('.card');
    const header = card.querySelector('.card-header h5').textContent;
    const timeAndBudget = card.querySelectorAll('.card-body .card-text');

    if (card.classList.contains('border-primary')) {
        document.getElementById('activityTitle').value = header;
        const [time, budget, description] = Array.from(timeAndBudget).map(p => p.textContent);
        const [startTime, endTime] = time.split(' - ');
        document.getElementById('activityStartTime').value = startTime;
        document.getElementById('activityEndTime').value = endTime;
        document.getElementById('activityBudget').value = budget.replace('Budget: $', '');
        document.getElementById('activityDescription').value = description;

        // Show the activities modal
        const activitiesModal = new bootstrap.Modal(document.getElementById('activitiesModal'));
        activitiesModal.show();

        // Add an event listener to the modal's "hide" event
        activitiesModal.addEventListener('hide.bs.modal', function () {
            // Clear the form
            document.getElementById('activitiesForm').reset();
        });

    } else if (card.classList.contains('border-success')) {
        document.getElementById('transportType').value = header;
        const [time, cost, notes] = Array.from(timeAndBudget).map(p => p.textContent);
        document.getElementById('transportTime').value = time.replace('Time: ', '');
        document.getElementById('transportCost').value = cost.replace('Cost: $', '');
        document.getElementById('transportNotes').value = notes;

        // Show the transport modal
        const transportModal = new bootstrap.Modal(document.getElementById('transportModal'));
        transportModal.show();

        // Add an event listener to the modal's "hide" event
        transportModal.addEventListener('hide.bs.modal', function () {
            // Clear the form
            document.getElementById('transportForm').reset();
        });

    } else if (card.classList.contains('border-info')) {
        document.getElementById('accommodationName').value = header;
        const [checkIn, checkOut, cost, notes] = Array.from(timeAndBudget).map(p => p.textContent);
        document.getElementById('accommodationCheckIn').value = checkIn.replace('Check-in: ', '');
        document.getElementById('accommodationCheckOut').value = checkOut.replace('Check-out: ', '');
        document.getElementById('accommodationCost').value = cost.replace('Accommodation Cost: $', '');
        document.getElementById('accommodationNotes').value = notes;

        // Show the accommodation modal
        const accommodationModal = new bootstrap.Modal(document.getElementById('accommodationModal'));
        accommodationModal.show();

        // Add an event listener to the modal's "hide" event
        accommodationModal.addEventListener('hide.bs.modal', function () {
            // Clear the form
            document.getElementById('accommodationForm').reset();
        });

    } else if (card.classList.contains('border-warning')) {
        document.getElementById('flightNumber').value = header.replace('Flight ', '');
        const [date, departure, arrival, cost] = Array.from(timeAndBudget).map(p => p.textContent);
        document.getElementById('flightDate').value = date.replace('Date: ', '');
        document.getElementById('flightDepartureTime').value = departure.replace('Departure: ', '');
        document.getElementById('flightArrivalTime').value = arrival.replace('Arrival: ', '');
        document.getElementById('flightCost').value = cost.replace('Cost: $', '');

        // Show the flight modal
        const flightModal = new bootstrap.Modal(document.getElementById('flightModal'));
        flightModal.show();

        // Add an event listener to the modal's "hide" event
        flightModal.addEventListener('hide.bs.modal', function () {
            // Clear the form
            document.getElementById('flightForm').reset();
        });
    }
}


// Function to delete an item
function deleteItem(button) {
    const card = button.closest('.card');
    card.remove();
    const itineraryContainer = document.getElementById('itineraryItems');
    if (itineraryContainer.children.length === 0) {
        document.getElementById('emptyItinerary').style.display = 'block';
    }
}


</script>
@endsection

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

    // Update existing card or add new card
    const existingCard = document.querySelector('.card.border-success');
    if (existingCard) {
        existingCard.querySelector('.card-header h5').textContent = transportType;
        existingCard.querySelector('.card-body .card-text:nth-child(1)').textContent = `Time: ${transportTime}`;
        existingCard.querySelector('.card-body .card-text:nth-child(2)').textContent = `Cost: $${transportCost}`;
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

    // Update existing card or add new card
    const existingCard = document.querySelector('.card.border-info');
    if (existingCard) {
        existingCard.querySelector('.card-header h5').textContent = accommodationName;
        existingCard.querySelector('.card-body .card-text:nth-child(1)').textContent = `Check-in: ${checkIn}`;
        existingCard.querySelector('.card-body .card-text:nth-child(2)').textContent = `Check-out: ${checkOut}`;
        existingCard.querySelector('.card-body .card-text:nth-child(3)').textContent = `Accommodation Cost: $${accommodationCost}`;
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



document.addEventListener('DOMContentLoaded', function() {
    const saveDayPlanButton = document.getElementById('saveDayPlanButton');
    const tripDaySelect = document.getElementById('tripDay');
    const itineraryId = {{ $itinerary->id }}; // Pass the itinerary ID from Laravel

    let activities = [];
    let transports = [];
    let accommodations = [];
    let flights = [];
    let days = [];  // Array to hold day information

    saveDayPlanButton.addEventListener('click', function() {
        const selectedOption = tripDaySelect.options[tripDaySelect.selectedIndex];
        const day = selectedOption.value;
        const dayText = selectedOption.textContent;

        const dateMatch = dayText.match(/\(([^)]+)\)/);
        const date = dateMatch ? dateMatch[1] : '';

        // Check if this day has already been added
        if (days.some(d => d.day === day)) {
            alert(`Day ${day} has already been added.`);
            return;
        }

        // Save day information
        days.push({ itinerary_id: itineraryId, day: day, date: date });

        // Gather data from the respective inputs
        gatherActivityData();
        gatherTransportData();
        gatherAccommodationData();
        gatherFlightData();

        console.log("Days:", days);
        console.log("Activities:", activities);
        console.log("Transports:", transports);
        console.log("Accommodations:", accommodations);
        console.log("Flights:", flights);

        // Send this data to the backend for database storage
        sendToDatabase(days, activities, transports, accommodations, flights);

        // Clear arrays for the next day or trip
        activities = [];
        transports = [];
        accommodations = [];
        flights = [];
    });

    function gatherActivityData() {
        const activityData = {
            title: document.getElementById('activityTitle').value,
            start_time: document.getElementById('activityStartTime').value,
            end_time: document.getElementById('activityEndTime').value,
            estimated_budget: document.getElementById('activityBudget').value,
            description: document.getElementById('activityDescription').value
        };
        activities.push(activityData);
        console.log("Added Activity:", activityData);
        clearActivityFields();
    }

    function gatherTransportData() {
        const transportData = {
            type: document.getElementById('transportType').value,
            departure_time: document.getElementById('transportDepartureTime').value,
            cost: document.getElementById('transportCost').value
        };
        transports.push(transportData);
        console.log("Added Transport:", transportData);
        clearTransportFields();
    }

    function gatherAccommodationData() {
        const accommodationData = {
            name: document.getElementById('accommodationName').value,
            check_in_date: document.getElementById('accommodationCheckIn').value,
            check_out_date: document.getElementById('accommodationCheckOut').value,
            cost: document.getElementById('accommodationCost').value
        };
        accommodations.push(accommodationData);
        console.log("Added Accommodation:", accommodationData);
        clearAccommodationFields();
    }

    function gatherFlightData() {
        const flightData = {
            flight_number: document.getElementById('flightNumber').value,
            date: document.getElementById('flightDate').value,
            departure_time: document.getElementById('flightDepartureTime').value,
            arrival_time: document.getElementById('flightArrivalTime').value,
            cost: document.getElementById('flightCost').value
        };
        flights.push(flightData);
        console.log("Added Flight:", flightData);
        clearFlightFields();
    }

    async function sendToDatabase(days, activities, transports, accommodations, flights) {
        try {
            const itineraryId = document.getElementById('itineraryId').value; // Make sure you have this element on your page

            // Get the CSRF token from the meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const response = await fetch('{{ route('itinerary.save') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Include CSRF token for security
                },
                body: JSON.stringify({
                    itinerary_id: itineraryId,  // Add the itinerary_id to the request
                    days,
                    activities,
                    transports,
                    accommodations,
                    flights
                }),
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const result = await response.json();
            console.log('Data saved successfully:', result);
            // Optionally update the UI to reflect saved data
        } catch (error) {
            console.error('Error saving data:', error);
        }
    }


    // Clear input fields functions
    function clearActivityFields() {
        document.getElementById('activityTitle').value = '';
        document.getElementById('activityStartTime').value = '';
        document.getElementById('activityEndTime').value = '';
        document.getElementById('activityBudget').value = '';
        document.getElementById('activityDescription').value = '';
    }

    function clearTransportFields() {
        document.getElementById('transportType').value = '';
        document.getElementById('transportDepartureTime').value = '';
        document.getElementById('transportCost').value = '';
    }

    function clearAccommodationFields() {
        document.getElementById('accommodationName').value = '';
        document.getElementById('accommodationCheckIn').value = '';
        document.getElementById('accommodationCheckOut').value = '';
        document.getElementById('accommodationCost').value = '';
    }

    function clearFlightFields() {
        document.getElementById('flightNumber').value = '';
        document.getElementById('flightDate').value = '';
        document.getElementById('flightDepartureTime').value = '';
        document.getElementById('flightArrivalTime').value = '';
        document.getElementById('flightCost').value = '';
    }
});


</script>


@endsection

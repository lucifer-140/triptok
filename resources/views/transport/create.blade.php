@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Create Transport</h1>
        <a href="{{ route('day.show', $day) }}" class="btn btn-secondary">Back</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('transport.store', $day) }}" method="POST" id="transportForm">
        @csrf

        <div class="form-group">
            <label for="type">Transport Type</label>
            <input type="text" name="type" id="type" class="form-control" value="{{ old('type') }}" required>
        </div>

        <div class="form-group">
            <label for="date">Transport Date</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ old('date', $day->date->toDateString()) }}" required readonly>
        </div>

        <div class="form-group">
            <label for="departure_time">Departure Time</label>
            <input type="time" name="departure_time" id="departure_time" class="form-control"
                value="{{ old('departure_time') }}"
                required>
        </div>

        <div class="form-group">
            <label for="arrival_time">Estimated Arrival Time</label>
            <input type="time" name="arrival_time" id="arrival_time" class="form-control"
                value="{{ old('arrival_time') }}"
                required>
            <div id="timeError" class="text-danger" style="display: none;">Arrival time cannot be before departure time.</div>
        </div>

        <div class="form-group">
            <label for="cost">Transport Cost</label>
            <input type="number" name="cost" id="cost" class="form-control" value="{{ old('cost') }}" required>
        </div>

        <button type="submit" class="btn btn-primary" id="submitButton">Add Transport</button>
    </form>
</div>

<script>
    // Select elements
    const departureTimeInput = document.getElementById('departure_time');
    const arrivalTimeInput = document.getElementById('arrival_time');
    const timeError = document.getElementById('timeError');
    const submitButton = document.getElementById('submitButton');
    const form = document.getElementById('transportForm');

    // Function to check if arrival time is before departure time
    function checkTimes() {
        const departureTime = departureTimeInput.value;
        const arrivalTime = arrivalTimeInput.value;

        if (departureTime && arrivalTime) {
            const depTime = new Date('1970-01-01T' + departureTime + 'Z'); // Convert to Date object
            const arrTime = new Date('1970-01-01T' + arrivalTime + 'Z'); // Convert to Date object

            if (arrTime <= depTime) {
                timeError.style.display = 'block'; // Show error message
                    submitButton.style.backgroundColor = '#ccc'; // Grey out submit button
                    submitButton.disabled = true; // Disable submit button
            } else {
                timeError.style.display = 'none'; // Hide error message
                    submitButton.style.backgroundColor = ''; // Restore button color
                    submitButton.disabled = false; // Enable submit button
            }
        }
    }

    // Event listeners for departure time and arrival time fields
    departureTimeInput.addEventListener('input', checkTimes);
    arrivalTimeInput.addEventListener('input', checkTimes);

    // Check on form submission if times are valid
    form.addEventListener('submit', function(event) {
        if (timeError.style.display === 'block') {
            event.preventDefault(); // Prevent form submission if error is shown
        }
    });
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Add Accommodation</h1>
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


    <form action="{{ route('accommodation.store', $day) }}" method="POST" id="accommodation-form">
        @csrf
        <div class="form-group">
            <label for="name">Accommodation Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="check_in">Check-In Date</label>
            <input type="date" name="check_in" id="check_in" class="form-control" value="{{ old('check_in', $day->date->toDateString()) }}" required readonly>
        </div>

        <div class="form-group">
            <label for="check_out">Check-Out Date</label>
            <input type="date" name="check_out" id="check_out" class="form-control" value="{{ old('check_out') }}" required
                min="{{ $tripStartDate }}" max="{{ $tripEndDate }}">
            <small id="check_out_error" class="form-text text-danger" style="display: none;">Check-Out Date must be after Check-In Date.</small>
        </div>

        <div class="form-group">
            <label for="check_out_time">Check-Out Time</label>
            <input type="time" name="check_out_time" id="check_out_time" class="form-control" value="{{ old('check_out_time') }}" required>
        </div>

        <div class="form-group">
            <label for="cost">Accommodation Cost</label>
            <input type="number" name="cost" id="cost" class="form-control" value="{{ old('cost') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Accommodation</button>
    </form>
</div>

<script>
    // Function to check if the Check-Out Date is after the Check-In Date
    function validateCheckOutDate() {
        const checkInDate = document.getElementById('check_in').value;
        const checkOutDate = document.getElementById('check_out').value;
        const checkOutError = document.getElementById('check_out_error');

        // Make sure Check-Out Date is within the selected range
        const checkIn = new Date(checkInDate);
        const checkOut = new Date(checkOutDate);
        const tripStartDate = new Date("{{ $tripStartDate }}");
        const tripEndDate = new Date("{{ $tripEndDate }}");

        // Check if the Check-Out Date is within the trip's date range
        if (checkOut < tripStartDate || checkOut > tripEndDate) {
            checkOutError.textContent = 'Check-Out Date must be between trip start and end dates.';
            checkOutError.style.display = 'block';
            document.getElementById('check_out').classList.add('is-invalid');
            return false;
        }

        // Check if the Check-Out Date is after the Check-In Date
        if (checkOut <= checkIn) {
            checkOutError.textContent = 'Check-Out Date must be after Check-In Date.';
            checkOutError.style.display = 'block';
            document.getElementById('check_out').classList.add('is-invalid');
            return false;
        } else {
            checkOutError.style.display = 'none';
            document.getElementById('check_out').classList.remove('is-invalid');
            return true;
        }
    }

    // Real-time check for Check-Out Date
    document.getElementById('check_out').addEventListener('input', function() {
        validateCheckOutDate();
    });

    // Form submit validation
    document.getElementById('accommodation-form').addEventListener('submit', function(event) {
        const checkOutDateIsValid = validateCheckOutDate();
        if (!checkOutDateIsValid) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });

    // Set min and max attributes dynamically for the Check-Out Date
    document.addEventListener('DOMContentLoaded', function() {
        const checkInDate = document.getElementById('check_in').value;
        const checkOutDate = document.getElementById('check_out');
        checkOutDate.setAttribute('min', checkInDate);
        checkOutDate.setAttribute('max', "{{ $tripEndDate }}");
    });
</script>

@endsection

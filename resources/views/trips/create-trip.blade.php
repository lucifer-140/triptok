@extends('layouts.app')

@section('title', 'Create a New Trip')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Create a New Trip</h1>

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('submit-trip') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="tripTitle" class="form-label">Trip Title</label>
            <input type="text" class="form-control" id="tripTitle" name="tripTitle" placeholder="Enter trip title" required>
        </div>

        <div class="mb-3">
            <label for="tripDestination" class="form-label">Destination</label>
            <input type="text" class="form-control" id="tripDestination" name="tripDestination" placeholder="Enter destination" required>
        </div>

        <div class="mb-3">
            <label for="tripStartDate" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="tripStartDate" name="tripStartDate" required>
        </div>

        <div class="mb-3">
            <label for="tripEndDate" class="form-label">End Date</label>
            <input type="date" class="form-control" id="tripEndDate" name="tripEndDate" required>
        </div>

        <div class="mb-3">
            <label for="totalBudget" class="form-label">Total Budget</label>
            <div class="input-group">
                <input type="number" class="form-control" id="totalBudget" name="totalBudget" placeholder="Enter total budget" required>
                <select class="form-select" id="currency" name="currency" required>
                    <option value="" disabled selected>Select Currency</option>
                    <option value="USD">USD - US Dollar</option>
                    <option value="EUR">EUR - Euro</option>
                    <option value="GBP">GBP - British Pound</option>
                    <option value="INR">INR - Indian Rupee</option>
                    <option value="JPY">JPY - Japanese Yen</option>
                    <!-- Add more currencies as needed -->
                </select>
            </div>
        </div>

        <!-- Hidden input for total days -->
        <input type="hidden" id="totalDays" name="totalDays">

        <button type="submit" class="btn btn-primary btn-block">Create Trip</button>
    </form>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startDateInput = document.getElementById('tripStartDate');
        const endDateInput = document.getElementById('tripEndDate');

        function calculateDays() {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);

            if (startDate && endDate && !isNaN(startDate) && !isNaN(endDate)) {
                const timeDifference = endDate - startDate;
                const daysDifference = Math.max(Math.floor(timeDifference / (1000 * 3600 * 24)) + 1, 0); // Calculate days, ensuring non-negative
                // Store the days in the hidden input
                document.getElementById('totalDays').value = daysDifference;
            }
        }

        startDateInput.addEventListener('change', calculateDays);
        endDateInput.addEventListener('change', calculateDays);
    });
</script>
@endsection

@endsection

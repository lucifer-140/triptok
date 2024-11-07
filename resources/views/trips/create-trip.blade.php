@extends('layouts.app')

@section('title', 'Create a New Trip')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Create a New Trip</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('trips.store') }}" method="POST" id="tripForm">
        @csrf
        <div class="mb-3">
            <label for="tripTitle" class="form-label">Trip Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="tripTitle" name="tripTitle" placeholder="Enter trip title" required>
        </div>

        <div class="mb-3">
            <label for="tripDestination" class="form-label">Destination <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="tripDestination" name="tripDestination" placeholder="Enter destination" required>
        </div>

        <div class="mb-3">
            <label for="tripStartDate" class="form-label">Start Date <span class="text-danger">*</span></label>
            <input type="date" class="form-control" id="tripStartDate" name="tripStartDate" required>
            <div class="error-message text-danger" id="startDateError"></div>
        </div>

        <div class="mb-3">
            <label for="tripEndDate" class="form-label">End Date <span class="text-danger">*</span></label>
            <input type="date" class="form-control" id="tripEndDate" name="tripEndDate" required>
            <div class="error-message text-danger" id="endDateError"></div>
        </div>

        <div class="mb-3">
            <label for="totalBudget" class="form-label">Total Budget <span class="text-danger">*</span></label>
            <div class="input-group">
                <input type="number" class="form-control" id="totalBudget" name="totalBudget" placeholder="Enter total budget" required>
                <select class="form-select" id="currency" name="currency" required>
                    <option value="#">Select currency</option>
                    @foreach ($currencies as $currency)
                        <option value="{{ $currency->code }}">{{ $currency->name }} ({{ $currency->code }})</option>
                    @endforeach
                </select>
            </div>
            <div class="error-message text-danger" id="budgetError"></div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Create Trip</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const startDateInput = document.getElementById('tripStartDate');
        const endDateInput = document.getElementById('tripEndDate');
        const budgetInput = document.getElementById('totalBudget');
        const startDateError = document.getElementById('startDateError');
        const endDateError = document.getElementById('endDateError');
        const budgetError = document.getElementById('budgetError');

        // Set minimum date for Start Date as tomorrow
        const today = new Date();
        today.setDate(today.getDate() + 1); // Minimum one day after current date
        const minStartDate = today.toISOString().split('T')[0];
        startDateInput.setAttribute('min', minStartDate);

        // Real-time validation for Start Date
        startDateInput.addEventListener('input', function () {
            if (startDateInput.value < minStartDate) {
                startDateError.textContent = "Start date must be at least one day after today.";
            } else {
                startDateError.textContent = "";
            }
        });

        // Real-time validation for End Date
        endDateInput.addEventListener('input', function () {
            if (endDateInput.value < startDateInput.value) {
                endDateError.textContent = "End date cannot be earlier than start date.";
            } else {
                endDateError.textContent = "";
            }
        });

        // Real-time validation for Total Budget
        budgetInput.addEventListener('input', function () {
            if (budgetInput.value < 0 || isNaN(budgetInput.value)) {
                budgetError.textContent = "Budget must be a number and cannot be less than 0.";
            } else {
                budgetError.textContent = "";
            }
        });

        // Form submission validation
        document.getElementById('tripForm').addEventListener('submit', function (e) {
            let isValid = true;

            if (startDateInput.value < minStartDate) {
                startDateError.textContent = "Start date must be at least one day after today.";
                isValid = false;
            }

            if (endDateInput.value < startDateInput.value) {
                endDateError.textContent = "End date cannot be earlier than start date.";
                isValid = false;
            }

            if (budgetInput.value < 0 || isNaN(budgetInput.value)) {
                budgetError.textContent = "Budget must be a number and cannot be less than 0.";
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault(); // Prevent form submission if validation fails
            }
        });
    });
</script>
@endsection

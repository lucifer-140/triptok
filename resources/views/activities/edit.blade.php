@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Edit Activity</h1>
        <a href="{{ route('day.show', $activity->day_id) }}" class="btn btn-secondary">Back</a>
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

    <form action="{{ route('activities.update', $activity) }}" method="POST" id="activityForm">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Activity Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $activity->title) }}" required>
        </div>

        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="time" name="start_time" id="start_time" class="form-control" value="{{ 'start_time', $activity->start_time }}" required>
        </div>

        <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="time" name="end_time" id="end_time" class="form-control" value="{{ 'end_time', $activity->end_time }}" required>
            <small id="endTimeError" class="text-danger" style="display: none;">End time must be after start time.</small>
        </div>

        <div class="form-group">
            <label for="budget">Budget</label>
            <input type="number" name="budget" id="budget" class="form-control" value="{{ old('budget', $activity->budget) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $activity->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary" id="submitButton">Update Activity</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');
        const submitButton = document.getElementById('submitButton');
        const endTimeError = document.getElementById('endTimeError');

        // Function to validate the times
        function validateTimes() {
            const startTime = startTimeInput.value;
            const endTime = endTimeInput.value;

            if (startTime && endTime) {
                // Compare the start and end times as 24-hour format HH:mm
                if (endTime <= startTime) {
                    endTimeError.style.display = 'block'; // Show error message
                    submitButton.disabled = true; // Disable submit button
                    submitButton.style.backgroundColor = '#ccc'; // Grey out submit button
                } else {
                    endTimeError.style.display = 'none'; // Hide error message
                    submitButton.disabled = false; // Enable submit button
                    submitButton.style.backgroundColor = ''; // Restore button color
                }
            }
        }

        // Event listeners for real-time validation
        startTimeInput.addEventListener('input', validateTimes);
        endTimeInput.addEventListener('input', validateTimes);

        // Initial validation check when page loads (in case pre-filled data is available)
        validateTimes();

        // Prevent form submission if times are invalid
        const form = document.getElementById('activityForm');
        form.addEventListener('submit', function(event) {
            // Trigger validation before submitting the form
            validateTimes();
            if (submitButton.disabled) {
                event.preventDefault(); // Prevent form submission if validation fails
            }
        });
    });

</script>
@endsection

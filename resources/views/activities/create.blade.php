@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Add Activity</h1>
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

    <form action="{{ route('activities.store', $day) }}" method="POST" id="activityForm">
        @csrf
        <div class="form-group">
            <label for="title">Activity Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="time" name="start_time" id="start_time" class="form-control" value="{{ old('start_time') }}" required>
        </div>

        <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="time" name="end_time" id="end_time" class="form-control" value="{{ old('end_time') }}" required>
            <small id="endTimeError" class="text-danger" style="display: none;">End time must be after start time.</small>
        </div>

        <div class="form-group">
            <label for="budget">Budget</label>
            <input type="number" name="budget" id="budget" class="form-control" value="{{ old('budget') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary" id="submitButton">Add Activity</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');
        const submitButton = document.getElementById('submitButton');
        const endTimeError = document.getElementById('endTimeError');

        // Function to validate the time
        function validateTimes() {
            const startTime = startTimeInput.value;
            const endTime = endTimeInput.value;

            if (startTime && endTime) {
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

        // Disable end time options before start time
        startTimeInput.addEventListener('change', function() {
            const startTime = startTimeInput.value;

            if (startTime) {
                // Convert start time to minutes to easily compare
                const [startHour, startMinute] = startTime.split(':').map(Number);
                const startTotalMinutes = startHour * 60 + startMinute;

                // Adjust end time options to prevent selecting times before start time
                for (let option of endTimeInput.options) {
                    const [endHour, endMinute] = option.value.split(':').map(Number);
                    const endTotalMinutes = endHour * 60 + endMinute;
                    if (endTotalMinutes <= startTotalMinutes) {
                        option.disabled = true; // Disable times before the start time
                    } else {
                        option.disabled = false; // Enable valid times
                    }
                }
            }
        });

        // Trigger the change event initially to adjust the end time options
        startTimeInput.dispatchEvent(new Event('change'));
    });
</script>
@endsection

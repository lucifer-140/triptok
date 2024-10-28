<!-- In resources/views/create-trip.blade.php -->
@extends('layouts.app')

@section('title', 'Create a New Trip')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Create a New Trip</h1>
    
    <form action="{{ url('/submit-trip') }}" method="POST">
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
            <input type="number" class="form-control" id="totalBudget" name="totalBudget" placeholder="Enter total budget" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Create Trip</button>
    </form>
</div>
@endsection

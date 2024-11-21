@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Add Flight</h1>
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

    <form action="{{ route('flights.store', $day) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="flight_number">Flight Number</label>
            <input
                type="text"
                name="flight_number"
                id="flight_number"
                class="form-control"
                value="{{ old('flight_number') }}"
                required>
        </div>

        <div class="form-group">
            <label for="flight_date">Flight Date</label>
            <input
                type="date"
                name="date"
                id="flight_date"
                class="form-control"
                value="{{ old('date', $day->date->toDateString()) }}"
                required
                readonly>
        </div>

        <div class="form-group">
            <label for="departure_time">Departure Time</label>
            <input
                type="time"
                name="departure_time"
                id="departure_time"
                class="form-control"
                value="{{ old('departure_time') }}"
                required>
        </div>

        <div class="form-group">
            <label for="arrival_time">Estimated Arrival Time</label>
            <input
                type="time"
                name="arrival_time"
                id="arrival_time"
                class="form-control"
                value="{{ old('arrival_time') }}"
                required>
        </div>

        <div class="form-group">
            <label for="cost">Cost</label>
            <input
                type="number"
                name="cost"
                id="cost"
                class="form-control"
                value="{{ old('cost') }}"
                required>
        </div>

        <button type="submit" class="btn btn-primary">Add Flight</button>
    </form>
</div>
@endsection

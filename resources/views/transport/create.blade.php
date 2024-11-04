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

    <form action="{{ route('transport.store', $day) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="type">Transport Type</label>
            <input type="text" name="type" id="type" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="date">Transport Date</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="departure_time">Departure Time</label>
            <input type="time" name="departure_time" id="departure_time" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="arrival_time">Estimated Arrival Time</label>
            <input type="time" name="arrival_time" id="arrival_time" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="cost">Transport Cost</label>
            <input type="number" name="cost" id="cost" class="form-control" required>
        </div>


        <button type="submit" class="btn btn-primary">Add Transport</button>
    </form>
</div>
@endsection

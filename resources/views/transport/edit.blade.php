@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Transport</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('transport.update', $transport->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="type">Transport Type</label>
            <input type="text" name="type" id="type" class="form-control" value="{{ old('type', $transport->type) }}" required>
        </div>

        <div class="form-group">
            <label for="date">Transport Date</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ old('date', $transport->date) }}" required>
        </div>

        <div class="form-group">
            <label for="departure_time">Departure Time</label>
            <input type="time" name="departure_time" id="departure_time" class="form-control" value="{{ old('departure_time', $transport->departure_time) }}" required>
        </div>

        <div class="form-group">
            <label for="arrival_time">Estimated Arrival Time</label>
            <input type="time" name="arrival_time" id="arrival_time" class="form-control" value="{{ old('arrival_time', $transport->arrival_time) }}" required>
        </div>

        <div class="form-group">
            <label for="cost">Cost</label>
            <input type="number" name="cost" id="cost" class="form-control" value="{{ old('cost', $transport->cost) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Transport</button>
    </form>
</div>
@endsection

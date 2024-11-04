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

    <form action="{{ route('accommodation.store', $day) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Accommodation Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="check_in">Check-In Date</label>
            <input type="date" name="check_in" id="check_in" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="check_out">Check-Out Date</label>
            <input type="date" name="check_out" id="check_out" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="cost">Accommodation Cost</label>
            <input type="number" name="cost" id="cost" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Accommodation</button>
    </form>
</div>
@endsection

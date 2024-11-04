@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Edit Accommodation</h1>
        <a href="{{ route('day.show', $accommodation->day_id) }}" class="btn btn-secondary">Back</a>
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


    <form action="{{ route('accommodation.update', [$day, $accommodation]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Accommodation Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $accommodation->name }}" required>
        </div>

        <div class="form-group">
            <label for="check_in">Check-In Date</label>
            <input type="date" name="check_in" id="check_in" class="form-control" value="{{ $accommodation->check_in }}" required>
        </div>

        <div class="form-group">
            <label for="check_out">Check-Out Date</label>
            <input type="date" name="check_out" id="check_out" class="form-control" value="{{ $accommodation->check_out }}" required>
        </div>

        <div class="form-group">
            <label for="cost">Accommodation Cost</label>
            <input type="number" name="cost" id="cost" class="form-control" value="{{ $accommodation->cost }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Accommodation</button>
    </form>
</div>
@endsection

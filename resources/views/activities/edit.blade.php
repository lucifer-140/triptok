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


    <form action="{{ route('activities.update', $activity) }}" method="POST">  <!-- Changed to just $activity -->
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Activity Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $activity->title }}" required>
        </div>
        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="text" name="start_time" id="start_time" class="form-control" value="{{ $activity->start_time }}" required>
        </div>

        <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="text" name="end_time" id="end_time" class="form-control" value="{{ $activity->end_time }}" required>
        </div>



        <div class="form-group">
            <label for="budget">Budget</label>
            <input type="number" name="budget" id="budget" class="form-control" value="{{ $activity->budget }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{ $activity->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Activity</button>
    </form>
</div>
@endsection

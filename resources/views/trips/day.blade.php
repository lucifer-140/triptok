@extends('layouts.app')

@section('title', 'Day Plan')

@section('content')

<div class="container mt-5">

    <!-- Compact Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('itinerary.create', $itinerary->trip_id) }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
    </div>
    <h2 class="h4 text-center">Day Plan for Day {{ $day->day }}</h2>

    <p class="text-center mb-4">Plan your adventure day by day with details of activities, transport, accommodation, and more.</p>

    <div class="mb-4 border rounded p-3 bg-light">
        <p class="mb-1">Date: <strong>{{ \Carbon\Carbon::parse($day->date)->format('Y-m-d') }}</strong></p>
        <div class="mb-4 border-top pt-4">
            <h5 class="text-center fw-bold">Grand Total: {{ $grandTotal }} {{ $currency }}</h5>
        </div>
    </div>

    <!-- CheckBox Section -->


    <!-- Activities Section -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Activities for Day {{ $day->day }}</h5>
            <a class="btn btn-primary btn-sm" href="{{ route('activities.create', $day->id) }}">
                <i class="bi bi-plus-circle"></i> Add
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Activity Title</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Budget</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($activities->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center">No activities added for this day.</td>
                            </tr>
                        @else
                            @foreach($activities as $activity)
                                <tr>
                                    <td>{{ $activity->title }}</td>
                                    <td>{{ $activity->start_time }}</td>
                                    <td>{{ $activity->end_time }}</td>
                                    <td>{{ $activity->budget }} {{ $currency }}</td>
                                    <td>{{ $activity->description }}</td>
                                    <td>
                                        <a class="btn btn-warning btn-sm" href="{{ route('activities.edit', $activity->id) }}">
                                            Edit
                                        </a>
                                        <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this activity?');">
                                                Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Other Sections (Accommodation, Flights, Transport) -->
    @foreach (['Accommodation' => $accommodations, 'Flights' => $flights, 'Transport' => $transports] as $title => $items)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $title }} for Day {{ $day->day }}</h5>
                <a class="btn btn-primary btn-sm" href="{{ route(strtolower($title).'.create', $day->id) }}">
                    <i class="bi bi-plus-circle"></i> Add
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                @switch($title)
                                    @case('Accommodation')
                                        <th>Accommodation Name</th>
                                        <th>Check-In Date</th>
                                        <th>Check-Out Date</th>
                                        <th>Check-Out Time</th>
                                        <th>Cost</th>
                                        <th>Action</th>
                                        @break
                                    @case('Flights')
                                        <th>Flight Number</th>
                                        <th>Date</th>
                                        <th>Departure Time</th>
                                        <th>Arrival Time</th>
                                        <th>Cost</th>
                                        <th>Action</th>
                                        @break
                                    @case('Transport')
                                        <th>Transport Name/Type</th>
                                        <th>Date</th>
                                        <th>Departure Time</th>
                                        <th>Estimated Arrival Time</th>
                                        <th>Cost</th>
                                        <th>Action</th>
                                        @break
                                @endswitch
                            </tr>
                        </thead>
                        <tbody>
                            @if($items->isEmpty())
                                <tr>
                                    <td colspan="{{ $title === 'Transport' ? 6 : 6 }}" class="text-center">No {{ strtolower($title) }} added for this day.</td>
                                </tr>
                            @else
                                @foreach($items as $item)
                                    <tr>
                                        @switch($title)
                                            @case('Accommodation')
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->check_in }}</td>
                                                <td>{{ $item->check_out }}</td>
                                                <td>{{ $item->check_out_time }}</td>
                                                <td>{{ $item->cost }} {{ $currency }}</td>
                                                @break
                                            @case('Flights')
                                                <td>{{ $item->flight_number }}</td>
                                                <td>{{ $item->date }}</td>
                                                <td>{{ $item->departure_time }}</td>
                                                <td>{{ $item->arrival_time }}</td>
                                                <td>{{ $item->cost }} {{ $currency }}</td>
                                                @break
                                            @case('Transport')
                                                <td>{{ $item->type }}</td>
                                                <td>{{ $item->date }}</td>
                                                <td>{{ $item->departure_time }}</td>
                                                <td>{{ $item->arrival_time }}</td>
                                                <td>{{ $item->cost }} {{ $currency }}</td>
                                                @break
                                        @endswitch
                                        <td>
                                            <a class="btn btn-warning btn-sm" href="{{ route(strtolower($title).'.edit', $item->id) }}">
                                                Edit
                                            </a>
                                            <form action="{{ route(strtolower($title).'.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');">
                                                    Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach

</div>

@endsection

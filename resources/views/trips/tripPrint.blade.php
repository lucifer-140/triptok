@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <!-- Back Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ url('/trip/list') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Trip List
        </a>
        <h1 class="text-center">{{ $trip->title }} Details</h1>
    </div>

    <!-- Activities Table -->
    <h4 class="mt-4">Activities</h4>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Day</th>
                <th>Activity</th>
                <th>Time</th>
                <th>Budget</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($days as $day)
                @if ($day->activities->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">No activities for this day.</td>
                    </tr>
                @else
                    @foreach ($day->activities as $activity)
                        <tr>
                            <td>{{ $day->day }} - {{ \Carbon\Carbon::parse($day->date)->format('d M, Y') }}</td>
                            <td>{{ $activity->title }}</td>
                            <td>{{ $activity->start_time }} - {{ $activity->end_time }}</td>
                            <td>${{ number_format($activity->budget, 2) }}</td>
                            <td>{{ $activity->description }}</td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>

    <!-- Accommodations Table -->
    <h4 class="mt-5">Accommodations</h4>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Day</th>
                <th>Accommodation</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th>Cost</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($days as $day)
                @if ($day->accommodations->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">No accommodations for this day.</td>
                    </tr>
                @else
                    @foreach ($day->accommodations as $accommodation)
                        <tr>
                            <td>{{ $day->day }} - {{ \Carbon\Carbon::parse($day->date)->format('d M, Y') }}</td>
                            <td>{{ $accommodation->name }}</td>
                            <td>{{ $accommodation->check_in }}</td>
                            <td>{{ $accommodation->check_out }}</td>
                            <td>${{ number_format($accommodation->cost, 2) }}</td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>

    <!-- Transports Table -->
    <h4 class="mt-5">Transports</h4>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Day</th>
                <th>Transport Type</th>
                <th>Departure Time</th>
                <th>Arrival Time</th>
                <th>Cost</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($days as $day)
                @if ($day->transports->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">No transports for this day.</td>
                    </tr>
                @else
                    @foreach ($day->transports as $transport)
                        <tr>
                            <td>{{ $day->day }} - {{ \Carbon\Carbon::parse($day->date)->format('d M, Y') }}</td>
                            <td>{{ $transport->type }}</td>
                            <td>{{ $transport->departure_time }}</td>
                            <td>{{ $transport->arrival_time }}</td>
                            <td>${{ number_format($transport->cost, 2) }}</td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>

    <!-- Flights Table -->
    <h4 class="mt-5">Flights</h4>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Day</th>
                <th>Flight Number</th>
                <th>Departure Time</th>
                <th>Arrival Time</th>
                <th>Cost</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($days as $day)
                @if ($day->flights->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">No flights for this day.</td>
                    </tr>
                @else
                    @foreach ($day->flights as $flight)
                        <tr>
                            <td>{{ $day->day }} - {{ \Carbon\Carbon::parse($day->date)->format('d M, Y') }}</td>
                            <td>{{ $flight->flight_number }}</td>
                            <td>{{ $flight->departure_time }}</td>
                            <td>{{ $flight->arrival_time }}</td>
                            <td>${{ number_format($flight->cost, 2) }}</td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>

</div>
@endsection

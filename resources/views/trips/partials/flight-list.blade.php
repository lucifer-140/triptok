@if ($flights->isEmpty())
    <p>No flights booked for this day.</p>
@else
    <ul>
        @foreach ($flights as $flight)
            <li>
                <strong>Flight {{ $flight->flight_number }}</strong> ({{ $flight->departure_time }} - {{ $flight->arrival_time }}) - ${{ $flight->cost }}
            </li>
        @endforeach
    </ul>
@endif

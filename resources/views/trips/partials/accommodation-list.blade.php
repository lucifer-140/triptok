@if ($accommodations->isEmpty())
    <p>No accommodation booked for this day.</p>
@else
    <ul>
        @foreach ($accommodations as $accommodation)
            <li>
                <strong>{{ $accommodation->name }}</strong> (Check-in: {{ $accommodation->check_in }} - Check-out: {{ $accommodation->check_out }}) - Check-out time: {{ $accommodation->check_out_time }} - ${{ $accommodation->cost }}
            </li>
        @endforeach
    </ul>
@endif

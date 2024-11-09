@if ($transports->isEmpty())
    <p>No transport planned for this day.</p>
@else
    <ul>
        @foreach ($transports as $transport)
            <li>
                <strong>{{ $transport->type }}</strong> ({{ $transport->departure_time }} - {{ $transport->arrival_time }}) - ${{ $transport->cost }}
            </li>
        @endforeach
    </ul>
@endif

@if ($activities->isEmpty())
    <p>No activities planned for this day.</p>
@else
    <ul>
        @foreach ($activities as $activity)
            <li>
                <strong>{{ $activity->title }}</strong> ({{ $activity->start_time }} - {{ $activity->end_time }}) - ${{ $activity->budget }}: {{ $activity->description }}
            </li>
        @endforeach
    </ul>
@endif

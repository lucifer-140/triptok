@foreach ($sharedTrips as $sharedTrip)
    <div class="shared-trip">
        <p>Trip: {{ $sharedTrip->trip->tripTitle }}</p>
        <p>Status: {{ ucfirst($sharedTrip->status) }}</p>

        @if ($sharedTrip->status == 'pending')
            <a href="{{ route('trips.share.accept', $sharedTrip->id) }}" class="btn btn-success">Accept</a>
            <a href="{{ route('trips.share.reject', $sharedTrip->id) }}" class="btn btn-danger">Reject</a>
        @endif
    </div>
@endforeach

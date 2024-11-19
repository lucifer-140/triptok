@extends('layouts.app')

@section('content')
<div class="container mt-5 notifications-page">
    <h2 class="mb-4 text-center page-title">Notifications</h2>

    @if (session('error'))
        <div class="alert alert-danger fade show">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success fade show">
            {{ session('success') }}
        </div>
    @endif

    <div class="notifications-section mb-5">
        <h3 class="section-title">Received Shared Trip</h3>
        @forelse ($sharedTrips as $sharedTrip)
            <div class="notification-card card mb-3">
                <div class="card-body d-flex flex-column flex-md-row align-items-center">
                    <div class="trip-info flex-grow-1 mb-3 mb-md-0">
                        <p><strong>From:</strong> {{ $sharedTrip->user->first_name }} {{ $sharedTrip->user->last_name }}</p>
                        <p><strong>Trip Title:</strong> {{ $sharedTrip->trip->tripTitle }}</p>
                        <p><strong>Destination:</strong> {{ $sharedTrip->trip->tripDestination }}</p>
                        <p><strong>Duration:</strong> {{ $sharedTrip->trip->tripStartDate }} to {{ $sharedTrip->trip->tripEndDate }}</p>
                        <p><strong>Budget:</strong> {{ $sharedTrip->trip->currency }} {{ number_format($sharedTrip->trip->totalBudget, 2) }}</p>
                    </div>
                    <div class="trip-actions text-end">
                        @if ($sharedTrip->status == 'pending')
                            <a href="{{ route('trips.share.accept', $sharedTrip->id) }}" class="btn btn-success btn-sm mb-2 mb-md-0 me-1"><i class="bi bi-check2"></i> Accept</a>
                            <a href="{{ route('trips.share.reject', $sharedTrip->id) }}" class="btn btn-danger btn-sm"><i class="bi bi-x-lg"></i> Reject</a>
                        @else
                            <span class="text-muted small">{{ ucfirst($sharedTrip->status) }}</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info text-center">No pending trip invitations.</div>
        @endforelse
    </div>

    <div class="notifications-section mb-5">
        <h3 class="section-title">Received Friend Requests</h3>
        <div class="friend-list" id="receivedRequests">
            @forelse($receivedRequests as $request)
                <div class="notification-card card mb-3">
                    <div class="card-body d-flex flex-column flex-md-row align-items-center">
                        <img src="{{ $request->sender->profile_image ? asset('storage/' . $request->sender->profile_image) : asset('assets/blankprofilepic.jpeg') }}"
                             alt="{{ $request->sender->first_name }} {{ $request->sender->last_name }}"
                             class="rounded-circle me-3 mb-3 mb-md-0"
                             width="60" height="60">
                        <div class="user-info flex-grow-1">
                            <strong>{{ $request->sender->first_name }} {{ $request->sender->last_name }}</strong>
                            <p class="mb-0 text-muted small">{{ $request->sender->email }}</p>
                            <p class="mb-0 text-muted small">{{ $request->sender->phone_number }}</p>
                        </div>
                        <div class="request-actions text-end">
                            <form action="{{ route('acceptRequest', $request->sender->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm mb-2 mb-md-0"><i class="bi bi-check2"></i> Accept</button>
                            </form>
                            <form action="{{ route('declineRequest', $request->sender->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-x-lg"></i> Reject</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info text-center">No received requests to display.</div>
            @endforelse
        </div>
    </div>

    <div class="text-center mb-5">
        <button class="btn btn-outline-info" onclick="window.location.reload();"><i class="bi bi-arrow-clockwise"></i> Refresh Notifications</button>
    </div>
</div>
@endsection

<style>
.notifications-page {
    background: #fcfcfc;
    border-radius: 12px;
    padding: 35px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.page-title {
    color: #343a40;
    font-weight: bold;
    font-size: 2rem;
}

.notifications-section {
    margin-bottom: 40px;
}

.section-title {
    font-size: 1.75rem;
    margin-bottom: 20px;
    color: #007bff;
    border-bottom: 3px solid #007bff;
    padding-bottom: 10px;
}

.notification-card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s;
}

.notification-card:hover {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.trip-info {
    margin-bottom: 10px;
}

.trip-actions, .request-actions {
    text-align: right;
}

.text-end {
    text-align: end; /* Align text to the end for better UX */
}

/* Button styling */
.btn-success {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn-success:hover, .btn-danger:hover {
    opacity: 0.85;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .request-actions, .trip-actions {
        text-align: center;
    }
}

@media (max-width: 576px) {
    .notification-card {
        padding: 12px;
        font-size: 14px;
    }

    .page-title {
        font-size: 1.5rem;
    }

    .section-title {
        font-size: 1.5rem;
    }

    .notification-card .card-body {
        flex-direction: column;
        text-align: center;
    }

    .notification-card img {
        margin: 0 auto;
    }

    .notification-card .trip-info {
        text-align: center;
    }

    .request-actions {
        margin-top: 15px;
    }

    .btn-success, .btn-danger {
        width: 100%;
        margin-top: 10px;
    }
}

/* Alert Styles */
.alert {
    border-radius: 5px;
    font-size: 14px;
    margin-bottom: 15px;
}
</style>

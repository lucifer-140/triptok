@extends('layouts.app')

@section('content')
<div class="container mt-5 notifications-page">
    <h2 class="mb-4 text-center page-title">Notifications</h2>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="notifications-section mb-5">
        <h3 class="section-title">Pending Shared Trip Notifications</h3>
        @forelse ($sharedTrips as $sharedTrip)
            <div class="notification-card card mb-3">
                <div class="card-body">
                    <div class="trip-info">
                        <p><strong>Trip:</strong> {{ $sharedTrip->trip->tripTitle }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($sharedTrip->status) }}</p>
                    </div>
                    <div class="trip-actions">
                        @if ($sharedTrip->status == 'pending')
                            <a href="{{ route('trips.share.accept', $sharedTrip->id) }}" class="btn btn-success btn-sm">Accept</a>
                            <a href="{{ route('trips.share.reject', $sharedTrip->id) }}" class="btn btn-danger btn-sm">Reject</a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p>No pending trip invitations.</p>
        @endforelse
    </div>

    <div class="notifications-section mb-5">
        <h3 class="section-title">Received Friend Requests</h3>
        <div class="friend-list" id="receivedRequests">
            @forelse($receivedRequests as $request)
                <div class="notification-card card mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <img src="{{ $request->sender->profile_image ? asset('storage/' . $request->sender->profile_image) : asset('assets/blankprofilepic.jpeg') }}"
                                 alt="{{ $request->sender->first_name }} {{ $request->sender->last_name }}"
                                 class="rounded-circle me-3"
                                 width="50" height="50">
                            <div class="user-info flex-grow-1">
                                <strong>{{ $request->sender->first_name }} {{ $request->sender->last_name }}</strong>
                                <p class="mb-0 text-muted small">{{ $request->sender->email }}</p>
                                <p class="mb-0 text-muted small">{{ $request->sender->phone_number }}</p>
                            </div>
                            <div class="request-actions">
                                <form action="{{ route('acceptRequest', $request->sender->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success btn-sm"><i class="bi bi-check2"></i></button>
                                </form>
                                <form action="{{ route('declineRequest', $request->sender->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-x-lg"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>No received requests to display.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

<style>
.notifications-page {
    background: linear-gradient(to right, #f0f4f8, #e3e9f1);
    border-radius: 10px;
    padding: 20px;
}

.page-title {
    color: #333;
}

.notifications-section {
    margin-bottom: 30px;
}

.section-title {
    font-size: 1.5rem;
    margin-bottom: 20px;
    border-bottom: 2px solid #007bff;
    padding-bottom: 10px;
    color: #333;
}

.notification-card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
}

.notification-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}

.trip-info {
    margin-bottom: 15px;
}

.trip-actions {
    text-align: right;
}

.user-info {
    margin-left: 15px;
}

.user-info p {
    margin-bottom: 5px;
}

.request-actions {
    margin-left: auto;
}
</style>

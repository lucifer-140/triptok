@extends('layouts.app')

@section('content')
<div class="container mt-5" style="background: linear-gradient(to right, #f0f4f8, #e3e9f1); border-radius: 10px; padding: 20px;">
    <h2 class="mb-4 text-center">Trip Invitations</h2>

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

    <div class="mb-5">
        <h3 class="section-title">Pending Shared Trip Notifications</h3>
        @foreach ($sharedTrips as $sharedTrip)
            <div class="shared-trip card shadow-sm mb-3" style="border-radius: 15px;">
                <div class="card-body">
                    <p><strong>Trip:</strong> {{ $sharedTrip->trip->tripTitle }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($sharedTrip->status) }}</p>

                    @if ($sharedTrip->status == 'pending')
                        <a href="{{ route('trips.share.accept', $sharedTrip->id) }}" class="btn btn-success">Accept</a>
                        <a href="{{ route('trips.share.reject', $sharedTrip->id) }}" class="btn btn-danger">Reject</a>
                    @endif
                </div>
            </div>
        @endforeach

        @if($sharedTrips->isEmpty())
            <p>No pending trip invitations.</p>
        @endif
    </div>
</div>

<style>
    .section-title {
        font-size: 1.5rem;
        margin-bottom: 20px;
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
        color: #333;
    }
    .card:hover {
        transform: scale(1.02);
        transition: transform 0.3s;
    }
</style>

@endsection

@extends('layouts.app')

@section('content')
<div class="container mt-5" style="background: linear-gradient(to right, #f0f4f8, #e3e9f1); border-radius: 10px; padding: 20px;">
    <h2 class="text-center mb-4">Friend System</h2>

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search Bar -->
    <div class="mb-4 position-relative">
        <input type="text" class="form-control" id="searchFriend" placeholder="Search for friends...">
        <div id="spinner" class="spinner-border text-primary position-absolute end-0 top-50 translate-middle-y d-none" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Your Friends -->
    <h3>Your Friends</h3>
    <div class="row" id="friendsList">
        @forelse($friends as $friend)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $friend->first_name }} {{ $friend->last_name }}</h5>
                        <div class="d-flex justify-content-between">
                            <form action="{{ route('removeFriend', $friend->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                            <a href="#" class="btn btn-info btn-sm">Message</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">You have no friends yet.</p>
        @endforelse
    </div>

    <!-- Received Friend Requests -->
    <h3>Received Friend Requests</h3>
    <div class="row">
        @forelse($receivedRequests as $request)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $request->sender->first_name }} {{ $request->sender->last_name }}</h5>
                        <div class="d-flex justify-content-between">
                            <form action="{{ route('acceptRequest', $request->sender->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Accept</button>
                            </form>
                            <form action="{{ route('declineRequest', $request->sender->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Decline</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">No pending friend requests.</p>
        @endforelse
    </div>

    <!-- Sent Friend Requests -->
    <h3>Sent Friend Requests</h3>
    <div class="row">
        @forelse($sentRequests as $request)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body">
                        <h5 class="card-title">You sent a request to {{ $request->receiver->first_name }} {{ $request->receiver->last_name }}.</h5>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">You have no sent requests.</p>
        @endforelse
    </div>

    <!-- People You May Know -->
    <h3>People You May Know</h3>
    <div class="row" id="potentialFriends">
        @forelse($nonFriends as $user)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $user->first_name }} {{ $user->last_name }}</h5>
                        <form action="{{ route('sendRequest', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">Send Friend Request</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">No new users to send friend requests to.</p>
        @endforelse
    </div>
</div>

<style>
    .spinner-border {
        width: 2rem;
        height: 2rem;
        color: grey !important;
    }
    .card:hover {
        transform: scale(1.05);
        transition: transform 0.2s;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("searchFriend");
        const spinner = document.getElementById("spinner");
        const userCards = document.querySelectorAll(".user-card");

        searchInput.addEventListener("input", function() {
            spinner.classList.remove("d-none");

            setTimeout(function() {
                const searchTerm = searchInput.value.toLowerCase();

                userCards.forEach(function(card) {
                    const userName = card.getAttribute("data-user-name");
                    const userEmail = card.getAttribute("data-user-email");

                    if (userName.includes(searchTerm) || userEmail.includes(searchTerm)) {
                        card.classList.remove("d-none");
                    } else {
                        card.classList.add("d-none");
                    }
                });

                spinner.classList.add("d-none");
            }, 500); // Adjust the timeout as needed
        });
    });
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mt-5" style="background: linear-gradient(to right, #f0f4f8, #e3e9f1); border-radius: 10px; padding: 20px;">
    <h2 class="mb-4 text-center">Your Friends</h2>

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

    <!-- Search Bar -->
    <div class="mb-4 position-relative">
        <input type="text" class="form-control" id="searchFriend" placeholder="Search for friends...">
        <div id="spinner" class="spinner-border text-primary position-absolute end-0 top-50 translate-middle-y d-none" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    
    <!-- Accepted Friends List -->
    <h3>Accepted Friends</h3>
    <div class="row" id="acceptedFriendsList">
        @foreach($acceptedFriends as $index => $friendship)
            <div class="col-md-6 mb-4 user-card @if($index >= 2) d-none @endif" data-user-name="{{ strtolower($friendship->friend->first_name . ' ' . $friendship->friend->last_name) }}" data-user-email="{{ strtolower($friendship->friend->email) }}">
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $friendship->friend->first_name }} {{ $friendship->friend->last_name }}</h5>
                        <p class="card-text"><strong>Email:</strong> {{ $friendship->friend->email }}</p>
                        <p class="card-text"><strong>Phone:</strong> {{ $friendship->friend->phone_number }}</p>
                        <div class="d-flex justify-content-between">
                            <!-- Remove Button - triggers AJAX to remove the friend -->
                            <form action="{{ route('friends.remove', $friendship->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Remove</button>
                            </form>
                            <a href="#" class="btn btn-outline-info btn-sm">Message</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    <!-- Pending Requests -->
    <h3 class="mt-4">Inbox (Pending Requests)</h3>
    <div class="row" id="pendingRequestsList">
        @foreach($pendingRequests as $request)
            <div class="col-md-6 mb-4 user-card" data-user-name="{{ strtolower($request->user->first_name . ' ' . $request->user->last_name) }}" data-user-email="{{ strtolower($request->user->email) }}">
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $request->user->first_name }} {{ $request->user->last_name }}</h5>
                        <p class="card-text"><strong>Email:</strong> {{ $request->user->email }}</p>
                        <p class="card-text"><strong>Phone:</strong> {{ $request->user->phone_number }}</p>
                        <div class="d-flex justify-content-between">
                            <!-- Accept Button Form -->
                            <form action="{{ route('acceptRequest', $request->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Accept</button>
                            </form>

                            <!-- Reject Button Form -->
                            <form action="{{ route('rejectRequest', $request->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Rejected Requests -->
    <h3 class="mt-4">Rejected Requests</h3>
    <div class="row" id="rejectedRequestsList">
        @foreach($rejectedRequests as $rejected)
            <div class="col-md-6 mb-4 user-card" data-user-name="{{ strtolower($rejected->user->first_name . ' ' . $rejected->user->last_name) }}" data-user-email="{{ strtolower($rejected->user->email) }}">
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $rejected->user->first_name }} {{ $rejected->user->last_name }}</h5>
                        <p class="card-text"><strong>Email:</strong> {{ $rejected->user->email }}</p>
                        <p class="card-text"><strong>Phone:</strong> {{ $rejected->user->phone_number }}</p>
                        <div class="d-flex justify-content-between">
                            <!-- Optionally, add notes about why rejected -->
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Show More Button -->
    @if(count($acceptedFriends) > 2)
        <div class="text-center">
            <button class="btn btn-link show-more" data-target="#acceptedFriendsList">Show More</button>
        </div>
    @endif
</div>

<style>
    .show-more {
        font-size: 1rem;
        color: #007bff;
        cursor: pointer;
        text-decoration: none;
        border: none;
        background: none;
    }
    .show-more:hover {
        text-decoration: underline;
    }
    .spinner-border {
        width: 2rem;
        height: 2rem;
        color: grey !important;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Search functionality
        const searchInput = document.getElementById("searchFriend");
        const spinner = document.getElementById("spinner");
        const userCards = document.querySelectorAll(".user-card");

        searchInput.addEventListener("input", function() {
            // Show the spinner when typing starts
            spinner.classList.remove("d-none");

            // Delay to simulate loading time (optional)
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

                // Hide the spinner after search is complete
                spinner.classList.add("d-none");
            }, 500); // Adjust the timeout as needed
        });

        // Show more functionality
        const showMoreButtons = document.querySelectorAll(".show-more");
        showMoreButtons.forEach(button => {
            button.addEventListener("click", function() {
                const target = document.querySelector(button.getAttribute("data-target"));
                const hiddenCards = target.querySelectorAll(".d-none");
                hiddenCards.forEach(card => {
                    card.classList.remove("d-none");
                });
                button.classList.add("d-none");
            });
        });
    });
</script>
@endsection

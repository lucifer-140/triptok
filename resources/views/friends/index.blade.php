@extends('layouts.app')

@section('content')
<div class="container mt-5" style="background: linear-gradient(to right, #f0f4f8, #e3e9f1); border-radius: 10px; padding: 20px;">
    <h2 class="mb-4 text-center">Add Friends</h2>

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

    <!-- Users List -->
    <div class="row" id="usersList">
        @forelse ($users as $index => $user)
            <div class="col-md-6 mb-4 user-card @if($index >= 2) d-none @endif" data-user-name="{{ strtolower($user->first_name . ' ' . $user->last_name) }}" data-user-email="{{ strtolower($user->email) }}">
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $user->first_name }} {{ $user->last_name }}</h5>
                        <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
                        <p class="card-text"><strong>Phone:</strong> {{ $user->phone_number }}</p>
                        <div class="d-flex justify-content-between">
                            <!-- Friend Request Form -->
                            <form action="{{ route('sendRequest', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary btn-sm">Send Friend Request</button>
                            </form>
                            <a href="#" class="btn btn-outline-info btn-sm">Message</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p>No users found.</p>
        @endforelse
    </div>

    <!-- Show More Button -->
    @if(count($users) > 2)
        <div class="text-center">
            <button class="btn btn-link show-more" data-target="#usersList">Show More</button>
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

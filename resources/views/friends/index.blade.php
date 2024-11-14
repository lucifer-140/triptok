@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm" style="border-radius: 15px;">
                <div class="card-header" style="background: linear-gradient(to right, #f0f4f8, #e3e9f1); border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h2 class="text-center mb-0">Friend System</h2>
                </div>

                <div class="card-body">
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

                    <div class="mb-4 position-relative">
                        <input type="text" class="form-control" id="searchFriend" placeholder="Search for friends...">
                        <div id="spinner" class="spinner-border text-primary position-absolute end-0 top-50 translate-middle-y d-none" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h4>Your Friends</h4>
                            <div class="friend-list" id="friendsList">
                                @forelse($friends as $friend)
                                    <div class="friend-card mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                {{ $friend->first_name }} {{ $friend->last_name }}
                                            </div>
                                            <div>
                                                <form action="{{ route('removeFriend', $friend->id) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">Remove</button>
                                                </form>
                                                <a href="#" class="btn btn-outline-info btn-sm">Message</a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center">You have no friends yet.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="col-md-12 mt-4">
                            <h4>Received Friend Requests</h4>
                            <div class="friend-list" id="receivedRequests">
                                @forelse($receivedRequests as $request)
                                    <div class="friend-card mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                {{ $request->sender->first_name }} {{ $request->sender->last_name }}
                                            </div>
                                            <div>
                                                <form action="{{ route('acceptRequest', $request->sender->id) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success btn-sm">Accept</button>
                                                </form>
                                                <form action="{{ route('declineRequest', $request->sender->id) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">Decline</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center">No pending friend requests.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="col-md-12 mt-4">
                            <h4>Sent Friend Requests</h4>
                            <div class="friend-list" id="sentRequests">
                                @forelse($sentRequests as $request)
                                    <div class="friend-card mb-3">
                                        {{ $request->receiver->first_name }} {{ $request->receiver->last_name }}
                                    </div>
                                @empty
                                    <p class="text-center">You have no sent requests.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="col-md-12 mt-4">
                            <h4>People You May Know</h4>
                            <div class="friend-list" id="potentialFriends">
                                @forelse($nonFriends as $user)
                                    <div class="friend-card mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </div>
                                            <div>
                                                <form action="{{ route('sendRequest', $user->id) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-primary btn-sm">Add Friend</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center">No new users to send friend requests to.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .spinner-border {
        width: 2rem;
        height: 2rem;
        color: grey !important;
    }
    .friend-list {
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 15px;
    }
    .friend-card {
        border-bottom: 1px solid #dee2e6;
        padding: 10px 0;
    }
    .friend-card:last-child {
        border-bottom: none;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("searchFriend");
        const spinner = document.getElementById("spinner");
        const friendsList = document.getElementById("friendsList");
        const receivedRequests = document.getElementById("receivedRequests");
        const sentRequests = document.getElementById("sentRequests");
        const potentialFriends = document.getElementById("potentialFriends");

        searchInput.addEventListener("input", function() {
            spinner.classList.remove("d-none");

            setTimeout(function() {
                const searchTerm = searchInput.value.toLowerCase();

                // Filter "Your Friends"
                filterCards(friendsList, searchTerm);

                // Filter "Received Friend Requests"
                filterCards(receivedRequests, searchTerm);

                // Filter "Sent Friend Requests"
                filterCards(sentRequests, searchTerm);

                // Filter "People You May Know"
                filterCards(potentialFriends, searchTerm);

                spinner.classList.add("d-none");
            }, 500); // Adjust the timeout as needed
        });

        function filterCards(container, searchTerm) {
            const userCards = container.querySelectorAll('.friend-card');
            userCards.forEach(function(card) {
                const userName = card.textContent.toLowerCase();
                if (userName.includes(searchTerm)) {
                    card.classList.remove("d-none");
                } else {
                    card.classList.add("d-none");
                }
            });
        }
    });
</script>
@endsection

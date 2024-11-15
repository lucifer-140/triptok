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
                        <!-- Your Friends Section -->
                        <div class="col-12">
                            <h4>Your Friends</h4>
                            <div class="friend-list" id="friendsList">
                                @forelse($friends as $friend)
                                    <div class="friend-card mb-3">
                                        <div class="d-flex flex-column flex-sm-row align-items-center">
                                            <img src="{{ $friend->profile_image ? asset('storage/' . $friend->profile_image) : asset('assets/blankprofilepic.jpeg') }}" alt="{{ $friend->first_name }} {{ $friend->last_name }}" class="rounded-circle" width="50" height="50">
                                            <div class="flex-grow-1 ms-3" style="min-width: 200px;">
                                                <strong>{{ $friend->first_name }} {{ $friend->last_name }}</strong><br>
                                                <small class="text-truncate" style="max-width: 200px;">Email: {{ $friend->email }}</small><br>
                                                <small class="text-truncate" style="max-width: 200px;">Phone: {{ $friend->phone_number }}</small>
                                            </div>
                                            <div class="mt-3 mt-sm-0 ms-sm-3">
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

                        <!-- Received Friend Requests Section -->
                        <div class="col-12 mt-4">
                            <h4>Received Friend Requests</h4>
                            <div class="friend-list" id="receivedRequests">
                                @forelse($receivedRequests as $request)
                                    <div class="friend-card mb-3">
                                        <div class="d-flex flex-column flex-sm-row align-items-center">
                                            <img src="{{ $request->sender->profile_image ? asset('storage/' . $request->sender->profile_image) : asset('assets/blankprofilepic.jpeg') }}" alt="{{ $request->sender->first_name }} {{ $request->sender->last_name }}" class="rounded-circle" width="50" height="50">
                                            <div class="flex-grow-1 ms-3" style="min-width: 200px;">
                                                <strong>{{ $request->sender->first_name }} {{ $request->sender->last_name }}</strong><br>
                                                <small class="text-truncate" style="max-width: 200px;">Email: {{ $request->sender->email }}</small><br>
                                                <small class="text-truncate" style="max-width: 200px;">Phone: {{ $request->sender->phone_number }}</small>
                                            </div>
                                            <div class="mt-3 mt-sm-0 ms-sm-3">
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

                        <!-- Sent Friend Requests Section -->
                        <div class="col-12 mt-4">
                            <h4>Sent Friend Requests</h4>
                            <div class="friend-list" id="sentRequests">
                                @forelse($sentRequests as $request)
                                    <div class="friend-card mb-3">
                                        <div class="d-flex flex-column flex-sm-row align-items-center">
                                            <img src="{{ $request->receiver->profile_image ? asset('storage/' . $request->receiver->profile_image) : asset('assets/blankprofilepic.jpeg') }}" alt="{{ $request->receiver->first_name }} {{ $request->receiver->last_name }}" class="rounded-circle" width="50" height="50">
                                            <div class="flex-grow-1 ms-3" style="min-width: 200px;">
                                                <strong>{{ $request->receiver->first_name }} {{ $request->receiver->last_name }}</strong><br>
                                                <small class="text-truncate" style="max-width: 200px;">Email: {{ $request->receiver->email }}</small><br>
                                                <small class="text-truncate" style="max-width: 200px;">Phone: {{ $request->receiver->phone_number }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center">You have no sent requests.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- People You May Know Section -->
                        <div class="col-12 mt-4">
                            <h4>People You May Know</h4>
                            <div class="friend-list" id="potentialFriends">
                                @forelse($nonFriends as $user)
                                    <div class="friend-card mb-3">
                                        <div class="d-flex flex-column flex-sm-row align-items-center">
                                            <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('assets/blankprofilepic.jpeg') }}" alt="{{ $user->first_name }} {{ $user->last_name }}" class="rounded-circle" width="50" height="50">
                                            <div class="flex-grow-1 ms-3" style="min-width: 200px;">
                                                <strong>{{ $user->first_name }} {{ $user->last_name }}</strong><br>
                                                <small class="text-truncate" style="max-width: 200px;">Email: {{ $user->email }}</small><br>
                                                <small class="text-truncate" style="max-width: 200px;">Phone: {{ $user->phone_number }}</small>
                                            </div>
                                            <div class="mt-3 mt-sm-0 ms-sm-3">
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

    /* Button adjustments for small screens */
    @media (max-width: 576px) {
        .friend-card {
            display: block;
            margin-bottom: 15px;
        }

        .friend-card .btn {
            width: 100%;
            margin-top: 5px;
        }

        .friend-card img {
            width: 40px;
            height: 40px;
            margin-bottom: 10px;
        }

        .friend-card .d-flex {
            flex-direction: column;
            align-items: flex-start;
        }

        .friend-card .flex-grow-1 {
            margin-left: 0;
        }

        .friend-list {
            padding: 10px;
        }
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

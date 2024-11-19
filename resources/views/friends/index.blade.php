@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm" style="border-radius: 15px;">
                <div class="card-header text-center bg-light" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h2>Friend System</h2>
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

                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs" id="friendTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="friends-tab" data-bs-toggle="tab" data-bs-target="#friends" type="button" role="tab" aria-controls="friends" aria-selected="true">
                                <i class="bi bi-people"></i>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="received-requests-tab" data-bs-toggle="tab" data-bs-target="#received-requests" type="button" role="tab" aria-controls="received-requests" aria-selected="false">
                                <i class="bi bi-person-plus"></i>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="sent-requests-tab" data-bs-toggle="tab" data-bs-target="#sent-requests" type="button" role="tab" aria-controls="sent-requests" aria-selected="false">
                                <i class="bi bi-send"></i>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="suggestions-tab" data-bs-toggle="tab" data-bs-target="#suggestions" type="button" role="tab" aria-controls="suggestions" aria-selected="false">
                                <i class="bi bi-person-check"></i>
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="friendTabsContent">

                        <!-- Your Friends Tab -->
                        <div class="tab-pane fade show active" id="friends" role="tabpanel" aria-labelledby="friends-tab">
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h4>Your Friends</h4>
                                </div>
                                <div class="col-12">
                                    <input type="text" class="form-control mt-2" id="searchFriend" placeholder="Search friends...">
                                </div>
                            </div>
                            <div class="friend-list" id="friendsList">
                                @forelse($friends as $friend)
                                    <div class="friend-card p-3 mb-2 rounded shadow-sm text-center text-md-start">
                                        <div class="d-flex align-items-center flex-column flex-md-row">
                                            <img src="{{ $friend->profile_image ? asset('storage/' . $friend->profile_image) : asset('assets/blankprofilepic.jpeg') }}" alt="{{ $friend->first_name }} {{ $friend->last_name }}" class="rounded-circle me-0 me-md-3 mb-2 mb-md-0" width="50" height="50">
                                            <div class="flex-grow-1">
                                                <strong>{{ $friend->first_name }} {{ $friend->last_name }}</strong>
                                                <p class="mb-0 text-muted">Email: {{ $friend->email }}</p>
                                                <p class="mb-0 text-muted">Phone: {{ $friend->phone_number }}</p>
                                            </div>
                                            <div class="mt-2 mt-md-0">
                                                <form action="{{ route('removeFriend', $friend->id) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-person-x"></i> Remove</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="friend-card p-3 mb-2 rounded shadow-sm text-center">
                                        <p>No friends to display.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Received Friend Requests Tab -->
                        <div class="tab-pane fade" id="received-requests" role="tabpanel" aria-labelledby="received-requests-tab">
                            <h4 class="mt-3">Received Friend Requests</h4>
                            <div class="friend-list" id="receivedRequests">
                                @forelse($receivedRequests as $request)
                                    <div class="friend-card p-3 mb-2 rounded shadow-sm text-center text-md-start">
                                        <div class="d-flex align-items-center flex-column flex-md-row">
                                            <img src="{{ $request->sender->profile_image ? asset('storage/' . $request->sender->profile_image) : asset('assets/blankprofilepic.jpeg') }}" alt="{{ $request->sender->first_name }} {{ $request->sender->last_name }}" class="rounded-circle me-0 me-md-3 mb-2 mb-md-0" width="50" height="50">
                                            <div class="flex-grow-1">
                                                <strong>{{ $request->sender->first_name }} {{ $request->sender->last_name }}</strong>
                                                <p class="mb-0 text-muted">Email: {{ $request->sender->email }}</p>
                                                <p class="mb-0 text-muted">Phone: {{ $request->sender->phone_number }}</p>
                                            </div>
                                            <div class="mt-2 mt-md-0">
                                                <form action="{{ route('acceptRequest', $request->sender->id) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success btn-sm"><i class="bi bi-check2"></i> Accept</button>
                                                </form>
                                                <form action="{{ route('declineRequest', $request->sender->id) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-x-lg"></i> Decline</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="friend-card p-3 mb-2 rounded shadow-sm text-center">
                                        <p>No received requests to display.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Sent Friend Requests Tab -->
                        <div class="tab-pane fade" id="sent-requests" role="tabpanel" aria-labelledby="sent-requests-tab">
                            <h4 class="mt-3">Sent Friend Requests</h4>
                            <div class="friend-list" id="sentRequests">
                                @forelse($sentRequests as $request)
                                    <div class="friend-card p-3 mb-2 rounded shadow-sm text-center text-md-start">
                                        <div class="d-flex align-items-center flex-column flex-md-row">
                                            <img src="{{ $request->receiver->profile_image ? asset('storage/' . $request->receiver->profile_image) : asset('assets/blankprofilepic.jpeg') }}" alt="{{ $request->receiver->first_name }} {{ $request->receiver->last_name }}" class="rounded-circle me-0 me-md-3 mb-2 mb-md-0" width="50" height="50">
                                            <div class="flex-grow-1">
                                                <strong>{{ $request->receiver->first_name }} {{ $request->receiver->last_name }}</strong>
                                                <p class="mb-0 text-muted">Email: {{ $request->receiver->email }}</p>
                                                <p class="mb-0 text-muted">Phone: {{ $request->receiver->phone_number }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="friend-card p-3 mb-2 rounded shadow-sm text-center">
                                        <p>No sent requests to display.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- People You May Know Tab -->
                        <div class="tab-pane fade" id="suggestions" role="tabpanel" aria-labelledby="suggestions-tab">
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h4>People You May Know</h4>
                                </div>
                                <div class="col-12">
                                    <input type="text" class="form-control mt-2" id="searchSuggestions" placeholder="Search people...">
                                </div>
                            </div>
                            <div class="friend-list" id="potentialFriends">
                                @forelse($nonFriends as $user)
                                    <div class="friend-card p-3 mb-2 rounded shadow-sm text-center text-md-start">
                                        <div class="d-flex align-items-center flex-column flex-md-row">
                                            <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('assets/blankprofilepic.jpeg') }}" alt="{{ $user->first_name }} {{ $user->last_name }}" class="rounded-circle me-0 me-md-3 mb-2 mb-md-0" width="50" height="50">
                                            <div class="flex-grow-1">
                                                <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>
                                                <p class="mb-0 text-muted">Email: {{ $user->email }}</p>
                                                <p class="mb-0 text-muted">Phone: {{ $user->phone_number }}</p>
                                            </div>
                                            <div class="mt-2 mt-md-0">
                                                <form action="{{ route('sendRequest', $user->id) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-person-plus"></i> Add Friend</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="friend-card p-3 mb-2 rounded shadow-sm text-center">
                                        <p>No suggestions to display.</p>
                                    </div>
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
    .friend-list { padding: 15px; }
    .friend-card { border: 1px solid #f0f4f8; }
    .friend-card:hover { background: #f9fafc; }
    .btn-sm { padding: 0.25rem 0.5rem; }
    /* Responsive Styles */
    @media (max-width: 768px) {
        .friend-card img { width: 40px; height: 40px; }
        .friend-card .d-flex { flex-direction: column; align-items: center; text-align: center; }
        .friend-card .btn { width: 100%; }
    }
</style>

<script>
    // Function to filter friends list by search query
    function filterList(searchInputId, listId) {
        const searchInput = document.getElementById(searchInputId);
        const list = document.getElementById(listId);

        searchInput.addEventListener('keyup', () => {
            const query = searchInput.value.toLowerCase();
            const friends = list.getElementsByClassName('friend-card');

            Array.from(friends).forEach(friend => {
                const name = friend.querySelector('strong').textContent.toLowerCase();
                friend.style.display = name.includes(query) ? 'block' : 'none';
            });
        });
    }

    // Initialize filtering for each search input
    document.addEventListener('DOMContentLoaded', () => {
        filterList('searchFriend', 'friendsList');       // For "Your Friends"
        filterList('searchSuggestions', 'potentialFriends'); // For "People You May Know"
    });
</script>

@endsection

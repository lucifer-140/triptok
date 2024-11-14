@extends('layouts.app')

@section('content')
<div class="container mt-5" style="background: linear-gradient(to right, #f0f4f8, #e3e9f1); border-radius: 10px; padding: 20px;">
    <h2 class="mb-4 text-center">Search for Friends</h2>

    <!-- Search Bar -->
    <div class="mb-4 position-relative">
        <form method="GET" action="{{ route('friends.search') }}">
            <input type="text" class="form-control" name="query" placeholder="Search for friends..." value="{{ request('query') }}">
        </form>
        <div id="spinner" class="spinner-border text-primary position-absolute end-0 top-50 translate-middle-y d-none" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search Results -->
    @if($users->isEmpty())
        <p>No users found. Try searching with a different keyword.</p>
    @else
        <h3>Users found</h3>
        <div class="row">
            @foreach($users as $user)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm" style="border-radius: 15px;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $user->first_name }} {{ $user->last_name }}</h5>
                            <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
                            <p class="card-text"><strong>Phone:</strong> {{ $user->phone_number }}</p>
                            <div class="d-flex justify-content-between">
                                <!-- Send Friend Request Button -->
                                <form action="{{ route('friend.request.send', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">Send Request</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.querySelector('input[name="query"]');
        const spinner = document.getElementById('spinner');

        searchInput.addEventListener('input', function () {
            spinner.classList.remove('d-none');
            const query = searchInput.value;

            // Debounce search to prevent too many requests
            clearTimeout(window.searchTimeout);
            window.searchTimeout = setTimeout(function () {
                window.location.href = `/user/friends/search?query=${query}`;
            }, 500);
        });
    });

</script>
@endsection


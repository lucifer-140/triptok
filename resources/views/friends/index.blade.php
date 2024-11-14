@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Friend System</h1>

    <h3>Your Friends</h3>
    @forelse($friends as $friend)
        <p>{{ $friend->first_name }} {{ $friend->last_name }}</p>
    @empty
        <p>You have no friends yet.</p>
    @endforelse

    <h3>Received Friend Requests</h3>
    @forelse($receivedRequests as $request)
        <p>{{ $request->sender->first_name }} {{ $request->sender->last_name }} sent you a friend request.</p>
        <form action="{{ route('acceptRequest', $request->sender->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Accept</button>
        </form>
        <form action="{{ route('declineRequest', $request->sender->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Decline</button>
        </form>
    @empty
        <p>No pending friend requests.</p>
    @endforelse

    <h3>Sent Friend Requests</h3>
    @forelse($sentRequests as $request)
        <p>You sent a friend request to {{ $request->receiver->first_name }} {{ $request->receiver->last_name }}.</p>
    @empty
        <p>No sent friend requests.</p>
    @endforelse

    <h3>People You May Know</h3>
    @forelse($nonFriends as $user)
        <p>{{ $user->first_name }} {{ $user->last_name }}</p>
        <form action="{{ route('sendRequest', $user->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Send Friend Request</button>
        </form>
    @empty
        <p>No new users to send friend requests to.</p>
    @endforelse
</div>
@endsection

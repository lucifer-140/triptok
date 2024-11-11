@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Friend List Card -->
            <div class="card shadow-lg p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>My Friend List</h4>
                    <!-- Button to open the Add Friend form -->
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addFriendModal">Add Friend</button>
                </div>

                <hr>

                <!-- Friend List Table -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($friends as $friend)
                            <tr>
                                <td>{{ $friend->first_name }} {{ $friend->last_name }}</td>
                                <td>{{ $friend->email }}</td>
                                <td>
                                    <!-- Edit Friend Button -->
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editFriendModal{{ $friend->id }}">Edit</button>
                                    <!-- Delete Friend Button -->
                                    <form action="{{ route('friends.delete', $friend->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Friend Modal -->
<div class="modal fade" id="addFriendModal" tabindex="-1" aria-labelledby="addFriendModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFriendModalLabel">Add New Friend</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('friends.add') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="friendName" class="form-label">Friend's Name</label>
                        <input type="text" class="form-control" id="friendName" name="friend_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="friendEmail" class="form-label">Friend's Email</label>
                        <input type="email" class="form-control" id="friendEmail" name="friend_email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Friend</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Friend Modal (per friend) -->
@foreach($friends as $friend)
<div class="modal fade" id="editFriendModal{{ $friend->id }}" tabindex="-1" aria-labelledby="editFriendModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFriendModalLabel">Edit Friend: {{ $friend->first_name }} {{ $friend->last_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('friends.update', $friend->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="friendName" class="form-label">Friend's Name</label>
                        <input type="text" class="form-control" id="friendName" name="friend_name" value="{{ $friend->first_name }} {{ $friend->last_name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="friendEmail" class="form-label">Friend's Email</label>
                        <input type="email" class="form-control" id="friendEmail" name="friend_email" value="{{ $friend->email }}" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Update Friend</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

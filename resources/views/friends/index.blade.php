<!-- resources/views/friends/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Friends</h1>

        <!-- Search Bar -->
        <div class="row mb-4">
            <div class="col-md-6 offset-md-3">
                <input type="text" class="form-control" placeholder="Search for friends...">
            </div>
        </div>

        <!-- Friends List -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Friend 1">
                    <div class="card-body">
                        <h5 class="card-title">John Doe</h5>
                        <p class="card-text">Travel Enthusiast</p>
                        <button class="btn btn-primary">Add Friend</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Friend 2">
                    <div class="card-body">
                        <h5 class="card-title">Jane Smith</h5>
                        <p class="card-text">Adventurer</p>
                        <button class="btn btn-primary">Add Friend</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Friend 3">
                    <div class="card-body">
                        <h5 class="card-title">Mark Johnson</h5>
                        <p class="card-text">Explorer</p>
                        <button class="btn btn-primary">Add Friend</button>
                    </div>
                </div>
            </div>

            <!-- More friends can be added here -->
        </div>
    </div>
@endsection

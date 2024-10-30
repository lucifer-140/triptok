@extends('layouts.app')

@section('content')
<div class="container mt-5" style="background: linear-gradient(to right, #f0f4f8, #e3e9f1); border-radius: 10px; padding: 20px;">
    <h2 class="mb-4 text-center">Manage Your Trips</h2>

    <!-- Search Bar -->
    <div class="mb-4">
        <input type="text" class="form-control" id="searchTrip" placeholder="Search for trips...">
    </div>

    <!-- Upcoming Trips Section -->
    <div class="mb-5">
        <h3 class="section-title">Upcoming Trips</h3>
        <div class="row" id="upcomingTrips">
            <!-- Card 1 -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body">
                        <h5 class="card-title">Summer Vacation</h5>
                        <p class="card-text"><strong>Destination:</strong> Paris, France</p>
                        <p class="card-text"><strong>Start Date:</strong> July 15, 2024</p>
                        <p class="card-text"><strong>End Date:</strong> July 30, 2024</p>
                        <span class="badge bg-primary mb-2">Upcoming</span>

                        <!-- Horizontal Divider -->
                        <hr class="my-3">

                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="#" class="btn btn-outline-primary btn-sm me-2">View <i class="fas fa-eye"></i></a>
                                <a href="#" class="btn btn-outline-secondary btn-sm me-2">Edit <i class="fas fa-edit"></i></a>
                            </div>
                            <a href="#" class="btn btn-outline-info btn-sm">Share <i class="fas fa-share-alt"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Card 2 -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body">
                        <h5 class="card-title">Business Trip</h5>
                        <p class="card-text"><strong>Destination:</strong> New York, USA</p>
                        <p class="card-text"><strong>Start Date:</strong> September 5, 2024</p>
                        <p class="card-text"><strong>End Date:</strong> September 10, 2024</p>
                        <span class="badge bg-primary mb-2">Upcoming</span>

                        <!-- Horizontal Divider -->
                        <hr class="my-3">

                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="#" class="btn btn-outline-primary btn-sm me-2">View <i class="fas fa-eye"></i></a>
                                <a href="#" class="btn btn-outline-secondary btn-sm me-2">Edit <i class="fas fa-edit"></i></a>
                            </div>
                            <a href="#" class="btn btn-outline-info btn-sm">Share <i class="fas fa-share-alt"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Finished Trips Section -->
    <div class="mb-5">
        <h3 class="section-title">Finished Trips</h3>
        <div class="row" id="finishedTrips">
            <!-- Card 1 -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body">
                        <h5 class="card-title">Winter Escape</h5>
                        <p class="card-text"><strong>Destination:</strong> Zürich, Switzerland</p>
                        <p class="card-text"><strong>Start Date:</strong> December 20, 2023</p>
                        <p class="card-text"><strong>End Date:</strong> January 5, 2024</p>
                        <span class="badge bg-secondary mb-2">Finished</span>

                        <!-- Horizontal Divider -->
                        <hr class="my-3">

                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="#" class="btn btn-outline-primary btn-sm">View <i class="fas fa-eye"></i></a>
                            </div>
                            <a href="#" class="btn btn-outline-info btn-sm">Share <i class="fas fa-share-alt"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body">
                        <h5 class="card-title">Spring Retreat</h5>
                        <p class="card-text"><strong>Destination:</strong> Kyoto, Japan</p>
                        <p class="card-text"><strong>Start Date:</strong> April 10, 2023</p>
                        <p class="card-text"><strong>End Date:</strong> April 20, 2023</p>
                        <span class="badge bg-secondary mb-2">Finished</span>

                        <!-- Horizontal Divider -->
                        <hr class="my-3">

                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="#" class="btn btn-outline-primary btn-sm">View <i class="fas fa-eye"></i></a>
                            </div>
                            <a href="#" class="btn btn-outline-info btn-sm">Share <i class="fas fa-share-alt"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Plan New Trip Button -->
    <div class="text-center mt-4">
        <a href="#" class="btn btn-lg btn-success shadow-lg">Plan New Trip <i class="fas fa-plus-circle"></i></a>
    </div>
</div>

<style>
    .section-title {
        font-size: 1.5rem;
        margin-bottom: 20px;
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
        color: #333;
    }
    .card:hover {
        transform: scale(1.02);
        transition: transform 0.3s;
    }
</style>
@endsection

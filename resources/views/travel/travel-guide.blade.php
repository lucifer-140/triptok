@extends('layouts.app')

@section('content')

<!-- Explore Destinations Section -->
<div class="container my-5">
    <h3 class="section-title text-center mb-4">Explore Destinations</h3>
    <div class="row justify-content-center">
        <!-- Static List of Countries -->
        @foreach (range(1, 20) as $index)
            <div class="col-md-4 mb-4">
                <div class="destination-card">
                    <!-- Image Container -->
                    <div class="image-container">
                        <img src="https://via.placeholder.com/500x300" class="img-fluid rounded-top" alt="Country {{ $index }}" loading="lazy">
                    </div>

                    <div class="destination-info py-3">
                        <!-- Country Name -->
                        <h5 class="destination-name fs-5 mb-2">Country {{ $index }}</h5>

                        <!-- Rating -->
                        <div class="destination-rating mb-2">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star-half-alt text-warning"></i>
                            <span class="ms-2 text-muted">4.5/5</span>
                        </div>

                        <!-- Description -->
                        <p class="destination-description mb-3">Discover the beauty of Country {{ $index }}. Explore its iconic landmarks and hidden gems.</p>

                        <!-- Explore Button -->
                        <a href="#" class="btn btn-outline-primary explore-btn">Explore</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        <ul class="pagination">
            <!-- Pagination logic, assuming 3 pages -->
            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
    </div>
</div>

<style>
    .image-container {
        width: 100%;
        height: 200px;
        overflow: hidden;
    }

    .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination .page-item {
        margin: 0 5px;
    }

    .pagination .page-item .page-link {
        color: #007bff;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
    }
</style>

@endsection

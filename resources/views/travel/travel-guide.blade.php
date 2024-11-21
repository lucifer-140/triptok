@extends('layouts.app')

@section('content')

<!-- Explore Destinations Section -->
<div class="container my-5">
    <h3 class="section-title text-center mb-4">Explore Destinations</h3>
    <div class="row justify-content-center">
        @foreach ($destinations as $city)
            <div class="col-md-4 mb-4">
                <div class="destination-card">
                    <!-- Image Container -->
                    <div class="image-container">
                        <img src="{{ asset('assets/' . $city . '.jpg') }}" class="img-fluid rounded-top" alt="{{ ucfirst($city) }}" loading="lazy">
                    </div>

                    <div class="destination-info py-3">
                        <!-- City Name -->
                        <h5 class="destination-name fs-5 mb-2">{{ ucfirst($city) }}</h5>

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
                        <p class="destination-description mb-3">Discover the beauty of {{ ucfirst($city) }}. Explore its iconic landmarks and hidden gems.</p>

                        <!-- Explore Button -->
                        <a href="#" class="btn btn-outline-primary explore-btn">Explore</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        {{ $destinations->links() }}
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

</style>
@endsection

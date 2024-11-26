@extends('layouts.app')

@section('content')
<div class="container my-5">
    <!-- Back Button -->
    <a href="{{ route('travel.index') }}" class="btn btn-outline-secondary mb-3"><</a>

    {{-- <h2 class="text-center">{{ $destination->name }}</h2> --}}

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="destination-detail-card card">
                <!-- Image Container -->
                    <div class="image-container">
                        <img src="{{ asset($destination->image) }}" class="img-fluid rounded-top" alt="{{ $destination->name }}" loading="lazy">
                    </div>

                <div class="card-body">
                    <!-- Destination Name -->
                    <h4 class="card-title">{{ $destination->name }}</h4>
                    <p class="card-text">{{ $destination->description }}</p>

                    <!-- Rating Section -->
                    <div class="destination-rating mb-3">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-warning{{ $destination->rating >= $i ? '' : '-half-alt' }}"></i>
                        @endfor
                        <span class="ms-2 text-muted">{{ $destination->rating }}/5</span>
                    </div>

                    <!-- Vote Section (Thumbs Up / Thumbs Down) -->
                    <div class="vote-section mb-4">
                        <!-- Static Vote Counts -->
                        <button class="btn btn-success me-2" disabled>
                            <i class="bi bi-hand-thumbs-up"></i>
                        </button>
                        <button class="btn btn-danger" disabled>
                            <i class="bi bi-hand-thumbs-down"></i>
                        </button>
                    </div>

                    <!-- Vote Count (Static Example) -->
                    <div id="vote-counts" class="text-center mt-2">
                        <p><strong>Votes:</strong> <span id="up-votes" style="color: green">123</span> <i class="fas fa-thumbs-up"></i> / <span id="down-votes" style="color: red">45</span> <i class="fas fa-thumbs-down"></i></p>
                    </div>

                    <!-- Trip Templates -->
                    <h5 class="mt-5 mb-3">Suggested Itineraries</h5>
                    <div class="row">
                        @foreach ($destination->tripTemplates as $trip)
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $trip->name }}</h6>
                                        <p class="card-text">{{ Str::limit($trip->description, 100) }}</p>
                                        <p><strong>Duration:</strong> {{ $trip->duration }} days</p>
                                        <p><strong>Price:</strong> ${{ number_format($trip->price, 2) }}</p>
                                        <a href="#" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

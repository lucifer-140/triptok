@extends('layouts.app')

@section('content')

<div class="container my-5">
    <h3 class="section-title text-center mb-4">Explore Destinations</h3>

    <!-- Search Form -->
    <form method="GET" action="{{ route('travel.index') }}" class="mb-4 text-center">
        <input type="text" name="search" class="form-control w-50 d-inline" placeholder="Search for destinations..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary ms-2">Search</button>
    </form>

    <div class="row justify-content-center">
        @foreach ($destinations as $destination)
            <div class="col-md-4 mb-4">
                <div class="destination-card">
                    <!-- Image Container -->
                    <div class="image-container">
                        <img src="{{ asset($destination->image) }}" class="img-fluid rounded-top" alt="{{ $destination->name }}" loading="lazy">
                    </div>

                    <div class="destination-info py-3">
                        <!-- Country Name -->
                        <h5 class="destination-name fs-5 mb-2">{{ $destination->name }}</h5>

                        <!-- Rating -->
                        <div class="destination-rating mb-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-warning{{ $destination->rating >= $i ? '' : '-half-alt' }}"></i>
                            @endfor
                            <span class="ms-2 text-muted">{{ $destination->rating }}/5</span>
                        </div>

                        <!-- Description -->
                        <p class="destination-description mb-3">{{ $destination->description }}</p>

                        <!-- Explore Button -->
                        <a href="{{ route('destination.show', $destination->id) }}" class="btn btn-outline-primary explore-btn">Explore</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Custom Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        <ul class="pagination custom-pagination">
            {{-- Previous Page Link --}}
            @if ($destinations->onFirstPage())
                <li class="page-item disabled"><span class="page-link"><i class="bi bi-chevron-left"></i></span></li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $destinations->previousPageUrl() }}"><i class="bi bi-chevron-left"></i></a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($destinations->getUrlRange(1, $destinations->lastPage()) as $page => $url)
                @if ($page == $destinations->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @elseif ($page <= $destinations->currentPage() + 2 && $page >= $destinations->currentPage() - 2)
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($destinations->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $destinations->nextPageUrl() }}"><i class="bi bi-chevron-right"></i></a>
                </li>
            @else
                <li class="page-item disabled"><span class="page-link"><i class="bi bi-chevron-right"></i></span></li>
            @endif
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

    .destination-card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .destination-card:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease-in-out;
    }

    .destination-info {
        flex-grow: 1;
    }

    .pagination.custom-pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination.custom-pagination .page-item {
        margin: 0 5px;
    }

    .pagination.custom-pagination .page-link {
        color: #fff;
        font-size: 16px;
        padding: 10px 16px; /* Increased padding for consistency */
        border-radius: 50%;
        border: 1px solid rgba(43, 122, 99, 0.5);
        background-color: #246351;
        transition: background-color 0.3s, color 0.3s;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 40px; /* Set a fixed width to ensure uniform size */
        height: 40px; /* Set a fixed height to ensure uniform size */
        text-align: center; /* Align text properly */
    }

    .pagination.custom-pagination .page-link:hover {
        background-color: #2B7A63;
        color: #fff;
    }

    .pagination.custom-pagination .page-item.active .page-link {
        background-color: #238468;
        color: #fff;
        border-color: #2B7A63;
    }

    .pagination.custom-pagination .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        border: 1px solid rgba(43, 122, 99, 0.5);
    }

    /* Adjust arrows */
    .pagination.custom-pagination .page-link i {
        font-size: 18px;
    }

    /* Search bar styling */
    .form-control {
        display: inline-block;
        width: 60%;
        padding: 10px;
    }

    .btn-primary {
        padding: 10px 20px;
    }

    @media (max-width: 767px) {
        .pagination.custom-pagination .page-link {
            font-size: 14px;
            padding: 8px;
        }
        .form-control {
            width: 80%;
        }
    }
</style>

@endsection

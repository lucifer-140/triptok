<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content rounded-3 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel">Share Trip with Friends</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(isset($trip))
                    <form action="{{ route('trips.share', $trip->id) }}" method="POST">
                        @csrf
                        <!-- Search Bar with Spinner -->
                        <div class="mb-4 position-relative">
                            <input type="text" class="form-control form-control-lg" id="searchFriend" placeholder="Search friends...">
                            <div id="spinner" class="spinner-border text-primary position-absolute end-0 top-50 translate-middle-y d-none" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>

                        <!-- Friends List -->
                        <div class="friend-list" id="friendsList">
                            @if($friends->isEmpty())
                                <div class="alert alert-info text-center">
                                    No friends available to share this trip.
                                </div>
                            @else
                                @foreach($friends as $friend)
                                    <div class="friend-card p-3 mb-3 rounded shadow-sm" data-name="{{ strtolower($friend->first_name . ' ' . $friend->last_name) }}" data-email="{{ strtolower($friend->email) }}">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $friend->profile_image ? asset('storage/' . $friend->profile_image) : asset('assets/blankprofilepic.jpeg') }}" alt="{{ $friend->first_name }} {{ $friend->last_name }}" class="rounded-circle me-3" width="50" height="50">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <strong class="d-block">{{ $friend->first_name }} {{ $friend->last_name }}</strong>
                                                        <p class="mb-0 text-muted small">{{ $friend->email }}</p>
                                                    </div>
                                                    <input type="checkbox" name="friends[]" value="{{ $friend->id }}" class="form-check-input">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>


                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100 mt-4">Share Trip</button>
                    </form>
                @else
                    <div class="alert alert-danger">
                        The trip does not exist or could not be loaded.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap 4 JS and Popper -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("searchFriend");
        const spinner = document.getElementById("spinner");
        const friendCards = document.querySelectorAll(".friend-card");

        // Real-time search function
        searchInput.addEventListener("input", function() {
            spinner.classList.remove("d-none");

            setTimeout(function() {
                const searchTerm = searchInput.value.toLowerCase();

                friendCards.forEach(function(card) {
                    const friendName = card.getAttribute("data-name");
                    const friendEmail = card.getAttribute("data-email");

                    if (friendName.includes(searchTerm) || friendEmail.includes(searchTerm)) {
                        card.classList.remove("d-none");
                    } else {
                        card.classList.add("d-none");
                    }
                });

                spinner.classList.add("d-none");
            }, 500); // Optional delay for simulating loading
        });

        // Close the modal manually via the close button (Bootstrap 4)
        $('.close').click(function() {
            $('#shareModal').modal('hide');  // Manually hide the modal
        });
    });
</script>

<style>
    /* Optional: Add hover effect back to the friend card */
    .friend-card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    /* Responsive improvements for smaller screens */
    @media (max-width: 576px) {
        .modal-dialog {
            max-width: 90vw; /* Modal takes up 90% of viewport width */
            margin: 1rem;    /* Add some margin around the modal */
        }

        .friend-card {
            font-size: 0.9rem; /* Slightly reduce font size */
        }
    }

    /* Custom Close Button Style */
    .modal-header {
        position: relative;
    }

    .close {
        position: absolute;
        top: 0;
        right: 0;
        font-size: 2rem;  /* Smaller size for the button */
        background: transparent;  /* Remove background color */
        border: none;  /* Remove border */
        color: #000;  /* Set the X color */
        opacity: 0.7;  /* Slight transparency */
    }

    .close:hover,
    .close:focus {
        color: #000;  /* Ensure color on hover/focus */
        opacity: 1;   /* Remove transparency on hover/focus */
        background: transparent;  /* Ensure no background on hover */
        box-shadow: none;  /* Remove any box-shadow on hover */
    }

</style>

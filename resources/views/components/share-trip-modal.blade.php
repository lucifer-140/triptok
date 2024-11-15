<!-- Share Trip Modal -->
<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel">Share Trip with Friends</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('trips.share', $trip->id) }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-12">
                            <h6>Select Friends to Share With:</h6>
                            <input type="text" class="form-control" id="searchFriend" placeholder="Search friends...">
                        </div>
                    </div>
                    <div class="friend-list" id="friendsList">
                        @foreach($friends as $friend)
                            <div class="friend-card p-3 mb-2 rounded shadow-sm">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $friend->profile_image ? asset('storage/' . $friend->profile_image) : asset('assets/blankprofilepic.jpeg') }}" alt="{{ $friend->first_name }} {{ $friend->last_name }}" class="rounded-circle me-3" width="50" height="50">
                                    <div class="flex-grow-1">
                                        <strong>{{ $friend->first_name }} {{ $friend->last_name }}</strong>
                                        <p class="mb-0 text-muted">{{ $friend->email }}</p>
                                    </div>
                                    <div class="mt-2">
                                        <input type="checkbox" name="friends[]" value="{{ $friend->id }}"> Select
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Share Trip</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#searchFriend').on('keyup', function() {
            var searchValue = $(this).val().toLowerCase();
            $('#friendsList .friend-card').each(function() {
                var friendName = $(this).find('strong').text().toLowerCase();
                if (friendName.indexOf(searchValue) > -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>

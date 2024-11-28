<div class="modal fade" id="communityShareModal" tabindex="-1" role="dialog" aria-labelledby="communityShareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content rounded-3 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="communityShareModalLabel">Share Trip with Community</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(isset($trip))
                    <form action="{{ route('community.share', $trip->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="countrySelect">Select Country</label>
                            <select class="form-control" id="countrySelect" name="country" required>
                                <option value="" disabled selected>Choose a country...</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->name }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
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

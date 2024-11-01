<!-- Accommodation Modal -->
<div class="modal fade" id="accommodationModal" tabindex="-1" aria-labelledby="accommodationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="accommodationModalLabel">Add/Edit Accommodation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="accommodationForm">
                    <div class="mb-3">
                        <label for="accommodationName" class="form-label">Accommodation Name</label>
                        <input type="text" class="form-control" id="accommodationName" placeholder="e.g., Hotel, Hostel" required>
                    </div>
                    <div class="mb-3">
                        <label for="accommodationCheckIn" class="form-label">Check-In Date</label>
                        <input type="date" class="form-control" id="accommodationCheckIn" required>
                    </div>
                    <div class="mb-3">
                        <label for="accommodationCheckOut" class="form-label">Check-Out Date</label>
                        <input type="date" class="form-control" id="accommodationCheckOut" required>
                    </div>
                    <div class="mb-3">
                        <label for="accommodationCost" class="form-label">Accommodation Cost</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="accommodationCost" placeholder="Enter Accommodation Cost" required>
                            <span class="input-group-text">{{ $currency }}</span> <!-- Add currency here -->
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveAccommodationButton">Save Accommodation</button>
            </div>
        </div>
    </div>
</div>

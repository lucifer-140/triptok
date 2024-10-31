<!-- Transport Modal -->
<div class="modal fade" id="transportModal" tabindex="-1" aria-labelledby="transportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transportModalLabel">Add/Edit Transport</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="transportForm">
                    <div class="mb-3">
                        <label for="transportType" class="form-label">Transport Type</label>
                        <input type="text" class="form-control" id="transportType" placeholder="e.g., Train, Bus" required>
                    </div>
                    <div class="mb-3">
                        <label for="transportTime" class="form-label">Departure Time</label>
                        <input type="time" class="form-control" id="transportTime" required>
                    </div>
                    <div class="mb-3">
                        <label for="transportCost" class="form-label">Cost</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="transportCost" placeholder="Enter cost" required>
                            <span class="input-group-text">{{ $currency }}</span> <!-- Add currency here -->
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveTransportButton">Save Transport</button>
            </div>
        </div>
    </div>
</div>

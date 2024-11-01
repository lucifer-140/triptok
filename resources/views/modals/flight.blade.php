<!-- Flight Modal -->
<div class="modal fade" id="flightModal" tabindex="-1" aria-labelledby="flightModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="flightModalLabel">Add/Edit Flight</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="flightForm">
                    <div class="mb-3">
                        <label for="flightNumber" class="form-label">Flight Number</label>
                        <input type="text" class="form-control" id="flightNumber" placeholder="Enter flight number" required>
                    </div>
                    <div class="mb-3">
                        <label for="flightDate" class="form-label">Flight Date</label>
                        <input type="date" class="form-control" id="flightDate" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="flightDepartureTime" class="form-label">Departure Time</label>
                            <input type="time" class="form-control" id="flightDepartureTime" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="flightArrivalTime" class="form-label">Estimated Arrival Time</label>
                            <input type="time" class="form-control" id="flightArrivalTime" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="flightCost" class="form-label">Cost</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="flightCost" placeholder="Enter flight cost" required>
                            <span class="input-group-text">{{ $currency }}</span> <!-- Add currency here -->
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveFlightButton">Save Flight</button>
            </div>
        </div>
    </div>
</div>

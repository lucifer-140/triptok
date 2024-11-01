<!-- In resources/views/tripInformation.blade.php -->
@extends('layouts.app')

@section('title', 'Trip Information')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Trip Information</h2>
    
    <form id="tripInfoForm" class="mb-4">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="tripName" class="form-label">Trip Name</label>
                <input type="text" class="form-control" id="tripName" placeholder="Enter your trip name" required>
            </div>
            <div class="col-md-6">
                <label for="tripDestination" class="form-label">Destination</label>
                <input type="text" class="form-control" id="tripDestination" placeholder="Enter destination" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="tripStartDate" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="tripStartDate" required>
            </div>
            <div class="col-md-6">
                <label for="tripEndDate" class="form-label">End Date</label>
                <input type="date" class="form-control" id="tripEndDate" required>
            </div>
        </div>

        <div class="mb-4">
            <label for="tripBudget" class="form-label">Total Budget</label>
            <input type="number" class="form-control" id="tripBudget" placeholder="Enter total budget" min="0" required>
        </div>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#transportModal">Add Transport</button>
        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#accommodationModal">Add Accommodation</button>
        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#notesModal">Add Notes</button>

        <div id="tripDetails" class="mt-4">
            <h3 class="section-title">Trip Details</h3>
            <ul class="list-group" id="detailsList">
                <!-- Dynamic trip details will be appended here -->
            </ul>
        </div>

        <button type="submit" class="btn btn-success mt-4">Save Trip Information</button>
    </form>
</div>

<!-- Transport Modal -->
<div class="modal fade" id="transportModal" tabindex="-1" aria-labelledby="transportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transportModalLabel">Add Transport</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="transportForm">
                    <div class="mb-3">
                        <label for="transportType" class="form-label">Transport Type</label>
                        <input type="text" class="form-control" id="transportType" required>
                    </div>
                    <div class="mb-3">
                        <label for="transportCost" class="form-label">Cost</label>
                        <input type="number" class="form-control" id="transportCost" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveTransportBtn">Save Transport</button>
            </div>
        </div>
    </div>
</div>

<!-- Accommodation Modal -->
<div class="modal fade" id="accommodationModal" tabindex="-1" aria-labelledby="accommodationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="accommodationModalLabel">Add Accommodation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="accommodationForm">
                    <div class="mb-3">
                        <label for="accommodationName" class="form-label">Accommodation Name</label>
                        <input type="text" class="form-control" id="accommodationName" required>
                    </div>
                    <div class="mb-3">
                        <label for="accommodationCost" class="form-label">Cost</label>
                        <input type="number" class="form-control" id="accommodationCost" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveAccommodationBtn">Save Accommodation</button>
            </div>
        </div>
    </div>
</div>

<!-- Notes Modal -->
<div class="modal fade" id="notesModal" tabindex="-1" aria-labelledby="notesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notesModalLabel">Add Notes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="tripNotes" class="form-label">Notes</label>
                    <textarea class="form-control" id="tripNotes" rows="5" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveNotesBtn">Save Notes</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Functions to handle modal submissions and update trip details
    document.getElementById('saveTransportBtn').addEventListener('click', function() {
        const transportType = document.getElementById('transportType').value;
        const transportCost = document.getElementById('transportCost').value;

        const transportItem = document.createElement('li');
        transportItem.className = 'list-group-item d-flex justify-content-between align-items-center';
        transportItem.innerHTML = `
            <div>
                <strong>${transportType}</strong> - $${transportCost}
            </div>
            <button class="btn btn-sm btn-danger" onclick="removeItem(this)">Delete</button>
        `;
        document.getElementById('detailsList').appendChild(transportItem);

        // Reset form fields and close modal
        document.getElementById('transportForm').reset();
        $('#transportModal').modal('hide');
    });

    document.getElementById('saveAccommodationBtn').addEventListener('click', function() {
        const accommodationName = document.getElementById('accommodationName').value;
        const accommodationCost = document.getElementById('accommodationCost').value;

        const accommodationItem = document.createElement('li');
        accommodationItem.className = 'list-group-item d-flex justify-content-between align-items-center';
        accommodationItem.innerHTML = `
            <div>
                <strong>${accommodationName}</strong> - $${accommodationCost}
            </div>
            <button class="btn btn-sm btn-danger" onclick="removeItem(this)">Delete</button>
        `;
        document.getElementById('detailsList').appendChild(accommodationItem);

        // Reset form fields and close modal
        document.getElementById('accommodationForm').reset();
        $('#accommodationModal').modal('hide');
    });

    document.getElementById('saveNotesBtn').addEventListener('click', function() {
        const notesContent = document.getElementById('tripNotes').value;

        const notesItem = document.createElement('li');
        notesItem.className = 'list-group-item';
        notesItem.innerHTML = `<strong>Notes:</strong> ${notesContent}`;
        document.getElementById('detailsList').appendChild(notesItem);

        // Reset form fields and close modal
        document.getElementById('tripNotes').value = '';
        $('#notesModal').modal('hide');
    });

    function removeItem(button) {
        button.parentElement.remove();
    }
</script>
@endsection
@endsection

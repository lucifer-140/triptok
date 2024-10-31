<!-- activities.blade.php -->
<div class="modal fade" id="activitiesModal" tabindex="-1" aria-labelledby="activitiesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="activitiesModalLabel">Add/Edit Activities</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="activitiesForm">
                    <div class="mb-3">
                        <label for="activityTitle" class="form-label">Activity Title</label>
                        <input type="text" class="form-control" id="activityTitle" placeholder="Enter activity title" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="activityStartTime" class="form-label">Start Time</label>
                            <input type="time" class="form-control" id="activityStartTime" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="activityEndTime" class="form-label">End Time</label>
                            <input type="time" class="form-control" id="activityEndTime" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="activityBudget" class="form-label">Estimated Budget</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="activityBudget" placeholder="Enter budget" required>
                            <span class="input-group-text">{{ $currency }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="activityDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="activityDescription" rows="3" placeholder="Add more details about the activity..." required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveActivityButton">Save Activity</button>
            </div>
        </div>
    </div>
</div>

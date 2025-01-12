<div class="modal fade" id="modal-form" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form class="modal-content" id="form-modal" action="javascript:save()">
            <div class="modal-header">
                <h5 class="modal-title">Project</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modal-form-id" name="id">

                <div class="row row-cols-1 rol-cols-md-2">
                    <div class="col mb-2">
                        <label for="modal-form-title" class="form-label">Title</label>
                        <input type="text" id="modal-form-title" class="form-control" name="title" required>
                    </div>
                </div>

                <div class="row row-cols-1 rol-cols-md-2">
                    <div class="col mb-2">
                        <label for="modal-form-description" class="form-label">Description</label>
                        <textarea id="modal-form-description" class="form-control" name="description" rows="2"></textarea>
                    </div>
                </div>

                <div class="row row-cols-1 rol-cols-md-2">
                    <div class="col mb-2">
                        <label for="modal-form-start-date" class="form-label">Start Date</label>
                        <input type="date" id="modal-form-start-date" class="form-control" name="start-date" required>
                    </div>
                    <div class="col mb-2">
                        <label for="modal-form-end-date" class="form-label">End Date</label>
                        <input type="date" id="modal-form-end-date" class="form-control" name="end-date" required>
                    </div>
                </div>
                
                <div class="row row-cols-1 rol-cols-md-2">
                    <div class="col mb-2">
                        <label for="modal-form-budget" class="form-label">Budget</label>
                        <input type="number" id="modal-form-budget" class="form-control" name="budget" min="0" step="0.01" required>
                    </div>
                    <div class="col mb-2">
                        <label for="modal-form-status" class="form-label">Status</label>
                        <select id="modal-form-status" class="form-select" name="status" required>
                            <option value="completed">Completed</option>
                            <option value="ongoing">Ongoing</option>
                            <option value="pending" selected>Pending</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                
                @if ($user->has_permission("update_project_users"))
                <div class="row row-cols-1">
                    <div class="col mb-2">
                        <label for="modal-form-users" class="form-label">Users</label>
                        <select id="modal-form-users" class="form-select select2" name="users[]" multiple>
                            @foreach ($users as $u)
                            <option value="{{ $u['id'] }}">{{ $u['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modal-expense" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form class="modal-content" id="form-expense" action="javascript:save()">
            <div class="modal-header">
                <h5 class="modal-title">Expense</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="form-expense-id" name="id" value="">
                <input type="hidden" id="form-expense-project-id" name="project-id" value="">

                <div class="row row-cols-1 rol-cols-md-2">
                    <div class="col mb-2">
                        <label for="form-expense-description" class="form-label">Description</label>
                        <input type="text" id="form-expense-description" class="form-control" name="description" required>
                    </div>
                </div>

                <div class="row row-cols-1 rol-cols-md-3">
                    <div class="col mb-2">
                        <label for="form-expense-expense-date" class="form-label">Date</label>
                        <input type="date" id="form-expense-expense-date" class="form-control" name="expense-date" max="{{ now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="col mb-2">
                        <label for="form-expense-amount" class="form-label">Amount</label>
                        <input type="number" id="form-expense-amount" class="form-control" name="amount" min="0" step="0.01" required>
                    </div>
                    <div class="col mb-2">
                        <label for="form-expense-status" class="form-label">Status</label>
                        <select id="form-expense-status" class="form-select" name="status" required>
                            <option value="approved">Approved</option>
                            <option value="pending" selected>Pending</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>

                <div class="row row-cols-1 rol-cols-md-3">
                    <div class="col mb-2">
                        <label class="form-label">Type</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="form-expense-type-travel" value="travel" checked>
                            <label class="form-check-label" for="form-expense-type-travel">Travel</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="form-expense-type-equipment" value="equipment">
                            <label class="form-check-label" for="form-expense-type-equipment">Equipment</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="form-expense-type-others" value="others">
                            <label class="form-check-label" for="form-expense-type-others">Others (Please specify)</label>
                            <input class="form-control" type="input" id="form-expense-type-details" name="type-details">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </form>
    </div>
</div>
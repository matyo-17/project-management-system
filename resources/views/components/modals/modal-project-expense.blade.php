<div class="modal fade" id="modal-expense" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form class="modal-content" id="form-expense" action="javascript:saveExpense()">
            <div class="modal-header">
                <h5 class="modal-title">Expense</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="form-expense-project-id" name="project-id" value="{{ $project->id }}">

                <div class="row row-cols-1 rol-cols-md-2">
                    <div class="col mb-2">
                        <label for="form-expense-description" class="form-label">Description</label>
                        <textarea id="form-expense-description" class="form-control" name="description" rows="2"></textarea>
                    </div>
                </div>

                <div class="row row-cols-1 rol-cols-md-2">
                    <div class="col mb-2">
                        <label for="form-expense-expense-date" class="form-label">Date</label>
                        <input type="date" id="form-expense-expense-date" class="form-control" name="expense-date" required>
                    </div>
                    <div class="col mb-2">
                        <label for="form-expense-amount" class="form-label">Amount</label>
                        <input type="number" id="form-expense-amount" class="form-control" name="amount" required>
                    </div>
                </div>

                <div class="row row-cols-1 rol-cols-md-2">
                    <!-- <div class="col mb-2">
                        <label for="form-expense-type" class="form-label">Type</label>
                        <select id="form-expense-type" class="form-select" name="type" required>
                            <option value="" selected hidden>Please Select...</option>
                            <option value=""></option>
                            <option value="others">Others (Please Specify)</option>
                        </select>
                    </div>
                    <div class="col mb-2">
                        <label for="form-expense-type-details" class="form-label">Type Details</label>
                        <input type="test" id="form-expense-type-details" class="form-control" name="type-details" required>
                    </div> -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </form>
    </div>
</div>
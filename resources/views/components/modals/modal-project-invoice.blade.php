<div class="modal fade" id="modal-invoice" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form class="modal-content" id="form-invoice" action="javascript:saveInvoice()">
            <div class="modal-header">
                <h5 class="modal-title">Invoice</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="form-invoice-project-id" name="project-id" value="{{ $project->id }}">

                <div class="row row-cols-1 rol-cols-md-2">
                    <div class="col mb-2">
                        <label for="form-invoice-due-date" class="form-label">Due Date</label>
                        <input type="date" id="form-invoice-due-date" class="form-control" name="due-date" min="{{ now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="col mb-2">
                        <label for="form-invoice-amount" class="form-label">Amount</label>
                        <input type="number" id="form-invoice-amount" class="form-control" name="amount" min="0" step="0.01" required>
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
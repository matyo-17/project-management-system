@extends("layouts.main")

@section("title", "Project Info")

@section("content")
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
                        <input type="date" id="form-invoice-due-date" class="form-control" name="due-date" required>
                    </div>
                    <div class="col mb-2">
                        <label for="form-invoice-amount" class="form-label">Amount</label>
                        <input type="number" id="form-invoice-amount" class="form-control" name="amount" required>
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
                        <label for="form-expense-due-date" class="form-label">Due Date</label>
                        <input type="date" id="form-expense-due-date" class="form-control" name="due-date" required>
                    </div>
                    <div class="col mb-2">
                        <label for="form-expense-amount" class="form-label">Amount</label>
                        <input type="number" id="form-expense-amount" class="form-control" name="amount" required>
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

<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $project->title }}</h5>
        <p class="card-text">{{ $project->description }}</p>

        <div class="row mb-2">
            <div class="col-12 col-md-4 fw-bold">Start Date</div>
            <div class="col-12 col-md-8">{{ $project->start_date }}</div>
        </div>

        <div class="row mb-2">
            <div class="col-12 col-md-4 fw-bold">End Date</div>
            <div class="col-12 col-md-8">{{ $project->end_date }}</div>
        </div>

        <div class="row mb-2">
            <div class="col-12 col-md-4 fw-bold">Budget</div>
            <div class="col-12 col-md-8">RM {{ $project->budget }}</div>
        </div>

        <div class="row mb-2">
            <div class="col-12 col-md-4 fw-bold">Status</div>
            <div class="col-12 col-md-8">{{ $project->status }}</div>
        </div>
    </div>
</div>

<br>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Users</h5>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="text-center table-primary">
                    <tr>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($project->users as $u)
                    <tr>
                        <td>{{ $u->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<br>

<div class="card">
    <div class="card-body">
        <div class="row align-items-center mb-2">
            <div class="col-8">
                <h5 class="card-title">Invoices</h5>
            </div>
            <div class="col-4 text-end">
                <button class="btn btn-primary" onclick="createInvoice()">
                    <i class="fa fa-plus"></i>&nbsp;New
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="text-center table-primary">
                    <tr>
                        <th>Invoice No.</th>
                        <th>Amount (RM)</th>
                        <th>Due Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if($project->invoices)
                        @foreach ($project->invoices as $i)
                        <tr>
                            <td>{{ $i->inv_no }}</td>
                            <td>{{ number_format($i->amount, 2) }}</td>
                            <td>{{ $i->due_date }}</td>
                            <td>{{ ucfirst($i->status) }}</td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4">No data available</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<br>

<div class="card">
    <div class="card-body">
        <div class="row align-items-center mb-2">
            <div class="col-8">
                <h5 class="card-title">Expenses</h5>
            </div>
            <div class="col-4 text-end">
                <button class="btn btn-primary" onclick="createExpense()">
                    <i class="fa fa-plus"></i>&nbsp;New
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="text-center table-primary">
                    <tr>
                        <th>Expense Date</th>
                        <th>Description</th>
                        <th>Amount (RM)</th>
                        <th>Type</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if($project->expenses)
                        @foreach ($project->expenses as $e)
                        <tr>
                            <td>{{ $e->expense_date }}</td>
                            <td>{{ $e->description }}</td>
                            <td>{{ number_format($e->amount) }}</td>
                            <td>{{ $e->type ?: $e->type_details }}</td>
                            <td>{{ ucfirst($e->status) }}</td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">No data available</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section("scripts")
<script>
    function createInvoice() {
        $('#form-invoice').get(0).reset();
        $('#modal-invoice').modal("toggle");
    }

    function saveInvoice() {
        $.ajax({
            url: "/api/invoice",
            type: 'post',
            data: formToObject("form-invoice"),
            success: function(res) {
                toast('success', 'Success', 'Data will refresh in a few seconds...');
                $('#modal-invoice').modal("toggle");
                setTimeout(function () { location.reload() }, 500);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                toast('danger', 'Failed', xhr.responseJSON.error);
            }
        });
    }
</script>

<script>
    function createExpense() {
        $('#form-expense').get(0).reset();
        $('#modal-expense').modal("toggle");
    }

    function saveExpense() {
        $.ajax({
            url: "/api/expense",
            type: 'post',
            data: formToObject("form-expense"),
            success: function(res) {
                toast('success', 'Success', 'Data will refresh in a few seconds...');
                $('#modal-expense').modal("toggle");
                setTimeout(function () { location.reload() }, 500);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                toast('danger', 'Failed', xhr.responseJSON.error);
            }
        });
    }
</script>
@endsection
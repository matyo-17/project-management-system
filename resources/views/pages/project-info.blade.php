@extends("layouts.main")

@section("title", "Project Info")

@section("content")
<x-modals.modal-project-invoice :$project />
<x-modals.modal-project-expense :$project />

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
            <div class="col-12 col-md-8">{{ ucfirst($project->status) }}</div>
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
            @if ($user->has_permission('create_invoice'))
            <div class="col-4 text-end">
                <button class="btn btn-primary" onclick="createInvoice()">
                    <i class="fa fa-plus"></i>&nbsp;New
                </button>
            </div>
            @endif
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
                    @if (count($project->invoices))
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
            @if ($user->has_permission('create_expense'))
            <div class="col-4 text-end">
                <button class="btn btn-primary" onclick="createExpense()">
                    <i class="fa fa-plus"></i>&nbsp;New
                </button>
            </div>
            @endif
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
                    @if(count($project->expenses))
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
@if ($user->has_permission('create_invoice'))
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
@endif

@if ($user->has_permission('create_expense'))
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
@endif
@endsection
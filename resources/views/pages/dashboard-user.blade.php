@extends("layouts.main")

@section("title", "Dashboard")

@section("content")
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Projects</h5>
        <x-datatable id="project-datatable" />
    </div>
</div>

<br>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Expenses</h5>
        <x-datatable id="expense-datatable" />
    </div>
</div>
@endsection

@section("scripts")
<script>
var expenseTableOptions = {
    ajax: {
        url: '/api/datatable/expenses',
        type: 'post',
        headers: ajaxHeaders,
    },
    columns: [
        { data: 'expense_date', title: 'Date' },
        { data: 'description', title: 'Description' },
        { data: 'amount', title: 'Amount (RM)' },
        {
            data: 'type', title: 'Type',
            render: function (data, type, row) {
                if (data == "others") {
                    text = row.type_details;
                } else {
                    text = data;
                }
                return text;
            }
        },
        { 
            data: 'status', title: 'Status',
            render: function (data, type, row) {
                text = data;
                switch (data) {
                    case 'approved':
                        className = "text-bg-success";
                        break;
                    case 'rejected':
                        className = "text-bg-danger";
                        break;
                    case 'pending':
                        className = "text-bg-warning";
                        break;
                    default:
                        className = "text-bg-light";
                }
                return '<span class="badge rounded-pill ' + className + '">'+ text +'</span>';
                
            }
        },
    ],
}
var expenseTable = $("#expense-datatable").DataTable($.extend(expenseTableOptions, baseTableOptions));

var projectTableOptions = {
    ajax: {
        url: '/api/datatable/projects',
        type: 'post',
        headers: ajaxHeaders,
    },
    columns: [
        { data: 'id', visible: false },
        { data: 'title', title: 'Title' },
        { data: 'start_date', title: 'Start Date' },
        { data: 'end_date', title: 'End Date' },
        { data: 'budget', title: 'Budget (RM)' },
        { 
            data: 'status', title: 'Status',
            render: function (data, type, row) {
                text = data;
                switch (data) {
                    case 'completed':
                        className = "text-bg-success";
                        break;
                    case 'pending':
                        className = "text-bg-warning";
                        break;
                    case 'cancelled':
                        className = "text-bg-danger";
                        break;
                    default:
                        className = "text-bg-light";
                }
                return '<span class="badge rounded-pill ' + className + '">'+ text +'</span>';
                
            }
        },
    ],
}

var projectTable = $("#project-datatable").DataTable($.extend(projectTableOptions, baseTableOptions));
</script>
@endsection
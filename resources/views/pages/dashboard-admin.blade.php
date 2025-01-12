@extends("layouts.main")

@section("title", "Dashboard")

@section("content")
<div class="row row-cols-1 row-cols-md-3 mb-2">
    <div class="col mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Projects</h5>
                <table class="table table-sm m-0">
                    <tr>
                        <th class="text-info">Paid</th>
                        <td><span id="project-count"></span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col mb-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Invoices</h5>
                <table class="table table-sm m-0">
                    <tr>
                        <th class="text-success">Paid</th>
                        <td>RM&emsp;<span id="paid-amount"></span></td>
                        <td><span id="paid-count"></span></td>
                    </tr>
                    <tr>
                        <th class="text-danger">Unpaid</th>
                        <td>RM&emsp;<span id="unpaid-amount"></span></td>
                        <td><span id="unpaid-count"></span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Expenses</h5>
                <table class="table table-sm m-0">
                    <tr>
                        <th class="text-infp">Total</th>
                        <td>RM&emsp;<span id="expense-amount"></span></td>
                        <td><span id="expense-count"></span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col mb-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Overdue Invoices</h5>
                <x-datatable />
            </div>
        </div>
    </div>
</div>
@endsection

@section("scripts")
<script>
var tableOptions = {
    ajax: {
        url: '/api/datatable/invoices',
        type: 'post',
        headers: ajaxHeaders,
        data: function (d) {
            d.filters = {
                'overdue': true,
            };
            return d;
        },
    },
    columns: [
        { data: 'id', visible: false },
        { data: 'inv_no', title: 'Invoice No.' },
        { data: 'due_date', title: 'Due Date' },
        { data: 'amount', title: 'Amount (RM)' },
        { 
            data: 'status', title: 'Status',
            render: function (data, type, row) {
                text = data;
                switch (data) {
                    case 'paid':
                        className = "text-bg-success";
                        break;
                    case 'unpaid':
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

var table = $("#datatable").DataTable($.extend(tableOptions, baseTableOptions));

$(document).ready(function () {
    $.ajax({
        headers: ajaxHeaders,
        url: '/api/summary',
        type: 'get',
        success: function(res) {
            data = res.data;

            $("#project-count").html(data.project_count);
            $("#paid-amount").html(data.paid_amount);
            $("#paid-count").html(data.paid_count);
            $("#unpaid-amount").html(data.unpaid_amount);
            $("#unpaid-count").html(data.unpaid_count);
            $("#expense-count").html(data.expense_count);
            $("#expense-amount").html(data.expense_amount);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            toast('danger', 'Failed', thrownError);
        }
    });
});
</script>
@endsection
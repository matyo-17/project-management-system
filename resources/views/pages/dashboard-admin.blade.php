@extends("layouts.main")

@section("title", "Dashboard")

@section("content")
<div class="card">
    <div class="card-body">
        <h5 class="card-title"></h5>
    </div>
</div>

<br>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Overdue Invoices</h5>
        <x-datatable />
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
</script>
@endsection
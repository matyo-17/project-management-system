@extends("layouts.main")

@section("title", "Invoices")

@section("content")
<div class="card">
    <div class="card-body">
        <x-datatable />
    </div>
</div>
@endsection

@section("scripts")
<script>
    var urlCrud = '/api/invoice';

    var tableOptions = {
        ajax: {
            url: '/api/datatable/invoices',
            type: 'post',
            headers: ajaxHeaders,
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
            {
                data: 'id', title: 'Action', orderable: false,
                render: function (data, type, row) {
                    display = "&nbsp;";
                    
                    @if ($user->has_permission("read_project"))
                    display += infoButton(row.project.info_url, "Project");
                    @endif

                    @if ($user->has_permission("update_invoice_status"))
                    if (row.status == 'unpaid') {
                        display += `<button class="btn btn-success" onclick="paid('`+data+`')">
                                        <i class="fa fa-check"></i>&nbsp;Paid
                                    </button>&nbsp;`;
                    }
                    @endif

                    @if ($user->has_permission("delete_invoice"))
                    display += deleteButton(data);
                    @endif

                    return display;
                }
            },
        ],
    }

    var table = $("#datatable").DataTable($.extend(tableOptions, baseTableOptions));

    @if ($user->has_permission("update_invoice_status"))
    function paid(id) {
        doubleConfirm("Paid", function () {
            $.ajax({
                url: urlCrud + '/' + id + '/status',
                type: 'patch',
                data: {
                    status: 'paid'
                },
                success: function(res){
                    toast('success', 'Success', 'Data will refresh in a few seconds...');
                    table.draw(false);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    toast('danger', 'Failed', xhr.responseJSON.error);
                }
            });
        });
    }
    @endif

    @if ($user->has_permission("delete_invoice"))
    function softDelete(id) {
        doubleConfirm("Delete", function () {
            $.ajax({
                url: urlCrud + '/' + id,
                type: 'delete',
                success: function(res) {
                    toast('success', 'Success', 'Data will refresh in a few seconds...');
                    table.draw(false);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    toast('danger', 'Failed', xhr.responseJSON.error);
                }
            });
        });
    }
    @endif
</script>
@endsection
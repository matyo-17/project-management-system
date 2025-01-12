@extends("layouts.main")

@section("title", "Expenses")

@section("content")
<x-modals.modal-expense />

<div class="card">
    <div class="card-body">
        <x-datatable />
    </div>
</div>
@endsection

@section("scripts")
<script>
    var urlCrud = '/api/expense';

    var tableOptions = {
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
            {
                data: 'id', title: 'Action', orderable: false,
                render: function (data, type, row) {
                    display = "&nbsp;";
                    display += infoButton(row.project.info_url, "Project");
                    display += infoButton(row.info_url);

                    @if ($user->has_permission("update_expense"))
                    display += editButton(data);
                    @endif

                    @if ($user->has_permission("update_expense_status"))
                    if (row.status == "pending") {
                        display += `<button class="btn btn-success" onclick="changeStatus('`+data+`', 1)">
                                        <i class="fa fa-check"></i>&nbsp;Approve
                                    </button>&nbsp;`;
                        display += `<button class="btn btn-danger" onclick="changeStatus('`+data+`', 0)">
                                        <i class="fa fa-x"></i>&nbsp;Reject
                                    </button>&nbsp;`;
                    }
                    @endif

                    @if ($user->has_permission("delete_expense"))
                    display += deleteButton(data);
                    @endif

                    return display;
                }
            },
        ],
    }

    var table = $("#datatable").DataTable($.extend(tableOptions, baseTableOptions));

    function resetForm() {
        $('#form-expense').get(0).reset();
        $("#form-expense input[type=hidden]").val('');
    }

    function update(id) {
        resetForm();
        $.ajax({
            url: urlCrud + '/' + id,
            type: 'get',
            success: function(res) {
                data = res.data;
                $("#form-expense-id").val(id);
                $("#form-expense-project-id").val(data.project_id);
                $("#form-expense-description").val(data.description);
                $("#form-expense-expense-date").val(data.expense_date);
                $("#form-expense-amount").val(data.amount);
                $("#form-expense-status").val(data.status).trigger("change");
                $("#form-expense-type-"+data.type).prop("checked", true);
                $("#form-expense-type-details").val(data.type_details);
                $('#modal-expense').modal("toggle");
            },
            error: function(xhr, ajaxOptions, thrownError) {
                toast('danger', 'Failed', xhr.responseJSON.error);
            }
        });
    }
    
    @if ($user->has_permission('update_expense'))
    function save() {
        var formData = formToObject("form-expense");
        $.ajax({
            url: (formData.id) ? urlCrud + '/' + formData.id : urlCrud,
            type: (formData.id) ? 'patch' : 'post',
            data: formData,
            success: function(res){
                toast('success', 'Success', 'Data will refresh in a few seconds...');
                $('#modal-expense').modal("toggle");
                table.draw(false);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                toast('danger', 'Failed', xhr.responseJSON.error);
            }
        });
    }
    @endif

    @if ($user->has_permission("update_expense_status"))
    function changeStatus(id, status) {
        if (status) {
            text = "Approve Expense";
            status = "approved";
        } else {
            text = "Reject Expense";
            status = "rejected";
        } 

        doubleConfirm(text, function () {
            $.ajax({
                url: urlCrud + '/' + id + '/status',
                type: 'patch',
                data: {
                    status: status
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

    @if ($user->has_permission("delete_expense"))
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
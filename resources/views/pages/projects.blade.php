@extends("layouts.main")

@section("title", "Projects")

@section("content")
<div class="card">
    <x-modals.modal-project :$user />

    <div class="card-body">
        @if ($user->has_permission('create_project'))
        <x-buttons.create-new />
        @endif
        <x-datatable />
    </div>
</div>
@endsection

@section("scripts")
<script>
    var urlCrud = '/api/project';
    var tableOptions = {
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
            {
                data: 'id', title: 'Action', orderable: false,
                render: function (data, type, row) {
                    display = "&nbsp;";
                    display += infoButton(row.info_url);
                    
                    @if ($user->has_permission('update_project'))
                    display += editButton(data);
                    @endif
                    
                    @if ($user->has_permission('delete_project'))
                    display += deleteButton(data);
                    @endif

                    return display;
                }
            },
        ],
    }

    var table = $("#datatable").DataTable($.extend(tableOptions, baseTableOptions));
    var modal = $('#modal-form');

    function resetForm() {
        $('#form-modal').get(0).reset();
        $("#form-modal input[type=hidden]").val('');
        $("#modal-form-users").val('').trigger("change");
    }

    function update(id) {
        resetForm();
        $.ajax({
            url: urlCrud + '/' + id,
            type: 'get',
            success: function(res) {
                data = res.data;

                users = [];
                data.users.forEach(function (e) { users.push(e.id); });

                $("#modal-form-id").val(id);
                $("#modal-form-title").val(data.title);
                $("#modal-form-description").val(data.description);
                $("#modal-form-start-date").val(data.start_date);
                $("#modal-form-end-date").val(data.end_date);
                $("#modal-form-budget").val(data.budget);
                $("#modal-form-status").val(data.status).trigger("change");
                $("#modal-form-users").val(users).trigger("change");
                modal.modal("toggle");
            },
            error: function(xhr, ajaxOptions, thrownError) {
                toast('danger', 'Failed', xhr.responseJSON.error);
            }
        });
    }
    
    @if ($user->has_permission('create_project') || $user->has_permission('update_project'))
    function save() {
        var formData = formToObject("form-modal");
        $.ajax({
            url: (formData.id) ? urlCrud + '/' + formData.id : urlCrud,
            type: (formData.id) ? 'patch' : 'post',
            data: formData,
            success: function(res){
                toast('success', 'Success', 'Data will refresh in a few seconds...');
                modal.modal("toggle");
                table.draw(false);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                toast('danger', 'Failed', xhr.responseJSON.error);
            }
        });
    }
    @endif

    @if ($user->has_permission('delete_project'))
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
@extends("layouts.main")

@section("title", "Roles")

@section("content")
<x-modals.modal-role :$permissions />

<div class="card">
    <div class="card-body">
        @if ($user->has_permission('create_role'))
        <x-buttons.create-new />
        @endif

        <x-datatable />
    </div>
</div>
@endsection

@section("scripts")
<script>
    var urlCrud = '/api/role';
    var tableOptions = {
        ajax: {
            url: '/api/datatable/roles',
            type: 'post',
            headers: ajaxHeaders,
        },
        columns: [
            { data: 'id', visible: false },
            { data: 'name', title: 'Name' },
            { 
                data: 'admin', title: 'Is Admin',
                render: function (data, type, row) {
                    text = data;
                    if (data) {
                        className = "text-bg-success";
                        text = "yes";
                    } else {
                        className = "text-bg-danger";
                        text = "no";
                    }
                    return '<span class="badge rounded-pill ' + className + '">'+ text +'</span>';
                    
                }
            },
            { 
                data: 'status', title: 'Status',
                render: function (data, type, row) {
                    text = data;
                    if (data) {
                        className = "text-bg-success";
                        text = "active";
                    } else {
                        className = "text-bg-danger";
                        text = "inactive";
                    }
                    return '<span class="badge rounded-pill ' + className + '">'+ text +'</span>';
                    
                }
            },
            {
                data: 'id', title: 'Action', orderable: false,
                render: function (data, type, row) {
                    display = "&nbsp;";
                    
                    @if ($user->has_permission('update_role'))
                    display += editButton(data);
                    @endif
                    
                    @if ($user->has_permission('delete_role'))
                    display += deleteButton(data);
                    @endif

                    return display;
                }
            },
        ],
        order: [[0, 'asc']],
    }

    var table = $("#datatable").DataTable($.extend(baseTableOptions, tableOptions));
    var modal = $('#modal-form');

    function resetForm() {
        $('#form-modal').get(0).reset();
        $("#form-modal input[type=hidden]").val('');
        $("#form-modal input[type=checkbox]").attr('checked', false);
    }

    function update(id) {
        resetForm();
        $.ajax({
            url: urlCrud + '/' + id,
            type: 'get',
            success: function(res) {
                data = res.data;

                $("#modal-form-id").val(id);
                $("#modal-form-name").val(data.name);
                $("#modal-form-status").val(data.status).trigger("change");
                $("#modal-form-admin").val(data.admin).trigger("change");

                permissions = data.permissions;
                permissions.forEach(function (e) {
                    $("#modal-form-permission-"+e.name.replaceAll('_', '-')).attr('checked', true);
                });
                modal.modal("toggle");
            },
            error: function(xhr, ajaxOptions, thrownError) {
                toast('danger', 'Failed', xhr.responseJSON.error);
            }
        });
    }
    
    @if ($user->has_permission('create_role') || $user->has_permission('update_role'))
    function save() {
        var formData = formToObject("form-modal");

        var formDataPermissions = [];
        $("input:checkbox[name=permissions]:checked").each(function(){
            formDataPermissions.push($(this).val());
        });
        formData.permissions = formDataPermissions;
        
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

    @if ($user->has_permission('delete_role'))
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
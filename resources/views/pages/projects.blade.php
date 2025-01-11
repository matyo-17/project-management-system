@extends("layouts.main")

@section("content")
<div class="card">
    <div class="modal fade" id="modal-form" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form class="modal-content" id="form-modal" action="javascript:save()">
                <div class="modal-header">
                    <h5 class="modal-title">Project</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="modal-form-id" name="id">

                    <div class="row row-cols-1 rol-cols-md-2">
                        <div class="col mb-2">
                            <label for="modal-form-title" class="form-label">Title</label>
                            <input type="text" id="modal-form-title" class="form-control" name="title" required>
                        </div>
                    </div>

                    <div class="row row-cols-1 rol-cols-md-2">
                        <div class="col mb-2">
                            <label for="modal-form-description" class="form-label">Description</label>
                            <textarea id="modal-form-description" class="form-control" name="description" rows="2"></textarea>
                        </div>
                    </div>

                    <div class="row row-cols-1 rol-cols-md-2">
                        <div class="col mb-2">
                            <label for="modal-form-start-date" class="form-label">Start Date</label>
                            <input type="date" id="modal-form-start-date" class="form-control" name="start-date" required>
                        </div>
                        <div class="col mb-2">
                            <label for="modal-form-end-date" class="form-label">End Date</label>
                            <input type="date" id="modal-form-end-date" class="form-control" name="end-date" required>
                        </div>
                    </div>
                    
                    <div class="row row-cols-1 rol-cols-md-2">
                        <div class="col mb-2">
                            <label for="modal-form-budget" class="form-label">Budget</label>
                            <input type="number" id="modal-form-budget" class="form-control" name="budget" required>
                        </div>
                        <div class="col mb-2">
                            <label for="modal-form-status" class="form-label">Status</label>
                            <select id="modal-form-status" class="form-select" name="status" required>
                                <option value="completed">Completed</option>
                                <option value="ongoing" selected>Ongoing</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
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

    <div class="card-body">
        <div class="col d-flex justify-content-end">
            <button class="btn btn-primary" onclick="create()">
                <i class="fa fa-plus"></i>&nbsp;New
            </button>
        </div>
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
            { data: 'budget', title: 'Budget' },
            { data: 'status', title: 'Status' },
            {
                data: 'id', title: 'Action', orderable: false,
                render: function (data, type, row) {
                    display = "&nbsp;";
                    display += editButton(data);
                    display += deleteButton(data);
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
    }

    function update(id) {
        resetForm();
        $.ajax({
            url: urlCrud + '/' + id,
            type: 'get',
            success: function(res) {
                data = res.data;
                $("#modal-form-id").val(id);
                $("#modal-form-title").val(data.title);
                $("#modal-form-description").val(data.description);
                $("#modal-form-start-date").val(data.start_date);
                $("#modal-form-end-date").val(data.end_date);
                $("#modal-form-budget").val(data.budget);
                $("#modal-form-status").val(data.status).trigger("change");
                modal.modal("toggle");
            },
            error: function(xhr, ajaxOptions, thrownError) {
                toast('danger', 'Failed', xhr.responseJSON.error);
            }
        });
    }

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
</script>
@endsection
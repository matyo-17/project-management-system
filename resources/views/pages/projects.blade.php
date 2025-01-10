@extends("layouts.main")

@section("content")
<div class="card">
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
</script>
@endsection
var baseTableOptions = {
    processing: true,
    serverSide: true,
    searching: false,
    pagingType: "simple_numbers",
    bLengthChange: false,
    pageLength: 10,
    columnDefs: [
        {targets: '_all', className: 'text-center'},
    ],
    language: {
        lengthMenu: "Show _MENU_ entries",
        loadingRecords: "<div class='text-center'>Loading...</div>",
        emptyTable: "<div class='text-center'>No data available in table</div>",
        paginate: {
            previous: '<i class="fa fa-arrow-left">',
            next: '<i class="fa fa-arrow-right">',
        }
    },
}

function create() {
    resetForm();
    modal.modal("toggle");
}

function editButton(id) {
    return `<button class="btn btn-primary btn-icon" onclick="update('`+id+`')">
                <i class="fa fa-pen"></i>
            </button>&nbsp;`;
}

function deleteButton(id) {
    return `<button class="btn btn-danger btn-icon" onclick="delete('`+id+`')">
                <i class="fa fa-trash"></i>
            </button>&nbsp;`
}
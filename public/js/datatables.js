var baseTableOptions = {
    processing: true,
    serverSide: true,
    searching: false,
    pagingType: "simple_numbers",
    bLengthChange: false,
    pageLength: 10,
    columnDefs: [
        { targets: '_all', className: 'text-center', orderSequence: ['asc', 'desc'] },
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
    order: [[0, 'desc']],
}

function create() {
    resetForm();
    modal.modal("toggle");
}

function infoButton(url, text="Info") {
    return `<a class="btn btn-info" href="`+url+`">
                <i class="fa fa-info-circle"></i>&nbsp;`+text+`
            </a>&nbsp;`;
}

function editButton(id) {
    return `<button class="btn btn-primary" onclick="update('`+id+`')">
                <i class="fa fa-pen"></i>&nbsp;Edit
            </button>&nbsp;`;
}

function deleteButton(id) {
    return `<button class="btn btn-outline-danger" onclick="softDelete('`+id+`')">
                <i class="fa fa-trash"></i>&nbsp;Delete
            </button>&nbsp;`
}
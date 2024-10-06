let columns = [
    { data: 'id' },
    { data: 'name' },
    { data: 'email' },
    { data: 'mobile' },
    { data: 'designation' },
    { data: 'emp_type' },
    { data: 'dob' },
    { data: 'city' },
    { data: 'country' },
    {
        data: 'action',
        orderable: false,
        searchable: false,
        responsive:true
    },
];
let column_defs = [
    { targets: 6, visible: false },
    { targets: 7, visible: false },
    { targets: 8, visible: false },
    {"className": "text-center", "targets": [0,9]}
];

var table = $('#dataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/employees",
        data: function (d) {
            d.status     = $("#employeeStatus").val()
            d.is_deleted = $("#isDeleted").val()
        }
    },
    columns: columns,
    dom: 'Bfrtip',
    buttons: [
        'pageLength',
        {
            text : '<i class="fas fa-download"></i> Export',
            extend: 'collection',
            className: 'custom-html-collection pull-right',
            buttons: [
                'pdf',
                'csv',
                'excel',
            ]
        },
        { html: colVisibility('#dataTable', column_defs) },
        { html: '<a class="dt-button buttons-collection" href="'+ BASE_URL +'/employees/create"><i class="fas fa-plus"></i> Add New</a>' }
    ],
    columnDefs: column_defs,
    language: {
        searchPlaceholder: "Search records",
        search: "",
        buttons: {
            pageLength: {
                _: "%d rows",
            }
        }
    }
});

executeColVisibility(table);
// End Tables

window.filterStatus = function (status, type = '')
{
    if(type == 'is_deleted')
    {
        $("#isDeleted").val(1);
    }
    else{
        console.log(status);
        $("#employeeStatus").val(status);
        $("#isDeleted").val(0);
    }
    table.ajax.reload();
}

window.restoreEmployee = function (id)
{
    loading('show');

    axios.post(BASE_URL + '/users/' + id + '/restore-api')
        .then(response => {
            notify(response.data.message, 'success');
            table.ajax.reload();
        })
        .catch(error => {
            const response = error.response;
            if (response)
                notify(response.data.message, 'error');
        })
        .finally(() => {
            loading('hide');
        });
}

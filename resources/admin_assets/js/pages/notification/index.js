let columns = [
    { data: 'id' },
    { data: 'message' },
    { data: 'subject' },
    { data: 'employee' },
    { data: 'member' },
    { data: 'send_date' },
    { data: 'created_at' },
    {
        data: 'action',
        orderable: false,
        searchable: false,
        responsive:true
    },
];
let column_defs = [
    { targets: 2, visible: true },
    {"className": "text-center", "targets": [0,3,4,5,6]}
];

var table = $('#dataTable').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/notifications",
        data: function (d) {
            d.is_for_emp = $('#is_for_emp:checked').val(),
            d.is_for_member = $('#is_for_member:checked').val()
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
        { html: '<a class="dt-button buttons-collection" href="'+ BASE_URL +'/notifications/create"><i class="fas fa-plus"></i> Add New</a>' }
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

$("#is_for_emp, #is_for_member").on('change', function () {
    table.ajax.reload()
});

window.deleteNotification = function (id)
{
    loading('show');

    axios.post(BASE_URL + '/notifications/' + id + '/delete-api')
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

let columns = [
    { data: 'id' },
    { data: 'name' },
    { data: 'key' },
    { data: 'updated_at' },
    {
        data: 'action',
        orderable: false,
        searchable: false,
        responsive:true
    },
];
let column_defs = [
    { targets: 2, visible: false },
    {"className": "text-center", "targets": [3]}
];

var table = $('#dataTable').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/configs/email-templates",
    },
    columns: columns,
    dom: 'Bfrtip',
    buttons: [
        'pageLength',
        { html: colVisibility('#dataTable', column_defs) },
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

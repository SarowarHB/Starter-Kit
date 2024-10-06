let columns = [
    {data: 'id', name: 'id'},
    {data: 'sale_to', name: 'sale_to'},
    {data: 'name', name: 'name'},
    {data: 'price', name: 'price'},
    {data: 'quantity', name: 'quantity'},
    {data: 'total', name: 'total'},
    {data: 'lose_or_profit', name: 'lose_or_profit'},
    {data: 'sale_date', name: 'sale_date'},
    {data: 'action', name: 'action', orderable: false, searchable: false, responsive:true},
];
let column_defs = [
    { targets: 4, visible: false },
    {"className": "text-center", "targets": [0,2,3]}
];

var table = $('#dataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/asset/sale",
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


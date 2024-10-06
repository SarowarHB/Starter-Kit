let columns = [
    { data: 'id' },
    { data: 'title' },
    { data: 'blog_type' },
    {
        data: 'action',
        orderable: false,
        searchable: false,
        responsive:true
    },
];
let column_defs = [
    { targets: 2, visible: false },
    {"className": "text-center", "targets": [0,2,3]}
];

var table = $('#dataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/website/blogs",
        data: function (d) {
                d.status    = $("#userStatus").val()
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
        { html: '<a class="dt-button buttons-collection" href="'+ BASE_URL +'/website/blogs/create"><i class="fas fa-plus"></i> Add New</a>' }
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

window.filterStatus = function (status, type = '') {
    if(type == 'is_deleted')
        {
            $("#isDeleted").val(1);
        }
        else{
            $("#userStatus").val(status);
            $("#isDeleted").val(0);
        }
        table.ajax.reload();
}

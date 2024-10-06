let column_defs = [];

var table2 = $('#dataTable').DataTable({
    order: [[0, 'asc']],
    processing: true,
    responsive: true,
    autoWidth: false,
    dom: 'Bfrtip',
    buttons: [
        'pageLength',
        colVisibility('#dataTable', column_defs),
    ],
    columnDefs: column_defs,
    language: {
        searchPlaceholder: "Search records",
        search: "",
        buttons: { pageLength: { _: "%d rows", } }
    }
});
executeColVisibility(table2);
// End Tables


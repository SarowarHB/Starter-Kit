let column_defs = [
    {"className": "text-center", "targets": [0,1,2,3,4,5,6,7]}
];

var table = $('#dataTable').DataTable({
    order: [[0, 'asc']],
    processing: true,
    responsive: true,
    autoWidth: false,
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
        buttons: { pageLength: { _: "%d rows", } }
    }
});
executeColVisibility(table);


window.AcceptStock = function (id)
{
    loading('show');
    console.log(id);

    axios.post(BASE_URL + '/members/' + id + '/stock/accept')
        .then(response => {
            notify(response.data.message, 'success');
            setTimeout(function(){
                location.reload();
             }, 2500);
           
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
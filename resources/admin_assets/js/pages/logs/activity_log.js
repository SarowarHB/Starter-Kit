let columns = [
    { data: 'id' },
    { data: 'log_time' },
    { data: 'event_type' },
    { data: 'subject' },
    { data: 'record_id' },
    { data: 'details' },
    { data: 'action_by' },
    { data: 'user_type' },
    { data: 'ip' },
    { data: 'browser' },
    {
        data: 'action',
        orderable: false,
        searchable: false,
        responsive:true
    },
];

let column_defs = [
    { targets: 4, visible: false },
    { targets: 7, visible: false },
    { targets: 8, visible: false },
    { targets: 9, visible: false },
    { targets: 10, visible: false },
    {"className": "text-center", "targets": [4,5,6]}
];

var table = $('#dataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/logs/activity",
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


window.showActivityLogDetails = function (id) {
    loading('show');
    axios.get(BASE_URL + '/logs/activity/' + id + '/show')
    .then(response => {
        let beforeData = JSON.parse(response.data.data).before;
        let afterData = JSON.parse(response.data.data).after;

        let beforeDataKey = Object.keys(beforeData);
        let beforeDataValue = Object.values(beforeData);

        let afterDataKey = Object.keys(afterData);
        let afterDataValue = Object.values(afterData);

        $('#logTableHead').empty();
        $('#logTableBody').empty();

        if (typeof(beforeData) == 'number') {
            $('#logTableHead').append('<tr><th scope="col">Column</th><th scope="col">Value</th></tr>');
            $('#logTableBody').append('<tr><td>Id</td><td>'+ beforeData +'</td></tr>');
        } else if (afterData == '') {
            $('#logTableHead').append('<tr><th scope="col">Column</th><th scope="col">Value</th></tr>');
            beforeDataKey.forEach(function(beforeDataKey, index) {
                if (beforeDataKey == 'created_at' || beforeDataKey == 'updated_at') {
                    $('#logTableBody').append('<tr><td>'+ beforeDataKey +'</td><td>'+  moment(beforeDataValue[index]).format('DD-MM-YYYY') +'</td></tr>');
                } else {
                    $('#logTableBody').append('<tr><td>'+ beforeDataKey +'</td><td>'+ beforeDataValue[index] +'</td></tr>');
                }
            });
        } else {
            $('#logTableHead').append('<tr><th scope="col">Column</th><th scope="col">Before</th><th scope="col">After</th></tr>');

            beforeDataKey.forEach(function(beforeDataKey, index) {
                if (beforeDataKey == 'updated_at') {
                    $('#logTableBody').append('<tr><td>'+ afterDataKey[index] +'</td><td>'+ moment(beforeDataValue[index]).format('DD-MM-YYYY') +'</td><td>'+  moment(afterDataValue[index]).format('DD-MM-YYYY') +'</td></tr>');
                } else {
                    $('#logTableBody').append('<tr><td>'+ afterDataKey[index] +'</td><td>'+ beforeDataValue[index] +'</td><td>'+ afterDataValue[index] +'</td></tr>');
                }
            });
        }

        $('#activityLogModal').modal('show');
    })
    .catch(error => {
        if (error.response) {
            notify(response.data.message, 'error');
        }
    })
    .finally(() => {
        loading('hide');
    });
}

window.deleteActivityLog = function (id) {
    loading('show');
    axios.post(BASE_URL + '/logs/activity/' + id + '/delete')
    .then(response => {
        notify(response.data.message, 'success');
        table.ajax.reload();
    })
    .catch(error => {
        if (error.response) {
            notify(response.data.message, 'error');
        }
    })
    .finally(() => {
        loading('hide');
    });
}

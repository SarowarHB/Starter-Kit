let columns = [
    { data: 'id', class: 'text-center'  },
    { data: 'name'},
    {
        data: 'action',
        class: 'text-center',
        orderable: false,
        searchable: false,
        responsive:true
    },
];
let column_defs = [
    { targets: 2, visible: true }
];

var table = $('#dataTable').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/configs/roles",
    },
    columns: columns,
    dom: 'Bfrtip',
    buttons: [
        'pageLength',
        { html: colVisibility('#dataTable', column_defs) },
        { html: '<button type="button" class="dt-button buttons-collection" onclick="clickAddAction()"><i class="fas fa-plus"></i>Add New</button>' }
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

const createRoleModal = "#createRoleModal";
const createRoleForm = "#createRoleForm";
const updateRoleModal = "#updateRoleModal";
const updateRoleForm = "#updateRoleForm";

window.clearForm = function ()
{
    $(createRoleForm).find("input[name='name']").val('');
    $(createRoleForm).find("input[name='slug']").val('');
}

window.clickAddAction = function ()
{
    clearValidation(createRoleForm);
    clearForm();
    $(createRoleModal).modal('show');
}

window.clickEditAction = function (id)
{
    loading('show');
    const url = BASE_URL + '/configs/roles/' + id + '/show-api';
    axios.get(url)
        .then(response => {
            const data = response.data;
            clearValidation(updateRoleForm);
            $(updateRoleForm).find("input[name='id']").val(data.id);
            $(updateRoleForm).find("input[name='name']").val(data.name);
            $(updateRoleForm).find("input[name='slug']").val(data.slug);
            $(updateRoleModal).modal('show');
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

window.deleteRole = function (id)
{
    loading('show');
    const url = BASE_URL + '/configs/roles/' + id + '/delete-api';
    axios.post(url)
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

window.createRole = function (e, t)
{
    e.preventDefault();
    const url = BASE_URL + '/configs/roles/create';
    var form_data = $(t).serialize();
    loading('show');
    axios.post(url, form_data)
        .then(response => {
            $(createRoleModal).modal('hide');
            notify(response.data.message, 'success');
            table.ajax.reload();
        })
        .catch(error => {
            const response = error.response;
            if (response) {
                if (response.status === 422)
                    validationForm(createRoleForm, response.data.errors);
                else
                    notify(response.data.message, 'error');
            }
        })
        .finally(() => {
            loading('hide');
        });
}

window.updateRole = function (e, t)
{
    e.preventDefault();
    const role_id = $(updateRoleForm).find("input[name='id']").val();

    const url = BASE_URL + '/configs/roles/' + role_id + '/update-api';
    var form_data = $(t).serialize();

    loading('show');
    axios.post(url, form_data)
        .then(response => {
            $(updateRoleModal).modal('hide');
            notify(response.data.message, 'success');
            table.ajax.reload();
        })
        .catch(error => {
            const response = error.response;
            if (response) {
                if (response.status === 422)
                    validationForm(updateRoleForm, response.data.errors);
                else
                    notify(response.data.message, 'error');
            }
        })
        .finally(() => {
            loading('hide');
        });
}

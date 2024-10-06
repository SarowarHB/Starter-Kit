var table = $('#dropdownTable').DataTable({
    processing: true,
    responsive: true,
    autoWidth: false,
    dom: 'Bfrtip',
    buttons: [
        'pageLength',
        '<button type="button" class="dt-button buttons-collection" onclick="clickAddAction()"><i class="fas fa-plus"></i>Add New</button>',
    ],
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


const createDropdownModal = "#createDropdownModal";
const createDropdownForm = "#createDropdownForm";
const updateDropdownModal = "#updateDropdownModal";
const updateDropdownForm = "#updateDropdownForm";

function clearForm()
{
    $(createDropdownModal).find("input[name='name']").val('');
}

window.clickAddAction = function ()
{
    clearForm();
    $(createDropdownModal).modal('show');
}

window.clickEditAction = function (id, name)
{
    $(updateDropdownForm).find("input[name='id']").val(id);
    $(updateDropdownForm).find("input[name='name']").val(name);
    $(updateDropdownModal).modal('show');
}

window.createDropdown = function (e, t)
{
    e.preventDefault();
    const url = BASE_URL + '/configs/dropdowns/'+ dropdown_key +'/create-api';
    const form_data = $(t).serialize();
    loading('show');
    axios.post(url, form_data)
        .then(response => {
            $(createDropdownModal).modal('hide');
            notify(response.data.message, 'success', function (){
                location.reload();
            });
        })
        .catch(error => {
            const response = error.response;
            if (response) {
                if (response.status === 422)
                    validationForm(createDropdownForm, response.data.errors);
                else
                    notify(response.data.message, 'error');
            }
        })
        .finally(() => {
            loading('hide');
        });
}

window.updateDropdown = function (e, t)
{
    e.preventDefault();
    const dropdown_id = $(updateDropdownForm).find("input[name='id']").val();

    const url = BASE_URL + '/configs/dropdowns/' + dropdown_key + '/' + dropdown_id + '/update-api';
    var form_data = $(t).serialize();

    loading('show');
    axios.post(url, form_data)
        .then(response => {
            $(updateDropdownModal).modal('hide');
            notify(response.data.message, 'success', function (){
                location.reload();
            });
        })
        .catch(error => {
            const response = error.response;
            if (response) {
                if (response.status === 422)
                    validationForm(updateDropdownForm, response.data.errors);
                else
                    notify(response.data.message, 'error');
            }
        })
        .finally(() => {
            loading('hide');
        });
}

window.deleteDropdown = function (id)
{
    loading('show');
    const url = BASE_URL + '/configs/dropdowns/' + dropdown_key + '/' + id + '/delete-api';
    axios.post(url)
        .then(response => {
            notify(response.data.message, 'success', function (){
                location.reload();
            });
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

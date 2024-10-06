const testMailModal = "#testMailModal";
const testMailForm = "#testMailForm";

window.clearForm = function ()
{
    $(testMailForm).find("input[name='name']").val('');
    $(testMailForm).find("input[name='slug']").val('');
}

window.clickAddAction = function ()
{
    clearValidation(testMailForm);
    clearForm();
    $(testMailModal).modal('show');
}

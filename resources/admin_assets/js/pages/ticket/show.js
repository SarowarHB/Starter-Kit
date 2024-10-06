$('#fileButton').click(function () {
    $('#fileOpen').click();
    $('#fileOpen').change(function () {
        var fileName = $(this).val().split('\\')[$(this).val().split('\\').length - 1];
        $('#fileName').html("<b>File: </b>" + fileName);
    });
});

const updateAssignModal = "#updateAssignModal";
const updateAssignForm = "#updateAssignForm";

const updateStatusModal = "#updateStatusModal";
const updateStatusForm = "#updateStatusForm";

function clearForm() {
    $(updateAssignForm).find("#note").val("");
}

window.clickUpdateAssignAction = function () {
    clearValidation(updateAssignForm);
    clearForm();
    $(updateAssignModal).modal('show');
}

window.clickUpdateStatus = function () {
    clearValidation(updateStatusForm);
    $(updateStatusModal).modal('show');
}

$('#ticketMessage').summernote({
    height: 320
});
window.confirmFormModal = function (route, title='Confirmation',  message = 'Are you sure?',  confirm_label = 'Confirm', cancel_label = 'Cancel')
{
    const csrf_token = $("meta[name='csrf-token']").attr("content");
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success btn-sm',
            cancelButton: 'btn btn-danger mr-3 btn-sm',
            container : 'custom-swal-container'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: title,
        text: message,
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: confirm_label,
        cancelButtonText: cancel_label,
        reverseButtons: true,
    }).then((result) => {
        if (result.value) {
            $('<form method="POST" action="' + route + '"><input type="hidden" name="_token" value="' + csrf_token + '"></form>')
                .appendTo('body')
                .submit();
        }
    })
}

window.confirmModal = function (callback, id='', message = 'Are you sure?',title='Confirmation',  confirm_label = 'Confirm', cancel_label = 'Cancel')
{
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn2-secondary btn-sm',
            cancelButton: 'btn btn2-light-secondary mr-3 btn-sm',
            container : 'custom-swal-container'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: title,
        text: message,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-check"></i> ' + confirm_label,
        cancelButtonText: '<i class="fas fa-times"></i> ' + cancel_label,
        reverseButtons: true,
    }).then((result) => {
        if (result.value) {
            if(id)
                callback(id);
            else
                callback();
        }
    })
}

window.notify = function (message, type = 'success', callback = null) {
    Swal.fire({
        position: 'center',
        icon: type,
        text: message,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        willClose: () => {
            if(typeof callback === 'function')
            {
                callback();
            }
        }
    });
}

window.validationForm = function (selector, errors)
 {

     $.each(errors, function(fieldName, fieldErrors)
     {
         $.each(fieldErrors, function(errorType, errorValue) {

             var fieldSelector = selector + " [name='"+fieldName+"']";

             if($(fieldSelector).parents(".form-group").hasClass("error")) {
                 $(fieldSelector).parents(".form-group").find(".error-message").remove();
                 $(fieldSelector).parents(".form-group").removeClass("error");
             }

             $("<p class='error-message'>"+errorValue+"</p>")
                 .insertAfter(fieldSelector)
                 .parents(".form-group").addClass('error');

             $(fieldSelector).on("keyup", function(event) {
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if(keycode == '13')
                    return;
                $(fieldSelector).parents(".form-group").find(".error-message").remove();
                $(fieldSelector).parents(".form-group").removeClass("error");
             });
         });
     });
 }

window.clearValidation = function (selector)
 {
    const form_data = $(selector).serializeArray();
    $.each(form_data, function(id, field)
    {
        var fieldSelector = selector + " [name='"+field.name+"']";
        if($(fieldSelector).parents(".form-group").hasClass("error")) {
            $(fieldSelector).parents(".form-group").find(".error-message").remove();
            $(fieldSelector).parents(".form-group").removeClass("error");
        }
    });
 }

window.loading = function (c)
 {
    if(c == 'show' || c == 'hide')
    {
        $.LoadingOverlay(c);
    }
 }


window.colVisibility = function (table_id, defs = [])
{
    let html = '<div id="colVisibility" class="keep-open btn-group" title="Columns">' +
        '<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-label="Columns" title="Columns" aria-expanded="false"> ' +
        '<i class="fa fa-th-list"></i>' +
        '<span class="caret"></span>' +
        '</button>' +
        '<div class="dropdown-menu dropdown-menu-right" style="">';

    let checked = '';
    let name = '';
    $(table_id + " thead th").each(function (index){
        name = $(this).text();
        checked = 'checked="checked"';
        for (const [k, v] of Object.entries(defs)) {
            if(v.targets == index && v.visible == false){
                checked = '';
                break;
            }
        }
        html += '<label class="dropdown-item dropdown-item-marker"><input type="checkbox" value="'+ index +'" '+ checked +'> <span style="text-transform: capitalize">'+ name +'</span></label>';
    });

    html += '</div></div>';
    return html;
}

window.executeColVisibility = function (table)
{
    let colVisibilityDropdown = $("#colVisibility");
    if(colVisibilityDropdown.length > 0)
    {
        colVisibilityDropdown.find("input[type='checkbox']").change(function() {
            let index = $(this).val();
            table.column( index ).visible( this.checked );
        });
    }
}

window.hasAuthRolePermission = function (permission)
{
    return auth_role_permissions.includes(permission);
}


// File Upload Section JS

function fileBrowse(event, parent_element)
{
    const allowed_extensions = parent_element.find("input[type='file']").attr('allowed');
    const allowed_extensions_array = allowed_extensions != '*' ? parent_element.find("input[type='file']").attr('allowed').split(',') : [];
    const image_extensions = ['jpg', 'jpeg', 'gif', 'png'];
    let reader = new FileReader();
    reader.onload = function()
    {
        const result = reader.result;
        const file = event.target.files[0];
        const type = file.type;
        const ext = type.split('/')[1];
        if(allowed_extensions == '*' || allowed_extensions_array.indexOf(ext) >= 0){
            parent_element.find("input.file-upload-info").val(file.name);
            if(image_extensions.indexOf(ext) >= 0){
                parent_element.find(".display-input-image").removeClass('d-none')
                parent_element.find("img").attr('src', result);
            }
            else{
                parent_element.find(".display-input-image").addClass('d-none')
            }
        }
        else{
            parent_element.find("input.file-upload-info").val('')
            parent_element.find(".display-input-image").addClass('d-none')
            parent_element.find("input[type='file']").val('');
            alert('Unsupported. Try with valid files.');
        }
    }
    reader.readAsDataURL(event.target.files[0]);
}

//Auto Tab Selection
function autoTabSelection()
{
    const hash = location.hash;
    const default_tab_id =  $("#tabMenu a.nav-link.default").attr('href');
    let match_tab_id = '';
    $("#tabMenu a.nav-link").each(function (i, v){
        let href = $(v).attr('href');
        if(href == hash) { match_tab_id = hash; }
        $(v).removeClass('active');
        $(href).removeClass('show active');
    });

    if(match_tab_id == '') { match_tab_id = default_tab_id; }
    $("#tabMenu a.nav-link[href='"+match_tab_id+"']").addClass('active');
    $(match_tab_id).addClass('show active');

    $("#tabMenu a.nav-link").click(function (){
        let href_hash = $(this).attr('href');
        const hash = location.hash;
        let location_arr = location.href.split('#');
        window.history.pushState({}, '', location_arr[0] + href_hash);
    })
}

$(document).ready(function (){

    autoTabSelection();

    const fus_class = '.file-upload-section';
    $(fus_class).on("click", ".file-upload-browse", function () {
        $(this).parents(fus_class).eq(0).find("input[type='file']").click();
    });

    $(fus_class).on("change", "input[type='file']", function (event) {
        const parent_element = $(this).parents(fus_class).eq(0);
        fileBrowse(event, parent_element);
    });

    $(fus_class).on("click", ".file-upload-remove", function () {
        const parent_element = $(this).parents(fus_class).eq(0);
        parent_element.find("input.file-upload-info").val('');
        parent_element.find(".display-input-image").addClass('d-none')
        parent_element.find("input[type='file']").val('');
    })

// End File Upload Section JS

// Tab Menu Active
    const links = document.querySelectorAll(".tab-menu ");
    links.forEach(btn => btn.addEventListener("click",(e)=>{
        e.preventDefault();
        document.querySelector(".tab-menu.active").classList.remove("active");
        btn.classList.add("active")
    }));

});


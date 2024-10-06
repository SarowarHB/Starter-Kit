$(document).ready(function () {
    $('#summernote').summernote({
        height: 400
    });
    
    $("#blog_type, #tags").select2({
        placeholder: "Select Values",
        allowClear: true
    });
});
    


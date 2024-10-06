$('#summernote').summernote({
    height: 400
});

window.copyShortCode = function (code) {
    let copySuccess = document.getElementById("copied-success");
    navigator.clipboard.writeText('{' + code + '}');
    copySuccess.style.opacity = "1";
    setTimeout(function(){ copySuccess.style.opacity = "0" }, 500);
};

$(document).ready(function () {
    $("#salary, #bonus").on('keyup click change', function(){
       
       var salary = isNaN( parseFloat( $("#salary").val() ) ) ? 0.0 : parseFloat($("#salary").val());
       var bonus = isNaN( parseInt($("#bonus").val()) ) ? 0.0 : parseFloat($("#bonus").val());
       var total = salary + bonus;

       $("#total_salary").val(total);
    });
});
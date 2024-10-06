
import "daterangepicker";

$(document).ready(function () {

    $('#summernote').summernote({
        height: 400
    });


    $('#start').daterangepicker({
        opens: 'left',
        showDropdowns: true,
        timePicker: true,
        timePicker24Hour: true,
        singleDatePicker: true,
        startDate: moment().startOf('hour'),
        locale: {
            format: 'Y-M-DD hh:mm'
        }
    });

    $('#end').daterangepicker({
        minDate: moment($('input[name="start"]').val(), "Y-M-DD hh:mm"),
        opens: 'left',
        showDropdowns: true,
        timePicker: true,
        timePicker24Hour: true,
        singleDatePicker: true,
        startDate: moment().startOf('hour'),
        locale: {
            format: 'Y-M-DD hh:mm'
        }
    });

    $('#start').on('apply.daterangepicker', function (ev, picker) {
        $('input[name="start"]').val(picker.startDate.format('YYYY-MM-DD HH:mm'));
    });

    $('#end').on('apply.daterangepicker', function (ev, picker) {
        $('input[name="end"]').val(picker.startDate.format('YYYY-MM-DD HH:mm'));
    });
});
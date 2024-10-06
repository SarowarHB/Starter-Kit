var stockArray = [];

$( document ).ready(function() {

    $("#stock_id").select2({
        placeholder: "Select Values",
    });

});

$.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    $('#stock_id').on('change',function(e) {
        var stock_id = e.target.value;

        $.ajax({
            url: BASE_URL + "/ams/stock/transfer/get-stock",
            type:"POST",
            data: {
                stock_id: stock_id
            },
            success:function (data) {
                console.log(data.stock);
                $('#previous_location').empty();
                $('#previous_location').val(data.stock.location);

                $('#previous_quantity').empty();
                $('#previous_quantity').val(data.stock.quantity);
               

                if(data.entry_type == 1){
                    $("#current_quantity").prop("readonly", true);

                    $('#current_quantity').empty();
                    $('#current_quantity').val(data.stock.quantity);
                }else{
                    $("#current_quantity").prop("readonly", false);
                    $('#current_quantity').empty();
                    $('#current_quantity').val(0);
                }
            }
        })
    });
});

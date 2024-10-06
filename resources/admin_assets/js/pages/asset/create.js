$(document).ready(function () {
    $('select[name="asset_type"]').select2();

    $(document).on('keyup change','#quantity, #price',function(){
        var quantity = parseFloat($('#quantity').val());
        var price = parseFloat($('#price').val());
        var total = parseFloat(quantity * price).toFixed(2);

        $('#total').val(total);
    });

});
    


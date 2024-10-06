$.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {

    var categoryType = $("#categoryType").val();
    // console.log(categoryType);
    if(categoryType == 0){
        $("#macDiv").hide(0);
        $("#testingDiv").hide(0);
        $("#warrentyDiv").hide(0);
    }else{
        $("#macDiv").show(0);
        $("#testingDiv").show(0);
        $("#warrentyDiv").show(0);
    }

    $('#product').on('change',function(e) {
        var product_id = e.target.value;

        $.ajax({
            url: BASE_URL + "/ams/stocks/supplier",
            // url:"{{ route('admin.ams.stock.supplier') }}",
            type:"POST",
            data: {
                product_id: product_id
            },
            success:function (data) {

                $('#supplier').empty();
                $('#supplier').append('<option value="" class="selected highlighted">Select One</option>')
                $.each(data.suppliers, function(index,supplier){
                    $('#supplier').append('<option value="'+supplier.id+'">'+supplier.name+'</option>');
                })

                if(data.entry_type == 0){
                    $("#macDiv").hide(1500);
                    $("#testingDiv").hide(1500);
                    $("#warrentyDiv").hide(1500);
                }else{
                    $("#macDiv").show(1500);
                    $("#testingDiv").show(1500);
                    $("#warrentyDiv").show(1500);
                }
            }
        })
    });
});

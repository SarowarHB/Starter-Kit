$.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
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
                console.log(data.suppliers);
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

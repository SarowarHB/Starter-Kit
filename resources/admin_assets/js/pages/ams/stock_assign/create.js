// var stockArray = [];

// $( document ).ready(function() {

//     $("#stock_user").select2({
//         placeholder: "Select Values",
//     });

//     $("#stock").select2({
//         placeholder: "Select User First",
//     });

//     $("#stock_user").change(function() {

//         loading('show');
//         axios.get(BASE_URL + '/users/' + $(this).val())
//         .then(response => {
//             $('#user_details').css("display", "block");

//             $('#user_id').text(response.data.id);
//             $('#uname').text(response.data.full_name);

//             if (response.data.user_type == 'member') {
//                 $('#uname').attr('href', '/members/' + response.data.id + '/show');
//             } else {
//                 $('#uname').attr('href', '/employees/' + response.data.id + '/show');
//             }

//             $('#uemail').text(response.data.email);
//             $('#ulocation').text(response.data.location);

//             let location = $('#ulocation').text();
//             getStockByLocation(location);

//         })
//         .catch(error => {
//             const response = error.response;
//             if (response)
//                 notify(response.data.message, 'error');
//         })
//         .finally(() => {
//             loading('hide');
//         });
//     });

//     function getStockByLocation(location) {
//         loading('show');
//         axios.get(BASE_URL + '/ams/stocks/by/' + location)
//         .then(response => {
//             $('#stock').empty();

//             $('#stock').append('<option value="">Select One</option>');

//             $.each(response.data, function(index, stock) {
//                 $('#stock').append('<option value="'+stock.id+'">'+stock.product.name+' ('+stock.unique_id+')</option>');
//             })
//         })
//         .catch(error => {
//             const response = error.response;
//             if (response)
//                 notify(response.data.message, 'error');
//         })
//         .finally(() => {
//             loading('hide');
//         });
//     }

//     $("#stock").change(function() {
//         loading('show');
//         axios.get(BASE_URL + '/ams/stocks/' + $(this).val())
//         .then(response => {
//             $('#stock_details').css("display", "block");
//             $('#stock_id').text(response.data.id);
//             $('#stock_name').text(response.data.product.name);
//             $('#stock_type').text(response.data?.product?.category?.category_type?.name);
//             $('#stock_category').text(response.data?.product?.category?.name);
//             $('#stock_name').attr('href', '/ams/stocks/'+response.data.id+'/show');
//             $('#current_stock_qty').val(response.data.quantity);
//             $('#unique_id').text(response.data.unique_id);
//             $('#stock_image').attr('src', '/' + response.data.product.image);

//             let entry_type = response.data?.product?.category?.category_type?.entry_type;

//             if (entry_type == 0) {
//                 $('#entry_type').text('bulk');
//             }

//            // $("#add").removeAttr("disabled");
//         })
//         .catch(error => {
//             const response = error.response;
//             if (response)
//                 notify(response.data.message, 'error');
//         })
//         .finally(() => {
//             loading('hide');
//         });
//     });

//     $(document).on('click', '.assign_stock', function () {
//         if ($("#stock").val() == null || $("#stock").val() == '') {
//            alert('Please select stock first!')
//            return;
//         }

//         let entry_type = $('#entry_type').text();
//         let stock_id = $('#stock_id').text();
//         if (entry_type == 'bulk') {
//             $('#entry_type').text('');
//             $("#assignModal").modal('show')
//         } else {
//             let stockObj = {
//                 stock_id: $('#stock_id').text(),
//                 qty: $('#p_quantity').val() == '' ? 1 : $('#p_quantity').val()
//             }

//             stockArray.unshift(stockObj);

//             let unique_id = $('#unique_id').text();
//             let user_id = $('#user_id').text();
//             let uname = $('#uname').text();
//             let name = $('#stock_name').text();
//             let qty = $('#p_quantity').val() == '' ? 1 : $('#p_quantity').val();

//             let html = '<tr class="stock_tr">'+
//             '<td>'+ uname +'</td>'+
//             '<td>'+ unique_id +'</td>'+
//             '<td>' + name + '</td>'+
//             '<td>' + qty + '</td>'+
//             '<td style="display:none;"><input type="hidden" name=user_ids[] id="submit_user_ids" value=' + user_id + '></td>'+
//             '<td style="display:none;"><input type="hidden" name=stock_ids[] id="submit_stock_ids" value=' + stock_id + '></td>'+
//             '<td style="display:none;"><input type="hidden" name=quantity[] id="submit_qty" value=' + qty + '></td>'+
//             '<td><button type="button" class="btn btn-danger removeRow"><i class="far fa-trash-alt"></i></button></td>'+
//             '</tr>'

//             $('#stock_table tbody').append(html);
//             $("#p_quantity").val('');
//             $("#assignModal").modal('hide')
//             $("#stock_user").val([]);
//             $("#stock").val([]);
//             $('#user_details').css("display", "none");
//             $('#stock_details').css("display", "none");

//             var items = $('#stock_table').find(".btn-danger").length;

//             if (items > 0) {
//                 $('#assign_data').css("display", "block");
//             }
//         }
//     });

//     $(document).on('click', '.removeRow', function () {
//         $(this).closest('.stock_tr').remove();

//         var items = $('#stock_table').find(".btn-danger").length;

//         if (items <= 0) {
//             $('#assign_data').css("display", "none");
//         }
//     });
// });

// function stockValidation(qty) {
//     let stock_id = $('#stock_id').text();
//     var currentstock = $("#current_stock_qty").val();
//     let sum = 0;

//     stockArray.forEach(element => {
//         if (element.stock_id == stock_id) {
//             sum += Number(element.qty)
//         }
//     });

//     sum += Number(qty);

//     if (Number(sum) > currentstock) {
//         $("#p_quantity").val('');
//         $("#showDiv").show(500);
//         document.getElementById("mybutton").disabled = true;
//     }else{
//         $("#showDiv").hide(500);
//         document.getElementById("mybutton").disabled = false;
//     }
// }



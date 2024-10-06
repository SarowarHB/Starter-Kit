@extends('admin.layouts.master')

@section('title', __('New Stock Assign'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.ams.stock_assign.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Stock Assign')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-4">
                            <div class="form-group">
                            <label for="stock_user">Select User</label>
                            <select class="form-control" name="brand" id="stock_user">
                                <option value="" class="selected highlighted">Select One</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{(old("brand") == $user->id) ? "selected" : ""}}>
                                        {{ ucwords($user->full_name) }}</option>
                                @endforeach
                            </select>
                            </div>

                            <div class="table-responsive" id="user_details" style="display: none;">
                                <table id="example2" class="table table-bordered table-hover dataTable">
                                    <tbody><tr>
                                        <td width="30%" align="right"><b>Name</b></td>
                                        <td colspan="3"><a target="_blank" href="" id="uname"></a></td>
                                    </tr>
                                    <tr>
                                        <td width="30%" align="right"><b>Email</b></td>
                                        <td width="60%"><span id="uemail"></span></td>
                                    </tr>
                                    <tr>
                                        <td width="30%" align="right"><b>Location</b></td>
                                        <td width="60%"><span id="ulocation"></span></td>
                                    </tr>

                                </tbody></table>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                            <label for="stock">Select Stock</label>
                            <select class="form-control" name="brand" id="stock">
                                <option value="" class="selected highlighted">Select User First</option>
                                {{-- @foreach($stocks as $stock)
                                    <option value="{{ $stock->id }}" {{(old("brand") == $stock->id) ? "selected" : ""}}>
                                        {{ ucwords($stock->product->name) }}</option>
                                @endforeach --}}
                            </select>
                            </div>

                            <div class="table-responsive" id="stock_details" style="display: none;">
                                <table id="example2" class="table table-bordered table-hover dataTable">
                                    <tbody>
                                        <tr>
                                            <td width="30%" align="right"><b>Asset Name</b></td>
                                            <td><a target="_blank" href="" id="stock_name"></a></td>
                                            <td class="text-center" rowspan="5"><img style="width: 200px!important; height: 200px!important; border-radius: 0!important" src="" id="stock_image"></td>
                                        </tr>
                                        <tr>
                                            <td width="30%" align="right"><b>Asset ID</b></td>
                                            <td><span id="unique_id"></span></td>
                                        </tr>
                                        <tr>
                                            <td width="30%" align="right"><b>Asset Type</b></td>
                                            <td><span id="stock_type"></span></td>
                                        </tr>
                                        <tr>
                                            <td width="30%" align="right"><b>Category</b></td>
                                            <td><span id="stock_category"></span></td>
                                            <td style="display: none;"><span id="entry_type"></span></td>
                                            <td style="display: none;"><span id="user_id"></span></td>
                                            <td style="display: none;"><span id="stock_id"></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-2">
                            <button type="submit" style="margin-top: 30px;" class="assign_stock btn btn2-secondary" id="add">Add</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="assign_data" style="display: none">
                <form action="{{ route('admin.ams.stock_assign.store') }}" method="post">
                    @csrf
                <div class="row">
                    <table id="stock_table" class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th width="10%">User Name</th>
                                <th width="10%">Asset ID</th>
                                <th width="10%">Asset Name</th>
                                <th width="10%">Quantity</th>
                                <th width="5%" style="text-align: center;">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>

                    </table>
                </div>

                <div class="form-group mt-3">
                    <button id="assign" class="btn btn2-secondary float-right"
                            type="submit">
                        Assign
                    </button>
                </div>
            </form>
            </div>

        </div>
    </div>

    <div id="assignModal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class=" form">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Assign Quantity</h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="" class="control-label col-lg-3">Current Stock</label>
                            <div class="col-lg-9">
                                <input type="number" id="current_stock_qty" autocomplete="off" readonly="" class="form-control" name="quantity" required="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="control-label col-lg-3">Quantity</label>
                            <div class="col-lg-9">
                                <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" step="0" onkeyup="stockValidation(this.value)" class="form-control" id="p_quantity" name="quantity" required="" value="1">
                                <span id="showDiv" style="color: red; display: none">Desire stock not available</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button id="mybutton" class="assign_stock btn btn-primary waves-effect  waves-light">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@include('admin.assets.summernote-text-editor')
@include('admin.assets.select2')

@push('scripts')
{{-- @vite('resources/admin_assets/js/pages/ams/stock_assign/create.js') --}}
@endpush
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script>
var stockArray = [];

$( document ).ready(function() {

    $("#stock_user").select2({
        placeholder: "Select Values",
    });

    $("#stock").select2({
        placeholder: "Select User First",
    });

    $("#stock_user").change(function() {
        if ($(this).val() == '' || $(this).val() == null) {
            return;
        }
        loading('show');
        axios.get(BASE_URL + '/users/' + $(this).val())
        .then(response => {
            $('#user_details').css("display", "block");

            $('#user_id').text(response.data.id);
            $('#uname').text(response.data.full_name);

            if (response.data.user_type == 'member') {
                $('#uname').attr('href', '/members/' + response.data.id + '/show');
            } else {
                $('#uname').attr('href', '/employees/' + response.data.id + '/show');
            }

            $('#uemail').text(response.data.email);
            $('#ulocation').text(response.data.location);

            let location = $('#ulocation').text();
            getStockByLocation(location);

        })
        .catch(error => {
            const response = error.response;
            if (response)
                notify(response.data.message, 'error');
        })
        .finally(() => {
            loading('hide');
        });
    });

    function getStockByLocation(location) {
        loading('show');
        axios.get(BASE_URL + '/ams/stocks/by/' + location)
        .then(response => {
            $('#stock').empty();

            $('#stock').append('<option value="">Select One</option>');

            $.each(response.data, function(index, stock) {
                $('#stock').append('<option value="'+stock.id+'">'+stock.product.name+'</option>');
            })
        })
        .catch(error => {
            const response = error.response;
            if (response)
                notify(response.data.message, 'error');
        })
        .finally(() => {
            loading('hide');
        });
    }

    $("#stock").change(function() {
        if ($(this).val() == '' || $(this).val() == null) {
            return;
        }

        loading('show');
        axios.get(BASE_URL + '/ams/stocks/' + $(this).val())
        .then(response => {
            $('#stock_details').css("display", "block");
            $('#stock_id').text(response.data.id);
            $('#stock_name').text(response.data.product.name);
            $('#stock_type').text(response.data?.product?.category?.category_type?.name);
            $('#stock_category').text(response.data?.product?.category?.name);
            $('#stock_name').attr('href', '/');
            $('#current_stock_qty').val(response.data.quantity);
            $('#unique_id').text(response.data.unique_id);
            $('#stock_image').attr('src', '/' + response.data.product.image);

            let entry_type = response.data?.product?.category?.category_type?.entry_type;

            if (entry_type == 0) {
                $('#entry_type').text('bulk');
            }

           // $("#add").removeAttr("disabled");
        })
        .catch(error => {
            const response = error.response;
            if (response)
                notify(response.data.message, 'error');
        })
        .finally(() => {
            loading('hide');
        });
    });

    $(document).on('click', '.assign_stock', function () {
        if ($("#stock").val() == null || $("#stock").val() == '') {
           alert('Please select stock first!')
           return;
        }

        let entry_type = $('#entry_type').text();
        let stock_id = $('#stock_id').text();
        if (entry_type == 'bulk') {
            $('#entry_type').text('');
            $("#assignModal").modal('show')
        } else {
            let stockObj = {
                stock_id: $('#stock_id').text(),
                qty: $('#p_quantity').val() == '' ? 1 : $('#p_quantity').val()
            }

            stockArray.unshift(stockObj);

            let unique_id = $('#unique_id').text();
            let user_id = $('#user_id').text();
            let uname = $('#uname').text();
            let name = $('#stock_name').text();
            let qty = $('#p_quantity').val() == '' ? 1 : $('#p_quantity').val();

            let html = '<tr class="stock_tr">'+
            '<td>'+ uname +'</td>'+
            '<td>'+ unique_id +'</td>'+
            '<td>' + name + '</td>'+
            '<td>' + qty + '</td>'+
            '<td style="display:none;"><input type="hidden" name=user_ids[] id="submit_user_ids" value=' + user_id + '></td>'+
            '<td style="display:none;"><input type="hidden" name=stock_ids[] id="submit_stock_ids" value=' + stock_id + '></td>'+
            '<td style="display:none;"><input type="hidden" name=quantity[] id="submit_qty" value=' + qty + '></td>'+
            '<td><button type="button" class="btn btn-danger removeRow"><i class="far fa-trash-alt"></i></button></td>'+
            '</tr>'

            $('#stock_table tbody').append(html);
            $("#p_quantity").val('');
            $("#assignModal").modal('hide')

            $("#stock_user").val(null).trigger("change");
            $("#stock").val(null).trigger("change");


            $('#user_details').css("display", "none");
            $('#stock_details').css("display", "none");

            var items = $('#stock_table').find(".btn-danger").length;

            if (items > 0) {
                $('#assign_data').css("display", "block");
            }
        }
    });

    $(document).on('click', '.removeRow', function () {
        $(this).closest('.stock_tr').remove();

        var items = $('#stock_table').find(".btn-danger").length;

        if (items <= 0) {
            $('#assign_data').css("display", "none");
        }
    });
});

function stockValidation(qty) {
    let stock_id = $('#stock_id').text();
    var currentstock = $("#current_stock_qty").val();
    let sum = 0;

    stockArray.forEach(element => {
        if (element.stock_id == stock_id) {
            sum += Number(element.qty)
        }
    });

    sum += Number(qty);

    if (Number(sum) > currentstock) {
        $("#p_quantity").val('');
        $("#showDiv").show(500);
        document.getElementById("mybutton").disabled = true;
    }else{
        $("#showDiv").hide(500);
        document.getElementById("mybutton").disabled = false;
    }
}
</script>

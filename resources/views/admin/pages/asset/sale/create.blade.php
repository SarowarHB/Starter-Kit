@extends('admin.layouts.master')

@section('title', __('New Asset'))


<style>
    .swal2-popup {
        padding: 1em 0.25em !important;
    }
    .swal2-modal .swal2-icon{
        margin-bottom: 30px;
    }
    .swal2-title {
        padding: 0px;
    }
</style>


@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.asset.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Asset')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.asset.sale.create', $asset->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-sm-3">

                            <div class="form-group row @error('name') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Asset Name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name" readonly
                                        value="{{ old('name', $asset->name) }}" placeholder="{{ __('Asset Name') }}"
                                        required>
                                    @error('name')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('quantity') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Quantity') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" min="1" name="quantity" id="quantity"
                                        value="{{ old('quantity') }}" placeholder="{{ __('Quantity') }}"
                                        required>
                                    @error('quantity')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row @error('price') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Unit Price') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" min="0.01" step="0.01" name="price" id="price"
                                        value="{{ old('price') }}" placeholder="{{ __('Unit Price') }}"
                                        required>
                                    @error('price')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row @error('total') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Total') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="total" step="0.01" id="total"
                                        value="{{ old('total') }}" placeholder="{{ __('Total') }}" readonly>
                                    @error('total')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="p-sm-3 col-sm-12">

                                <div class="form-group row @error('sale_to') error @enderror">
                                    <label class="col-sm-3 col-form-label required">{{ __('Sale To') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="sale_to"
                                            value="{{ old('sale_to') }}" placeholder="{{ __('Sale To') }}"
                                            required>
                                        @error('sale_to')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row @error('sale_date') error @enderror">
                                    <label class="col-sm-3 col-form-label required" for="sale_date">{{ __('Sale Date') }}</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="sale_date" max="{{ now()->format('Y-m-d') }}" id="sale_date" class="form-control"
                                            value="{{old('sale_date')}}" required>
                                        @error('sale_date')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row @error('note') error @enderror">
                                    <label class="col-sm-3 col-form-label" for="note">{{ __('Notes') }}</label>
                                    <div class="col-sm-9">
                                        <textarea type="text" name="note" class="form-control"
                                            placeholder="{{ __('Write Notes') }}" rows="4">{{ old('note') }}</textarea>
                                        @error('note')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <input type="hidden" value="{{ $asset->id }}" name="asset_id" readonly>
                                <input type="hidden" value="{{ $asset->stock }}" id="stock" name="stock" readonly>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="modal-footer justify-content-center col-md-12">
                        {!! \App\Library\Html::btnReset() !!}
                        {!! \App\Library\Html::btnSubmit() !!}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
@include('admin.assets.dt')

@push('scripts')
<script>

    $(document).ready(function () {
        $(document).on('keyup change','#quantity',function(){
            var quantity = parseFloat($('#quantity').val());
            var stock = parseFloat($('#stock').val());

            if(quantity > stock){
                $('#quantity').val('');
                
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'You can not Give more than your current stock !!!',
                });
            }
        });
    });

    $(document).ready(function () {
        $(document).on('keyup change','#quantity, #price',function(){
            var quantity = parseFloat($('#quantity').val());
            var price = parseFloat($('#price').val());
            var total = parseFloat(quantity * price).toFixed(2);

            $('#total').val(total);
        });
    });
</script>
@endpush
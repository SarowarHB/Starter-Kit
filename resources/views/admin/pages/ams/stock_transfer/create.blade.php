@extends('admin.layouts.master')

@section('title', __('New Stock Transfer'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.ams.stock_transfer.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Stock Transfer')) }}</h4>
        </div>
        
    </div>

    <div class="card shadow-sm col-md-6">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.ams.stock_transfer.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="p-sm-3">

                            <div class="form-group row @error('stock_id') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Stock') }}</label>
                                <div class="col-sm-9">
                                <select class="form-control" name="stock_id" id="stock_id" required>
                                    <option value="" class="selected highlighted">Select</option>
                                    @foreach($stocks as $stock)
                                        <option value="{{ $stock->id }}" {{(old("stock_id") == $stock->id) ? "selected" : ""}}>
                                        {{ $stock->unique_id }} ~~ {{ ucwords($stock->product->name) }}</option>
                                    @endforeach
                                </select>
                                    @error('stock_id')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('previous_location') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Previous Location') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="previous_location" id="previous_location"
                                        value="{{ old('previous_location') }}" placeholder="{{ __('Previous Location') }}" required readonly>
                                    @error('previous_location')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('current_location') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Location') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="current_location" id="current_location" required>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($locations as $value)
                                            <option value="{{ $value }}" {{(old("current_location") == $value) ? "selected" : ""}}>
                                                {{ ucwords($value) }}</option>
                                        @endforeach
                                    </select>
                                    @error('current_location')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('previous_quantity') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Previous Quantity') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="previous_quantity" id="previous_quantity"
                                        value="{{ old('previous_quantity') }}" placeholder="{{ __('Previous Quantity') }}" required readonly>
                                    @error('previous_quantity')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('current_quantity') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Current Quantity') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="current_quantity" id="current_quantity" readonly
                                        value="{{ old('current_quantity') }}" placeholder="{{ __('Current Quantity') }}" required>
                                    @error('current_quantity')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('note') error @enderror">
                                    <label class="col-sm-3 col-form-label required">{{ __('Note') }}</label>
                                    <div class="col-sm-9">
                                        <textarea type="text" class="form-control" name="note"
                                            value="{{ old('note') }}" placeholder="{{ __('Note') }}" rows="8" required ></textarea>
                                        @error('note')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
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

@include('admin.assets.select2')

@push('scripts')
@vite('resources/admin_assets/js/pages/ams/stock_transfer/create.js')
@endpush
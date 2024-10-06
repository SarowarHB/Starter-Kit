@extends('admin.layouts.master')

@section('title', __('New Asset'))

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
            <form method="post" action="{{ route('admin.asset.create') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-sm-3">

                            <div class="form-group row @error('name') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name') }}" placeholder="{{ __('Name') }}"
                                        required>
                                    @error('name')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row @error('asset_type') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Asset Type') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="asset_type" required>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($asset_type as $value)
                                            <option value="{{ $value }}" {{(old("asset_type") == $value) ? "selected" : ""}}>
                                                {{ ucwords($value) }}</option>
                                        @endforeach
                                    </select>
                                    @error('asset_type')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('purchased_date') error @enderror">
                                <label class="col-sm-3 col-form-label required" for="name">{{ __('Purchase Date') }}</label>
                                <div class="col-sm-9">
                                    <input type="date" name="purchased_date" max="{{ now()->format('Y-m-d') }}" id="purchased_date" class="form-control"
                                        value="{{old('purchased_date')}}" required>
                                    @error('purchased_date')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('warranty_date') error @enderror">
                                <label class="col-sm-3 col-form-label" for="name">{{ __('Warranty Date') }}</label>
                                <div class="col-sm-9">
                                    <input type="date" name="warranty_date" min="{{ now()->format('Y-m-d') }}" id="warranty_date" class="form-control"
                                        value="{{old('warranty_date')}}">
                                    @error('warranty_date')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('vender_info') error @enderror">
                                <label class="col-sm-3 col-form-label required" for="name">{{ __('Vendor Info') }}</label>
                                <div class="col-sm-9">
                                    <textarea type="text" name="vender_info" class="form-control" required
                                        placeholder="{{ __('Write About Vendor') }}" rows="4">{{ old('vender_info') }}</textarea>
                                    @error('vender_info')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="p-sm-3 col-sm-12">

                                <div class="form-group row @error('quantity') error @enderror">
                                    <label class="col-sm-3 col-form-label required">{{ __('Quantity') }}</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" name="quantity" id="quantity"
                                            value="{{ old('quantity') }}" min=1 placeholder="{{ __('Quantity') }}"
                                            required>
                                        @error('quantity')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row @error('price') error @enderror">
                                    <label class="col-sm-3 col-form-label required">{{ __('Unit Price') }}</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" min=0 step="0.01" name="price" id="price"
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

                                <div class="form-group row @error('description') error @enderror">
                                    <label class="col-sm-3 col-form-label required" for="name">{{ __('Description') }}</label>
                                    <div class="col-sm-9">
                                        <textarea type="text" name="description" class="form-control" required
                                            placeholder="{{ __('Write About Asset') }}" rows="4">{{ old('description') }}</textarea>
                                        @error('description')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row @error('attachments') error @enderror">
                                    <label class="col-sm-3 col-form-label">Attachments</label>
                                    <div class="col-sm-9">
                                        <div class="file-upload-section">
                                            <input name="attachments" type="file" class="form-control d-none" allowed="png,gif,jpeg,jpg">
                                            <div class="input-group col-xs-12">
                                                <input type="text" class="form-control file-upload-info" disabled="" readonly placeholder="Size: 200x200 and max 500kB">
                                                <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-outline-secondary" type="button"><i class="fas fa-upload"></i> Browse</button>
                                                </span>
                                            </div>
                                            @error('attachments')
                                                <p class="error-message">{{ $message }}</p>
                                            @enderror
                                            <div class="display-input-image d-none">
                                                <img src="{{ asset(\App\Library\Enum::NO_IMAGE_PATH) }}" alt="Preview Image"/>
                                                <button type="button" class="btn btn-sm btn-outline-danger file-upload-remove" title="Remove">x</button>
                                            </div>
                                        </div>
                                    </div>
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
@vite('resources/admin_assets/js/pages/asset/create.js')
@endpush
@extends('admin.layouts.master')

@section('title', __('Update Supplier'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.ams.supplier.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Supplier')) }}</h4>
        </div>

    </div>

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.ams.supplier.update', $supplier->id) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-sm-3">

                            <div class="form-group row @error('name') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $supplier->name) }}"
                                        placeholder="{{ __('Name') }}" required>
                                    @error('name')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('supplier_type') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Supplier Type') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="supplier_type" required>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($types as $key => $type)
                                        <option value="{{ $type->id }}"
                                            {{(old("supplier_type", $supplier->supplier_type) == $type->id) ? "selected" : ""}}>
                                            {{ ucwords($type->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_type')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('email') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Email') }}</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="email" value="{{ old('email', $supplier->email) }}"
                                        placeholder="{{ __('example@example.com') }}">
                                    @error('email')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('phone') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Mobile No') }}</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <select name="country_code" class="input-group-text text-secondary"
                                                required>
                                                @foreach($countries as $key => $country)
                                                <option value="{{ old('country_code', $country['code']) }}"
                                                    {{ $country['code'] == (explode('-', $supplier->phone))[0] ? "selected" : "" }}>{{ $key }} {{ $country['code'] }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="number" name="phone" value="{{ old('phone', ((strpos($supplier->phone, '-') == true) ? (explode('-', $supplier->phone))[1] : $supplier->phone) ) }}" class="form-control"
                                            placeholder="{{ __('013 355 666') }}">
                                    </div>
                                    @error('phone')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('contact_person') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Contact Person') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="contact_person"
                                        value="{{ old('contact_person', $supplier->contact_person) }}"
                                        placeholder="{{ __('example@example.com') }}">
                                    @error('contact_person')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-sm-3">
                            <div class="form-group row @error('address') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Address') }}</label>
                                <div class="col-sm-9">
                                    <textarea type="text" class="form-control" name="address"
                                        placeholder="{{ __('Address') }}"
                                        rows="8"> {{ old('address', $supplier->address) }} </textarea>
                                    @error('address')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('company') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Company') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="company" value="{{ old('company', $supplier->company) }}"
                                        placeholder="{{ __('example@example.com') }}">
                                    @error('company')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('logo') error @enderror">
                                <label class="col-sm-3 col-form-label">Logo</label>
                                <div class="col-sm-9">
                                    <div class="file-upload-section">
                                        <input name="logo" type="file" value="{{old('logo')}}"
                                            class="form-control d-none" allowed="png,gif,jpeg,jpg">
                                        <div class="input-group col-xs-12">
                                            <input type="text" class="form-control file-upload-info"
                                                value="{{old('logo')}}" disabled="" readonly
                                                placeholder="Size: 200x200 and max 500kB">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-outline-secondary"
                                                    type="button"><i class="fas fa-upload"></i> Browse</button>
                                            </span>
                                        </div>
                                        @error('logo')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                        <div class="display-input-image @if( $supplier->logo) '' @else d-none @endif">
                                            <img src="{{ $supplier->getProfileImage() }}"
                                                alt="Preview Image" />
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger file-upload-remove"
                                                title="Remove">x</button>
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

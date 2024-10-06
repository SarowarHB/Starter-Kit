<!-- Modal -->
@extends('admin.layouts.master')

@section('title', __('Update Emergency Contact'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack( $route ) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Emergency Contact')) }}</h4>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.emergency.update', $emergency_contact->id) }}"
                enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <h3 class="col-md-12 text-center text-primary"> {{$emergency_contact->user->getFullNameAttribute()}} </h3>

                    <div class="col-md-6">
                        <div class="p-sm-3">

                            <div class="form-group row @error('name') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $emergency_contact->name) }}"
                                        placeholder="{{ __('Name') }}" required>
                                    @error('name')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('email') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Email') }}</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="email" value="{{ old('email', $emergency_contact->email) }}"
                                        placeholder="{{ __('Email Address') }}">
                                    @error('email')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('mobile') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Mobile') }}</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <select name="country_code" class="input-group-text text-secondary"
                                                required>
                                                @foreach($countries as $key => $country)
                                                <option value="{{ old('country_code', $country['code']) }}"
                                                    {{ $country['code'] == (explode('-', $emergency_contact->mobile_number))[0] ? "selected" : ""}}>{{$key}}
                                                    {{ $country['code']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="number" name="mobile_number" value="{{  old('mobile_number',  ((strpos($emergency_contact->mobile_number, '-') == true) ? (explode('-', $emergency_contact->mobile_number))[1] : $emergency_contact->mobile_number) )}}"
                                            class="form-control" placeholder="{{ __('013 355 666') }}" required>
                                    </div>
                                    @error('mobile_number')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('relationship') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Relationship') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="relationship"
                                        value="{{ old('relationship', $emergency_contact->relationship) }}"
                                        placeholder="{{ __('Ex: Brother, Sister, Father') }}" required>
                                    @error('relationship')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-sm-3">

                            <div class="form-group row @error('address') error @enderror">
                                <label class="col-sm-3 col-form-label" for="name">{{ __('Address') }}</label>
                                <div class="col-sm-9">
                                    <textarea type="text" name="address" class="form-control"
                                        placeholder="{{ __('Write Your Address') }}"
                                        rows="4">{{ old('address', $emergency_contact->address) }}</textarea>
                                    @error('address')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('note') error @enderror">
                                <label class="col-sm-3 col-form-label" for="name">{{ __('Note') }}</label>
                                <div class="col-sm-9">
                                    <textarea type="text" name="note" class="form-control"
                                        placeholder="{{ __('Write About You') }}" rows="4">{{ old('note', $emergency_contact->note) }}</textarea>
                                    @error('note')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('image') error @enderror">
                                <label class="col-sm-3 col-form-label">Picture</label>
                                <div class="col-sm-9">
                                    <div class="file-upload-section">
                                        <input name="image" type="file" class="form-control d-none"
                                            allowed="png,gif,jpeg,jpg">
                                        <div class="input-group col-xs-12">
                                            <input type="text" class="form-control file-upload-info" disabled=""
                                                readonly placeholder="Size: 200x200 and max 500kB">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-outline-secondary"
                                                    type="button"><i class="fas fa-upload"></i> Browse</button>
                                            </span>
                                        </div>
                                        @error('image')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                        <div class="display-input-image d-none">
                                            <img src="{{ Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}"
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

                <div class="modal-footer justify-content-center">
                    {!! \App\Library\Html::btnSubmit() !!}
                </div>

            </form>
        </div>
    </div>
</div>
@stop
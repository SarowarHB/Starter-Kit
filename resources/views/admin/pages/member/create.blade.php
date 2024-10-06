@extends('admin.layouts.master')

@section('title', __('New Member'))

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.member.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Member')) }}</h4>
        </div>
       
    </div>

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.member.create') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="p-sm-3">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label required">{{ __('Member Name') }}</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group @error('user.f_name') error @enderror">
                                                <input type="text" class="form-control" value="{{ old('user.f_name') }}" name="user[f_name]" placeholder="{{ __('First Name') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group @error('user.m_name') error @enderror">
                                                <input type="text" class="form-control" name="user[m_name]" value="{{ old('user.m_name') }}" placeholder="{{ __('Middle Name (optioanl)') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group @error('user.l_name') error @enderror">
                                                <input type="text" class="form-control" name="user[l_name]" value="{{ old('user.l_name') }}" placeholder="{{ __('Last Name') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group @error('user.nick_name') error @enderror">
                                                <input type="text" class="form-control" name="user[nick_name]" value="{{ old('user.nick_name') }}" placeholder="{{ __('Nick Name') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    @error('user.f_name')
                                        <p class="error-message text-danger">{{ $message }}</p>
                                    @enderror
                                    @error('user.m_name')
                                        <p class="error-message text-danger">{{ $message }}</p>
                                    @enderror
                                    @error('user.l_name')
                                        <p class="error-message text-danger">{{ $message }}</p>
                                    @enderror
                                    @error('user.nick_name')
                                        <p class="error-message text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('user.email') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Email Address') }}</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="user[email]" value="{{ old('user.email') }}" placeholder="{{ __('Email Address') }}" required>
                                    @error('user.email')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label required">{{ __('Password') }}</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group @error('user.password') error @enderror">
                                                <input type="password" class="form-control"  name="user[password]" placeholder="{{ __('Password') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group @error('user.password_confirmation') error @enderror">
                                                <input type="password" class="form-control" name="user[password_confirmation]" placeholder="{{ __('Confirm Password') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    @error('user.password')
                                        <p class="error-message text-danger">{{ $message }}</p>
                                    @enderror
                                    @error('user.password_confirmation')
                                        <p class="error-message text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('mobile') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Mobile No') }}</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                        <select name="country_code" class="input-group-text text-primary" required>
                                            @foreach($countries as $key => $country)
                                                <option value="{{ $country['code'] }}" {{ ($key == "NZ") ? "selected" : "" }}>{{ $key }} {{ $country['code'] }}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                        <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control" placeholder="{{ __('013 355 666') }}" required>
                                    </div>
                                    @error('mobile')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('dob') error @enderror">
                                <label class="col-sm-3 col-form-label required" for="name">{{ __('dob') }}</label>
                                <div class="col-sm-9">
                                    <input type="date" name="dob" id="dob"
                                        class="form-control "
                                        value="{{ old('dob') }}" aria-describedby="dob" max="{{ now()->format('Y-m-d') }}" placeholder="{{ __('Date of Birth') }}" required>
                                    @error('dob')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="p-sm-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label required">{{ __('Physical Address') }}</label>
                                    <div class="col-sm-9">
                                        @include('admin.components.address_form')
                                    </div>
                                </div>

                                <div class="form-group row @error('about_me') error @enderror">
                                    <label class="col-sm-3 col-form-label" for="name">{{ __('about_me') }}</label>
                                    <div class="col-sm-9">
                                        <textarea type="text" name="about_me" id="about_me"
                                            class="form-control "
                                            aria-describedby="about_me"
                                            placeholder="{{ __('Write About You') }}">{{old('about_me')}}</textarea>
                                        @error('about_me')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="p-sm-3">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label required">{{ __('nid_image') }} </label>
                                <div class="col-sm-9">
                                    <div class="file-upload-section">
                                        <input name="photo_id" type="file" class="form-control hidden_file"
                                            allowed="png,gif,jpeg,jpg" required>
                                        <div class="input-group col-xs-12">
                                            <input type="text"
                                                class="form-control file-upload-info @error('photo_id') error @enderror"
                                                disabled="" readonly placeholder="Size: 200x200 and max 200kB">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-outline-secondary"
                                                    type="button"><i class="fas fa-upload"></i> Browse</button>
                                            </span>

                                        </div>
                                        <div class="display-input-image d-none">
                                            <img src="{{ asset(\App\Library\Enum::NO_IMAGE_PATH) }}"
                                                alt="Preview Image" />
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger file-upload-remove"
                                                title="Remove">x</button>
                                        </div>
                                        @error('photo_id')
                                            <p class="error-message text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="p-sm-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">{{ __('profile_image') }}</label>
                                    <div class="col-sm-9">
                                        <div class="file-upload-section">
                                            <input name="profile_image" type="file" class="form-control d-none"
                                                allowed="png,gif,jpeg,jpg">
                                            <div class="input-group col-xs-12">
                                                <input type="text"
                                                    class="form-control file-upload-info @error('profile_image') error @enderror"
                                                    disabled="" readonly placeholder="Size: 200x200 and max 200kB">
                                                <span class="input-group-append">
                                                    <button class="file-upload-browse btn btn-outline-secondary"
                                                        type="button"><i class="fas fa-upload"></i> Browse</button>
                                                </span>
                                                @error('profile_image')
                                                <p class="error-message">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="display-input-image d-none">
                                                <img src="{{ asset(\App\Library\Enum::NO_IMAGE_PATH) }}"
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

@push('scripts')
@endpush

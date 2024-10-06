@extends('admin.layouts.master')

@section('title', __('New Employee'))

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.employee.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Employee')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.employee.create') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-sm-3">

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label required">{{ __('Employee Name') }}</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group @error('user.f_name') error @enderror">
                                                <input type="text" class="form-control" value="{{ old('user.f_name') }}"
                                                    name="user[f_name]" placeholder="{{ __('First Name') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group @error('user.m_name') error @enderror">
                                                <input type="text" class="form-control" name="user[m_name]"
                                                    value="{{ old('user.m_name') }}"
                                                    placeholder="{{ __('Middle Name (optioanl)') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group @error('user.l_name') error @enderror">
                                                <input type="text" class="form-control" name="user[l_name]"
                                                    value="{{ old('user.l_name') }}"
                                                    placeholder="{{ __('Last Name') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group @error('user.nick_name') error @enderror">
                                                <input type="text" class="form-control" name="user[nick_name]"
                                                    value="{{ old('user.nick_name') }}"
                                                    placeholder="{{ __('Nick Name') }}" required>
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
                                    <input type="email" class="form-control" name="user[email]"
                                        value="{{ old('user.email') }}" placeholder="{{ __('Email Address') }}"
                                        required>
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
                                                <input type="password" class="form-control" name="user[password]"
                                                    placeholder="{{ __('Password') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div
                                                class="form-group @error('user.password_confirmation') error @enderror">
                                                <input type="password" class="form-control"
                                                    name="user[password_confirmation]"
                                                    placeholder="{{ __('Confirm Password') }}" required>
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
                                        <select name="country_code" class="input-group-text text-secondary" required>
                                            @foreach($countries as $key => $country)
                                                <option value="{{ old('country_code', $country['code']) }}" {{($key == "BD") ? "selected" : ""}}>{{$key}} {{ $country['code']}}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                        <input type="number" name="mobile" value="{{old('mobile')}}" class="form-control" placeholder="{{ __('013 355 666') }}" required>
                                    </div>
                                    @error('mobile')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('dob') error @enderror">
                                <label class="col-sm-3 col-form-label required" for="name">{{ __('Date Of Birth') }}</label>
                                <div class="col-sm-9">
                                    <input type="date" name="dob" id="dob" max="{{ now()->format('Y-m-d') }}" class="form-control"
                                        value="{{old('dob')}}" required>
                                    @error('dob')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('designation') error @enderror">
                                <label class="col-sm-3 col-form-label required required"
                                    for="name">{{ __('Designation') }}</label>
                                <div class="col-sm-9">
                                    <select class="select form-control" name="designation" id="designation"
                                        style="width: 100%;" required>
                                        <option value="" selected disabled>Select One</option>
                                        @foreach($designations as $designation)
                                            <option value="{{ $designation }}" {{ old('designation')  == $designation ? "selected" : "" }}>{{ $designation }}</option>
                                        @endforeach
                                    </select>
                                    @error('designation')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label
                                    class="col-sm-3 col-form-label required required">{{ __('Job Status') }}</label>
                                <div class="col-sm-9">
                                    <div class="d-inline-flex justify-content-start">
                                        <div class="form-check form-check-secondary mr-5">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="emp_type"
                                                    value="full_time" required
                                                    {{ !old('emp_type') ? 'checked' : '' }}>
                                                Full Time
                                                <i class="input-helper"></i></label>
                                        </div>
                                        <div class="form-check form-check-secondary">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="emp_type"
                                                    value="part_time" required
                                                    {{ old('emp_type') ? 'checked' : '' }}>
                                                Part Time
                                                <i class="input-helper"></i></label>
                                        </div>
                                        @error('emp_type')
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
                                    <label class="col-sm-3 col-form-label required">{{ __('Physical Address') }}</label>
                                    <div class="col-sm-9">
                                        @include('admin.components.address_form')
                                    </div>
                                </div>

                                {{-- <div class="form-group row @error('role_id') error @enderror">
                                    <label class="col-sm-3 col-form-label required required"
                                        for="name">{{ __('Role') }}</label>
                                    <div class="col-sm-9">
                                        <select class="select form-control" name="role_id" id="role_id"
                                            style="width: 100%;" required>
                                            <option disabled selected value="">Select One</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div> --}}

                                <div class="form-group row @error('role_id') error @enderror">
                                    <label class="col-sm-3 col-form-label required">{{ __('Role') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" name="role_id[]" id="role_id" multiple required>
                                            @foreach($roles as $value)
                                                <option value="{{ $value->id }}" {{ (collect(old('role_id'))->contains($value->id)) ? 'selected':'' }} >
                                                    {{ ucwords($value->name) }}</option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row @error('about_me') error @enderror">
                                    <label class="col-sm-3 col-form-label" for="name">{{ __('About Me') }}</label>
                                    <div class="col-sm-9">
                                        <textarea type="text" name="about_me" class="form-control"
                                            placeholder="{{ __('Write About You') }}" rows="4">{{ old('about_me') }}</textarea>
                                        @error('about_me')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row @error('profile_image') error @enderror">
                                    <label class="col-sm-3 col-form-label">Profile Picture</label>
                                    <div class="col-sm-9">
                                        <div class="file-upload-section">
                                            <input name="profile_image" type="file" value="{{old('profile_image')}}" class="form-control d-none" allowed="png,gif,jpeg,jpg">
                                            <div class="input-group col-xs-12">
                                                <input type="text" class="form-control file-upload-info" value="{{old('profile_image')}}" disabled="" readonly placeholder="Size: 200x200 and max 500kB">
                                                <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-outline-secondary" type="button"><i class="fas fa-upload"></i> Browse</button>
                                                </span>
                                            </div>
                                            @error('profile_image')
                                                <p class="error-message">{{ $message }}</p>
                                            @enderror
                                            <div class="display-input-image d-none">
                                                <img src="{{ Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}" alt="Preview Image"/>
                                                <button type="button" class="btn btn-sm btn-outline-danger file-upload-remove" title="Remove">x</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
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
<script>
    $(document).ready(function () {

        $("#designation, #role_id").select2({
            placeholder: "Select One",
            allowClear: true
        });
    });

</script>
@endpush


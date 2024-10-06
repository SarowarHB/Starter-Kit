@extends('admin.layouts.master')

@section('title', __('Update profile'))

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.profile.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ __('Update Profile') }}</h4>
        </div>
        
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="post" action="{{ route('admin.profile.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-sm-3">

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label required">{{ __('Name') }}</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group @error('user.f_name') error @enderror">
                                                <input type="text" class="form-control"
                                                    value="{{ old('user.f_name', $user->f_name) }}" name="user[f_name]"
                                                    placeholder="{{ __('First Name') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group @error('user.m_name') error @enderror">
                                                <input type="text" class="form-control" name="user[m_name]"
                                                    value="{{ old('user.m_name', $user->m_name) }}"
                                                    placeholder="{{ __('Middle Name (optioanl)') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group @error('user.l_name') error @enderror">
                                                <input type="text" class="form-control" name="user[l_name]"
                                                    value="{{ old('user.l_name', $user->l_name) }}"
                                                    placeholder="{{ __('Last Name') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group @error('user.nick_name') error @enderror">
                                                <input type="text" class="form-control" name="user[nick_name]"
                                                    value="{{ old('user.nick_name', $user->nick_name) }}"
                                                    placeholder="{{ __('Nick Name') }}">
                                            </div>
                                        </div>
                                    </div>
                                    @error('user.f_name')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                    @error('user.m_name')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                    @error('user.l_name')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                    @error('user.nick_name')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('user.email') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Email Address') }}</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="user[email]"
                                        value="{{ old('user.email', $user->email) }}"
                                        placeholder="{{ __('Email Address') }}" required>
                                    @error('user.email')
                                    <p class="error-message">{{ $message }}</p>
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
                                                <option value="{{ $country['code'] }}"
                                                    {{ ($country['code'] == ($employee ? (explode('-', $employee->mobile))[0] : "+880")) ? "selected" : "" }}>{{$key}} {{ $country['code']}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if ($employee)
                                            <input type="tel" name="mobile"
                                            value="{{ old('mobile', ((strpos($employee->mobile, '-') == true) ? (explode('-', $employee->mobile))[1] : $employee->mobile) ) }}" class="form-control"
                                            placeholder="{{ __('013 355 666') }}" required >
                                        @else
                                            <input type="tel" name="mobile"
                                            value="{{ old('mobile') }}" class="form-control"
                                            placeholder="{{ __('013 355 666') }}" required >
                                        @endif
                                        
                                    </div>
                                    @error('mobile')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('about_me') error @enderror">
                                <label class="col-sm-3 col-form-label" for="name">{{ __('About Me') }}</label>
                                <div class="col-sm-9">
                                    <textarea type="text" name="about_me" id="about_me" class="form-control"
                                        placeholder="{{ __('Write About You') }}">{{old('about_me',($employee ? $employee->about_me : ''))}}</textarea>
                                    @error('about_me')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('profile_image') error @enderror">
                                <label class="col-sm-3 col-form-label">Profile Picture</label>
                                <div class="col-sm-9">
                                    <div class="file-upload-section">
                                        <input name="profile_image" type="file" class="form-control d-none"
                                            allowed="png,gif,jpeg,jpg">
                                        <div class="input-group col-xs-12">
                                            <input type="text" class="form-control file-upload-info" disabled=""
                                                readonly placeholder="Size: 200x200 and max 500kB">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-outline-secondary"
                                                    type="button"><i class="fas fa-upload"></i> Browse</button>
                                            </span>
                                        </div>
                                        @error('profile_image')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                        <div class="display-input-image {{ $employee ? '' : 'd-none' }}">
                                            <img src="{{ ($employee) ? $employee->getProfileImage() : '' }}" alt="Preview Image" />
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger file-upload-remove"
                                                title="Remove">x</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="p-sm-3 col-sm-12">

                                <div class="form-group row @error('dob') error @enderror">
                                    <label class="col-sm-3 col-form-label required" for="name">{{ __('Date Of Birth') }}</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="dob" id="dob" class="form-control" max="{{ now()->format('Y-m-d') }}"
                                            value="{{old('dob',($employee ? $employee->dob : ''))}}" required>
                                        @error('dob')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label required">{{ __('Physical Address') }}</label>
                                    <div class="col-sm-9">
                                        @include('admin.components.address_form', ['field_values' => $employee])
                                        {{-- <div class="row">
                                            <div class="col-sm-12">
                                                <div class="input-group mb-4">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text text-primary"><i
                                                                class="fas fa-map-marker-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                        placeholder="{{ __('Find your address') }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group @error('house_no') error @enderror">
                                                    <input type="text" class="form-control"
                                                        value="{{ old('house_no', ($employee ? $employee->house_no : '')) }}" name="house_no"
                                                        placeholder="{{ __('House No') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group @error('floor_apt') error @enderror">
                                                    <input type="text" class="form-control" name="floor_apt"
                                                        value="{{ old('floor_apt', ($employee ? $employee->floor_apt : '')) }}"
                                                        placeholder="{{ __('Floor/Apt No (optional)') }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group @error('street') error @enderror">
                                                    <input type="text" class="form-control" name="street"
                                                        value="{{ old('street', ($employee ? $employee->street : '')) }}"
                                                        placeholder="{{ __('Street Address') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group @error('town') error @enderror">
                                                    <input type="text" class="form-control" name="town"
                                                        value="{{ old('town', ($employee ? $employee->town : '')) }}"
                                                        placeholder="{{ __('Town') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group @error('city') error @enderror">
                                                    <input type="text" class="form-control" name="city"
                                                        value="{{ old('city', ($employee ? $employee->city : '')) }}"
                                                        placeholder="{{ __('City') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group @error('post_code') error @enderror">
                                                    <input type="text" class="form-control" name="post_code"
                                                        value="{{ old('post_code', ($employee ? $employee->post_code : '')) }}"
                                                        placeholder="{{ __('Postal Code') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group @error('country') error @enderror">
                                                    <select name="country" class="form-control js-example-basic-single" required>
                                                        <option selected disabled>Select One</option>
                                                        @foreach($countries as $key => $country)
                                                            <option value="{{$key}}" {{($employee && $employee->country == $key) ? 'selected' : ''}}>{{$country['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        @error('house_no')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                        @error('floor_apt')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                        @error('street')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                        @error('town')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                        @error('city')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                        @error('post_code')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                        @error('country')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror --}}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="modal-footer justify-content-center col-md-12">
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
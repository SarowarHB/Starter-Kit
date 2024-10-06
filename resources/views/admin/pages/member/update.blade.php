@extends('admin.layouts.master')

@section('title', __('update_member'))

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.member.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('update_member')) }}</h4>
        </div>
        
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="post" action="{{ route('admin.member.update', $member->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="p-sm-3">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label required">{{ __('Member Name') }}</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        @php $user = $member->user; @endphp
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
                                                    placeholder="{{ __('Last Name') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group @error('user.nick_name') error @enderror">
                                                <input type="text" class="form-control" name="user[nick_name]"
                                                    value="{{ old('user.nick_name', $user->nick_name) }}"
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
                                                    {{ $country['code'] == (explode('-', $member->mobile))[0] ? "selected" : "" }}>{{ $key }} {{ $country['code'] }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="tel" name="mobile"
                                            value="{{ old('mobile', ((strpos($member->mobile, '-') == true) ? (explode('-', $member->mobile))[1] : $member->mobile) ) }}" class="form-control"
                                            placeholder="{{ __('013 355 666') }}" required >
                                    </div>
                                    @error('mobile')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('dob') error @enderror">
                                <label class="col-sm-3 col-form-label required" for="name">{{ __('dob') }}</label>
                                <div class="col-sm-9">
                                    <input type="date" name="dob" id="dob" class="form-control"
                                        value="{{ old('dob', $member->dob) }}" aria-describedby="dob" placeholder="Enter Date"
                                        required>
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
                                        @include('admin.components.address_form', ['field_values' => $member])
                                    </div>
                                </div>

                                <div class="form-group row @error('about_me') error @enderror">
                                    <label class="col-sm-3 col-form-label" for="name">{{ __('about_me') }}</label>
                                    <div class="col-sm-9">
                                        <textarea type="text" name="about_me" id="about_me" class="form-control"
                                            aria-describedby="about_me"
                                            placeholder="Write About You">{{ old('about_me', $member->about_me) }}</textarea>
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
                            <div class="form-group row @error('photo_id') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('nid_image') }} </label>
                                <div class="col-sm-9">
                                    <div class="file-upload-section">
                                        <input name="photo_id" type="file" class="form-control d-none"
                                            allowed="png,gif,jpeg,jpg">
                                        <div class="input-group col-xs-12">
                                            <input type="text"
                                                class="form-control file-upload-info"
                                                disabled="" readonly placeholder="Size: 200x200 and max 200kB">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-outline-secondary"
                                                    type="button"><i class="fas fa-upload"></i> Browse</button>
                                            </span>
                                        </div>
                                        <div class="display-input-image @if($member->photo_id == null) d-none @endif">
                                            <img src="{{ $member->getNIDImage() }}" alt="Preview Image" />
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger file-upload-remove"
                                                title="Remove">x</button>
                                        </div>
                                        @error('photo_id')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="p-sm-3 col-sm-12">
                                <div class="form-group row @error('profile_image') error @enderror">
                                    <label class="col-sm-3 col-form-label">Profile Picture</label>
                                    <div class="col-sm-9">
                                        <div class="file-upload-section">
                                            <input name="profile_image" type="file" class="form-control d-none"
                                                allowed="png,gif,jpeg,jpg">
                                            <div class="input-group col-xs-12">
                                                <input type="text" class="form-control file-upload-info" disabled=""
                                                    readonly placeholder="Size: 200x200 and max 200kB">
                                                <span class="input-group-append">
                                                    <button class="file-upload-browse btn btn-outline-secondary"
                                                        type="button"><i class="fas fa-upload"></i> Browse</button>
                                                </span>
                                            </div>
                                            @error('profile_image')
                                                <p class="error-message">{{ $message }}</p>
                                            @enderror
                                            <div class="display-input-image"
                                                style="display: {{ $member->profile_image ? '' : 'd-none' }}">
                                                <img src="{{ $member->getProfileImage() }}" alt="Preview Image" />
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

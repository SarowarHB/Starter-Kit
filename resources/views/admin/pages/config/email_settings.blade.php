@extends('admin.layouts.master')

@section('title', 'Email Settings')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Email Settings' )) }}</h4>
        </div>
        <button onclick="clickAddAction()" class="btn mr-5 p-2 px-3 btn2-secondary text-white d-inline float-right">Test Mail</button>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="post" action="{{ route('admin.config.email.settings.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-sm-3">
                            <div class="form-group member-select row">
                                <label class="col-sm-3 col-form-label required">{{ __('Mail Driver') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control @error('mail_driver') is-invalid @enderror" name="mail_driver" id="member">
                                        <option value="smtp">SMTP</option>
                                    </select>
                                    @error('mail_driver')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-sm-3">

                            <div class="form-group row @error('mail_host') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Mail Host') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="mail_host"
                                        value="{{ old('mail_host') ?? settings('mail_host') }}" placeholder="{{ __('Mail Host') }}"
                                        required>
                                    @error('mail_host')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-sm-3">

                            <div class="form-group row @error('mail_port') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Mail Port') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="mail_port"
                                        value="{{ old('mail_port') ?? settings('mail_port') }}" placeholder="{{ __('Mail Port') }}"
                                        required>
                                    @error('mail_port')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="p-sm-3">

                            <div class="form-group row @error('mail_user_name') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Mail User Name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="mail_user_name"
                                        value="{{ old('mail_user_name') ?? settings('mail_user_name') }}" placeholder="{{ __('Mail User Name') }}"
                                        required>
                                    @error('mail_user_name')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-sm-3">

                            <div class="form-group row @error('mail_password') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Mail Password') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="mail_password"
                                        value="{{ old('mail_password') ?? settings('mail_password') }}" placeholder="{{ __('Mail Password') }}"
                                        required>
                                    @error('mail_password')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>                 
                    
                    <div class="col-md-6">
                        <div class="p-sm-3">

                            <div class="form-group row @error('mail_from') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Mail From') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="mail_from"
                                        value="{{ old('mail_from') ?? settings('mail_from') }}" placeholder="{{ __('Mail From') }}"
                                        required>
                                    @error('mail_from')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-sm-3">

                            <div class="form-group row @error('mail_from_name') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Mail From Name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="mail_from_name"
                                        value="{{ old('mail_from_name') ?? settings('mail_from_name') }}" placeholder="{{ __('Mail From Name') }}"
                                        required>
                                    @error('mail_from_name')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-sm-3">
                            <div class="form-group member-select row">
                                <label class="col-sm-3 col-form-label required">{{ __('Encryption') }}</label>
                                <div class="col-sm-9">
                                    <select name="encryption" class="form-control @error('encryption') is-invalid @enderror" placeholder="Encryption"
                        value="{{ old('encryption') ?? settings('encryption') }}">
                                    <option value="tls" {{ settings('encryption') == 'tls' ? 'selected' : '' }}>TLS
                                    </option>
                                    <option value="ssl" {{ settings('encryption') == 'ssl' ? 'selected' : '' }}>SSL
                                    </option>
                                    </select>
                                    @error('encryption')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
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
@include('admin.pages.config.modal_test_mail')
@push('scripts')
@vite('resources/admin_assets/js/pages/config/email/index.js')
@endpush

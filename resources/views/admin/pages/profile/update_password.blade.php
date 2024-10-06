@extends('admin.layouts.master')

@section('title', __('Update Password'))

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.profile.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ __('Update Password') }}</h4>
        </div>
       
    </div>

    <div class="row">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="post" action="{{ route('admin.profile.update_password', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="p-sm-3">

                            <div class="form-group row @error('current_password') error @enderror">
                                <label class="col-sm-4 col-form-label required">{{ __('Current Password') }}</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" name="current_password"
                                        value="{{ old('current_password') }}"
                                        placeholder="{{ __('Current Password') }}" required>
                                    @error('current_password')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row @error('password') error @enderror">
                                <label class="col-sm-4 col-form-label required">{{ __('New Password') }}</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" name="password"
                                        value="{{ old('password') }}"
                                        placeholder="{{ __('New Password') }}" required>
                                    @error('password')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row @error('password_confirmation') error @enderror">
                                <label class="col-sm-4 col-form-label required">{{ __('Confirmed Password') }}</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" name="password_confirmation"
                                        value="{{ old('password_confirmation') }}"
                                        placeholder="{{ __('Confirmed Password') }}" required>
                                    @error('password_confirmation')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
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
    </div>
</div>


@stop


@push('scripts')

@endpush

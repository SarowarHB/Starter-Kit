@extends('admin.layouts.master')

@section('title', 'Social Link')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Social Link' )) }}</h4>
        </div>
    </div>
    <div class="card shadow-sm col-md-6">
        <div class="card-body">
            <form method="post" action="{{ route('admin.config.social.link.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="p-sm-3">

                            <div class="form-group row @error('facebook_link') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Facebook') }}</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text text-secondary">
                                                <i class="fa-brands fa-facebook-f"></i>
                                            </span>
                                        </div>
                                        <input type="url" name="facebook_link"
                                            class="form-control" placeholder="{{ __('https://facebook.com/') }}" value="{{ old('facebook_link') ?? settings('facebook_link') }}">
                                    </div>
                                    @error('facebook_link')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('instagram_link') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Instagram') }}</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text text-secondary">
                                                <i class="fa-brands fa-instagram"></i>
                                            </span>
                                        </div>

                                        <input type="url" name="instagram_link"
                                            class="form-control" placeholder="{{ __('https://instagram.com/') }}" value="{{ old('instagram_link') ?? settings('instagram_link') }}">
                                    </div>
                                    @error('instagram_link')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('twitter_link') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Twitter') }}</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text text-secondary">
                                                <i class="fa-brands fa-twitter"></i>
                                            </span>
                                        </div>
                                        <input type="url" name="twitter_link" class="form-control"
                                            placeholder="{{ __('https://twitter.com/') }}" value="{{ old('twitter_link') ?? settings('twitter_link') }}">
                                    </div>
                                    @error('twitter_link')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('linkedin_link') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Linked In') }}</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text text-secondary">
                                                <i class="fa-brands fa-linkedin-in"></i>
                                            </span>
                                        </div>
                                        <input type="url" name="linkedin_link"
                                            class="form-control" placeholder="{{ __('https://linkedin.com/') }}" value="{{ old('linkedin_link') ?? settings('linkedin_link') }}">
                                    </div>
                                    @error('linkedin_link')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('youtube_link') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Youtube') }}</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text text-secondary">
                                                <i class="fa-brands fa-youtube"></i>
                                            </span>
                                        </div>
                                        <input type="url" name="youtube_link" class="form-control"
                                            placeholder="{{ __('https://youtube.com/') }}" value="{{ old('youtube_link') ?? settings('youtube_link') }}">
                                    </div>
                                    @error('youtube_link')
                                    <p class="error-message">{{ $message }}</p>
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

@push('scripts')

@endpush
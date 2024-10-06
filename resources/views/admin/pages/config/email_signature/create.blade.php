@extends('admin.layouts.master')

@section('title', __('New Email Signature'))

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.config.email_signature.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Email Signature')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm col-md-10">
        <div class="card-body">
            <form method="post" action="{{ route('admin.config.email_signature.create') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="p-sm-3">

                            <div class="form-group row @error('name') error @enderror">
                                <label class="col-sm-2 col-form-label required">{{ __('Name') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name') }}"
                                        placeholder="{{ __('Name') }}" required>
                                    @error('name')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('signature') error @enderror">
                                <label class="col-sm-2 col-form-label required" for="name">{{ __('Email Signature') }}</label>
                                <div class="col-sm-10">
                                    <div id="editor">
                                        <textarea name="signature" placeholder="Textarea" id="summernote" class="form-control">
                                                {{ old('signature') }}
                                        </textarea>
                                        @error('signature')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="modal-footer justify-content-center col-md-12">
                        <button type="submit" class="btn btn2-secondary"><i class="fas fa-save"></i> {{ __('Submit') }} </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@include('admin.assets.summernote-text-editor')
@push('scripts')
@vite('resources/admin_assets/js/pages/config/email_template/update.js')
@endpush

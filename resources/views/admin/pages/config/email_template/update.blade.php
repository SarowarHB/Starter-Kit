@extends('admin.layouts.master')

@section('title', __('Update Email Templates'))

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.config.email_template.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Email Templates')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="p-3">{{ $data->name }}<hr></h4>
            <form method="post" action="{{ route('admin.config.email_template.update', $data->id) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="p-sm-3">

                            <div class="form-group row @error('subject') error @enderror">
                                <label class="col-sm-2 col-form-label required">{{ __('Email Subject') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="subject"
                                        value="{{ old('subject', $data->subject) }}"
                                        placeholder="{{ __('Email Address') }}" required>
                                    @error('subject')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('message') error @enderror">
                                <label class="col-sm-2 col-form-label required" for="name">{{ __('Email Message') }}</label>
                                <div class="col-sm-10">
                                    <div id="editor">
                                        <textarea name="message" placeholder="Textarea" id="summernote" class="form-control quill-editor">
                                                {{ $data->message }}
                                        </textarea>
                                        @error('message')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="pt-sm-10">
                                        @foreach($shortcodes as $key => $shortcode)
                                            <span class="badge btn2-light-secondary pointer mb-sm-2 m-1" onclick="copyShortCode('{{ $shortcode }}')">{{ $shortcode }}</span>
                                        @endforeach
                                        @foreach($systemShortCodes as $shortcode => $systemShortCode)
                                            <span class="badge btn2-light-secondary pointer mb-sm-2 m-1" onclick="copyShortCode('{{ $shortcode }}')">{{ $shortcode }}</span>
                                        @endforeach
                                        <div id="copied-success" class="copied">
                                            <span>Copied!</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="modal-footer justify-content-center col-md-12">
                        <button type="submit" class="btn btn2-secondary"><i class="fas fa-save"></i> {{ __('Update') }} </button>
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

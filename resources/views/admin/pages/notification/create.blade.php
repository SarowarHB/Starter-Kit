@extends('admin.layouts.master')

@section('title', __('New Notification'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        
    {!! \App\Library\Html::linkBack(route('admin.notification.index')) !!}

    <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Notification')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm col-md-5">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.notification.create') }}" enctype="multipart/form-data" id="notificationCreateForm">
                @csrf

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label required">{{ __('User Type') }}</label>
                    <div class="col-sm-9">
                        <div class="d-inline-flex justify-content-start">

                            <div class="form-check form-check-secondary mr-5">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="is_for_emp" id="is_for_emp" value="1" onclick="userTypeValidation()">
                                Employee
                                <i class="input-helper"></i></label>
                            </div>
                            <div class="form-check form-check-secondary mr-5">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="is_for_member" id="is_for_member" value="1" onclick="userTypeValidation()">
                                Member
                                <i class="input-helper"></i></label>
                            </div>
                        </div>
                        <span class="text-danger" id="checkbox"></span>
                    </div>
                </div>

                <div class="form-group row @error('subject') error @enderror">
                    <label class="col-sm-3 col-form-label required">{{ __('Subject') }}</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" name="subject" value="{{ old('subject') }}" placeholder="{{ __('Notification Subject') }}" required>
                        @error('subject')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('message') error @enderror">
                    <label class="col-sm-3 col-form-label required">{{ __('Message') }}</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="exampleTextarea1" name="message" rows="5" placeholder="Notification Message" required>{{ old('message') }}</textarea>
                        @error('message')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('send_date') error @enderror">
                    <label class="col-sm-3 col-form-label">{{ __('Send Date') }}</label>
                    <div class="col-sm-9">
                    <input type="date" class="form-control" name="send_date" min="{{ now()->format('Y-m-d') }}" value="{{ old('send_date') }}">
                        @error('send_date')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-footer text-center">
                    {!! \App\Library\Html::btnSubmit() !!}
                </div>

            </form>
        </div>
    </div>
</div>
@stop

@push('scripts')
@vite('resources/admin_assets/js/pages/notification/create.js')
@endpush
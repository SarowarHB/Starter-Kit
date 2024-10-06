@extends('admin.layouts.master')

@section('title', __('Update Event'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.website.event.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Event')) }}</h4>
        </div>
        
    </div>

    <div class="card shadow-sm col-md-8">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.website.event.update', $event->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="p-sm-3">

                    <div class="form-group row @error('event_type') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Event Type') }}</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="event_type" required>
                                <option value="" class="selected highlighted">Select One</option>
                                @foreach($event_type as $value)
                                    <option value="{{ $value }}" {{(old("event_type", $event->event_type) == $value) ? "selected" : ""}}>
                                        {{ ucwords($value) }}</option>
                                @endforeach
                            </select>
                            @error('event_type')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('title') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Title') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="title"
                                value="{{ old('title', $event->title) }}" placeholder="{{ __('Write Your Event Title') }}"
                                required>
                            @error('title')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    @php
                        $start = strtotime( $event->start );
                        $end = strtotime( $event->end );
                    @endphp

                    <div class="form-group row @error('start') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Start Date') }}</label>
                        <div class="col-sm-9">
                            <div class="input-group custom-dt-group">
                                <input type="text" class="form-control " id="get_start" name="start"
                                    value="{{ old('start', date('Y-m-d H:i', $start)) }}" readonly placeholder="{{ __('Ex. 1980-01-25 15:44') }}"
                                    required>
                                <div class="input-group-append " style="cursor: pointer">
                                    <span class="input-group-text" id="start"><i class="far fa-calendar-alt"></i></span>
                                </div>
                            </div>
                            @error('start')
                            <p class="error-message">{{ $message }}</p>
                            @enderror

                        </div>
                    </div>

                    <div class="form-group row @error('end') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('End Date') }}</label>
                        <div class="col-sm-9">
                            <div class="input-group custom-dt-group">
                                <input type="text" class="form-control" name="end" value="{{ old('end', date('Y-m-d H:i', $end)) }}" readonly
                                    placeholder="{{ __('Ex. 1980-01-25 15:44') }}" required>
                                <div class="input-group-append" style="cursor: pointer">
                                    <span class="input-group-text" id="end"><i class="far fa-calendar-alt"></i></span>
                                </div>
                            </div>
                            @error('end')
                            <p class="error-message">{{ $message }}</p>
                            @enderror

                        </div>
                    </div>

                    <div class="form-group row @error('featured_image') error @enderror">
                        <label class="col-sm-3 col-form-label required">Thumbnail</label>
                        <div class="col-sm-9">
                            <div class="file-upload-section">
                                <input name="featured_image" type="file" class="form-control d-none"
                                    allowed="png,gif,jpeg,jpg">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled=""
                                        readonly placeholder="Size: 200x200 and max 500kB">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-outline-secondary"
                                            type="button"><i class="fas fa-upload"></i> Browse</button>
                                    </span>
                                </div>
                                @error('featured_image')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                                <div class="display-input-image"
                                    style="display: {{ $event->featured_image ? '' : 'd-none' }}">
                                    <img src="{{ $event->getFeaturedImage() }}" alt="Preview Image" />
                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger file-upload-remove"
                                        title="Remove">x</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row @error('short_description') error @enderror">
                        <label class="col-sm-3 col-form-label required" for="short_description">{{ __('Short Description') }}</label>
                        <div class="col-sm-9">
                            <textarea type="text" name="short_description" class="form-control"
                                placeholder="{{ __('Write Short Description') }}" rows="4">{{ old('short_description', $event->short_description) }}</textarea>
                            @error('short_description')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('description') error @enderror">
                        <label class="col-sm-3 col-form-label required" for="description">{{ __('Description') }}</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="summernote" name="description" required>{{ old('description', $event->description) }}</textarea>
                            @error('description')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
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

@include('admin.assets.summernote-text-editor')
@include('admin.assets.select2')
@include('admin.assets.date-range-picker')

@push('scripts')
    @vite('resources/admin_assets/js/pages/event/create.js')
@endpush

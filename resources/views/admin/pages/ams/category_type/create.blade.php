@extends('admin.layouts.master')

@section('title', __('New Category Type'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.ams.category_type.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Category Type')) }}</h4>
        </div>

    </div>

    <div class="card shadow-sm col-md-6">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.ams.category_type.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="p-sm-3">

                            <div class="form-group row @error('name') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name') }}" placeholder="{{ __('Name') }}"
                                        required>
                                    @error('name')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('unique_key') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Unique Key') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="unique_key"
                                        value="{{ old('unique_key') }}" placeholder="{{ __('Unique Key') }}"
                                        required>
                                    @error('unique_key')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('entry_type') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Entry Type') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="entry_type" required>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach(\App\Library\Enum::getCategoryEntryType() as $index => $value)
                                            <option value="{{ $index }}" {{(old("entry_type") == $index) ? "selected" : ""}}>
                                                {{ ucwords($value) }}</option>
                                        @endforeach
                                    </select>
                                    @error('entry_type')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
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

@include('admin.assets.select2')

@push('scripts')
@vite('resources/admin_assets/js/pages/asset/create.js')
@endpush

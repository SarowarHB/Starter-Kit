@extends('admin.layouts.master')

@section('title', __('New Category'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.ams.category.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Category')) }}</h4>
        </div>
        
    </div>

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.ams.category.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
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
                            <div class="form-group row @error('parent_id') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Parent Category') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="parent_id">
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($parent_categories as $key => $parent_category)
                                            <option value="{{ $parent_category->id }}" {{(old("parent_id") == $parent_category->id) ? "selected" : ""}}>
                                                {{ ucwords($parent_category->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('category_type_id') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Category Type') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="category_type_id" required>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($category_types as $category_type)
                                            <option value="{{ $category_type->id }}" {{(old("category_type_id") == $category_type->id) ? "selected" : ""}}>
                                                {{ ucwords($category_type->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_type_id')
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
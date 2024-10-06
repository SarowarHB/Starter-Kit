@extends('admin.layouts.master')

@section('title', __('Update Product'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.ams.product.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Product')) }}</h4>
        </div>
        
    </div>

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.ams.product.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-sm-3">

                            <div class="form-group row @error('name') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name', $product->name) }}" placeholder="{{ __('Name') }}"
                                        required>
                                    @error('name')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('category_id') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Category') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="category_id" id="categories" required>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($categories as $key => $category)
                                            @if (!$category->parent_id)    
                                                <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? "selected" : "" }}>
                                                    {{ ucwords($category->name) }}
                                                </option>
                                            @endif
                                        
                                            @foreach($category->children as $key => $subCategory) 
                                               
                                                <option value="{{ $subCategory->id }}" {{ $subCategory->id == $product->category_id ? "selected" : "" }}>
                                                    --{{ ucwords($subCategory->name) }}
                                                </option>
                                                
                                                    @foreach($subCategory->children as $key => $subSubCat) 
                                                        <option value="{{ $subSubCat->id }}" {{ $subSubCat->id == $product->category_id ? "selected" : "" }}>
                                                            ----{{ ucwords($subSubCat->name) }}
                                                        </option>
                                                    @endforeach
                                            @endforeach
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ __('Brand') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="brand">
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($brands as $value)
                                            <option value="{{ $value }}" {{(old("brand", $product->brand) == $value) ? "selected" : ""}}>
                                                {{ ucwords($value) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ __('Model') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="model"
                                        value="{{ old('model', $product->model) }}" placeholder="{{ __('Model') }}"
                                        >
                                </div>
                            </div>
                            
                            <div class="form-group row @error('Image') error @enderror">
                                <label class="col-sm-3 col-form-label required" for="description">{{ __('Image') }}</label>
                                <div class="col-sm-9">
                                    <div class="file-upload-section">
                                        <input name="image" type="file" class="form-control d-none"
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
                                        <div class="display-input-image @if($product->image == null) d-none @endif">
                                            <img src="{{ $product->getImage() }}" alt="Preview Image" />
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger file-upload-remove"
                                                title="Remove">x</button>
                                        </div>
                                        @error('image')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="description">{{ __('Description') }}</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="summernote" name="description">{{ old('description', $product->description) }}</textarea>
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
@include('admin.assets.summernote-text-editor')
@include('admin.assets.select2')

@push('scripts')
@vite('resources/admin_assets/js/pages/ams/product/create.js')
@endpush
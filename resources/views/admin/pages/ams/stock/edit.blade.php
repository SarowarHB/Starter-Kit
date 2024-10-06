@extends('admin.layouts.master')

@section('title', __('Update Stock'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.ams.stock.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Stock')) }}</h4>
        </div>

    </div>

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.ams.stock.update', $stock->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-sm-3">

                            @php
                                $type = $stock->product->category->categoryType->entry_type;
                            @endphp

                            <div class="form-group row @error('product_id') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Product') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="product_id" id="product" {{ $type == \App\Library\Enum::CATEGORY_BULK ? 'disabled' : ''}}>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{(old("product_id", $stock->product_id) == $product->id) ? "selected" : ""}}>
                                                {{ $product->name }}-{{ $product->category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('supplier_id') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Supplier') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="supplier_id" id="supplier" required>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{(old("supplier_id", $stock->supplier_id) == $supplier->id) ? "selected" : ""}}>
                                                {{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('quantity') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Quantity') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="quantity" id="quantity"
                                        value="{{ old('quantity', $stock->quantity) }}" min="1" placeholder="{{ __('Quantity') }}"
                                        required {{ $type == \App\Library\Enum::CATEGORY_INDIVIDUAL ? 'readonly' : ''}}>
                                    @error('quantity')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row @error('unit_price') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Unit Price') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" min="0" step="0.01" name="unit_price" id="price"
                                        value="{{ old('unit_price', $stock->unit_price) }}" placeholder="{{ __('Unit Price') }}"
                                        required>
                                    @error('unit_price')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('location') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Location') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="location" required>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($locations as $value)
                                            <option value="{{ $value }}" {{(old("location", $stock->location) == $value) ? "selected" : ""}}>
                                                {{ ucwords($value) }}</option>
                                        @endforeach
                                    </select>
                                    @error('location')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="p-sm-3 col-sm-12">

                                <div class="form-group row @error('mac_id') error @enderror" id="macDiv">
                                    <label class="col-sm-3 col-form-label">{{ __('MAC ID') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="mac_id"
                                            value="{{ old('mac_id', $stock->mac_id) }}" placeholder="{{ __('MAC ID') }}">
                                        @error('mac_id')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row @error('warranty_date') error @enderror" id="warrentyDiv">
                                    <label class="col-sm-3 col-form-label" for="name">{{ __('Warranty Date') }}</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="warranty_date" min="{{ now()->format('Y-m-d') }}" class="form-control"
                                            value="{{old('warranty_date', $stock->warranty_date)}}"
                                            {{ $type == \App\Library\Enum::CATEGORY_BULK ? 'disabled' : '' }}>
                                        @error('warranty_date')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row @error('testing_date') error @enderror" id="testingDiv">
                                    <label class="col-sm-3 col-form-label" for="name">{{ __('Testing Date') }}</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="testing_date" min="{{ now()->format('Y-m-d') }}" class="form-control"
                                            value="{{old('testing_date', $stock->testing_date)}}"
                                            {{ $type == \App\Library\Enum::CATEGORY_BULK ? 'disabled' : '' }}>
                                        @error('testing_date')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row @error('purchase_date') error @enderror">
                                    <label class="col-sm-3 col-form-label required" for="name">{{ __('Purchase Date') }}</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="purchase_date" max="{{ now()->format('Y-m-d') }}" class="form-control"
                                            value="{{old('purchase_date', $stock->purchase_date)}}" required>
                                        @error('purchase_date')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row @error('note') error @enderror">
                                    <label class="col-sm-3 col-form-label" for="name">{{ __('Note') }}</label>
                                    <div class="col-sm-9">
                                        <textarea type="text" name="note" class="form-control"
                                            placeholder="{{ __('Write About Stock') }}" rows="4">{{ old('note', $stock->note) }}</textarea>
                                        @error('note')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <input type="hidden" id="categoryType" value="{{ $type }}">

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
@vite('resources/admin_assets/js/pages/ams/stock/edit.js')
@endpush

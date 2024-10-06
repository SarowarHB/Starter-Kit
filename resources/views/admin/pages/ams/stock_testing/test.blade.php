@extends('admin.layouts.master')

@section('title', __('Test Stock'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.ams.stock_testing.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Test Stock')) }}</h4>
        </div>

    </div>

    <div class="card shadow-sm col-md-6">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.ams.stock_testing.store_test') }}"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                <div class="row">
                    <div class="col-md-12">
                        <div class="p-sm-3">

                            <div class="form-group row @error('testing_date') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Testing Date') }}</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" name="testing_date"
                                        value="{{ old('testing_date', $stock->testing_date ) }}" readonly>
                                    @error('testing_date')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('next_testing_date') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Next Testing Date') }}</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" name="next_testing_date"
                                        value="{{ old('next_testing_date', $stock->next_testing_date) }}" required>
                                    @error('next_testing_date')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('status') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Status') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="status" required>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($status as $key => $status_name)
                                            <option value="{{ $key }}" {{ old("status") == $key ? "selected" : ""}}>
                                                {{ ucwords($status_name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('note') error @enderror">
                                    <label class="col-sm-3 col-form-label required">{{ __('Note') }}</label>
                                    <div class="col-sm-9">
                                        <textarea type="text" class="form-control" name="note"
                                            value="{{ old('note', $stock->note ) }}" placeholder="{{ __('Note') }}" rows="8" required></textarea>
                                        @error('note')
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
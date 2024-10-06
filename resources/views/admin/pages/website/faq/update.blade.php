@extends('admin.layouts.master')

@section('title', __('Update Faq'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.website.faq.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Faq')) }}</h4>
        </div>
        
    </div>

    <div class="card shadow-sm col-md-8">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.website.faq.update', $faq->id) }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $faq->id }}">
                <div class="p-sm-3">

                    <div class="form-group row @error('qustion') error @enderror">
                        <label class="col-sm-3 col-form-label required" for="qustion">{{ __('Qustion') }}</label>
                        <div class="col-sm-9">
                            <textarea type="text" name="qustion" class="form-control"
                                placeholder="{{ __('Write A Qustion') }}" rows="3" required>{{ old('qustion', $faq->qustion) }}</textarea>
                            @error('qustion')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('answer') error @enderror">
                        <label class="col-sm-3 col-form-label required" for="answer">{{ __('Answer') }}</label>
                        <div class="col-sm-9">
                        <textarea type="text" name="answer" class="form-control"
                                placeholder="{{ __('Write Answer.......') }}" rows="8" required>{{ old('answer', $faq->answer) }}</textarea>
                            @error('answer')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('position') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Position') }}</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="position"
                                value="{{ old('position', $faq->position) }}" placeholder="{{ __('1') }}"
                                required>
                            @error('position')
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

@push('scripts')
@endpush
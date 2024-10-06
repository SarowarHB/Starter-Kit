@extends('admin.layouts.master')

@section('title', __('New Expense'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.expense.general.index')) !!}
        
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Expense')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm col-md-6">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.expense.general.create') }}" enctype="multipart/form-data">
                @csrf
                <div class="p-sm-3">

                    <div class="form-group row @error('expense_type') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Expense Type') }}</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="expense_type" required>
                                <option value="" class="selected highlighted">Select One</option>
                                @foreach($expense_type as $value)
                                    <option value="{{ $value }}" {{(old("expense_type") == $value) ? "selected" : ""}}>
                                        {{ ucwords($value) }}</option>
                                @endforeach
                            </select>
                            @error('expense_type')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('title') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Title') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="title"
                                value="{{ old('title') }}" placeholder="{{ __('Write Your Blog Title') }}"
                                required>
                            @error('title')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('amount') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Amount') }}</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" min="0.01" name="amount" step="0.01"
                                value="{{ old('amount') }}" placeholder="{{ __('Write Amount') }}"
                                required>
                            @error('amount')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('date') error @enderror">
                        <label class="col-sm-3 col-form-label required" for="date">{{ __('Date') }}</label>
                        <div class="col-sm-9">
                            <input type="date" name="date" id="date" max="{{ now()->format('Y-m-d') }}" class="form-control"
                                value="{{old('date')}}" required>
                            @error('date')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('notes') error @enderror">
                        <label class="col-sm-3 col-form-label" for="notes">{{ __('Notes') }}</label>
                        <div class="col-sm-9">
                            <textarea type="text" name="notes" class="form-control"
                                placeholder="{{ __('Write Short Note') }}" rows="4">{{ old('notes') }}</textarea>
                            @error('notes')
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
<script>
    
</script>
@endpush
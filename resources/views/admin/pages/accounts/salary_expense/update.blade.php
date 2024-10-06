@extends('admin.layouts.master')

@section('title', __('Update Employee Salary'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.expense.salary.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Employee Salary')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm col-md-12">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.expense.salary.update', $salary_expense->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">

                        <div class="p-sm-3">
                            <div class="form-group row @error('employee_id') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Employee') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="employee_id" required>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}"

                                            {{ (old("employee_id", $salary_expense->employee_id) == $employee->id) ? "selected" : "" }}>
                                            {{ ucwords($employee->getFullNameAttribute()) }}</option>
                                        @endforeach
                                    </select>
                                    @error('employee_id')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('payment_method') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Payment Method') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="payment_method" required>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($payment_methods as $payment_method)
                                            <option value="{{$payment_method}}" {{(old("payment_method", $salary_expense->payment_method) == $payment_method) ? "selected" : ""}}>{{$payment_method}}</option>
                                        @endforeach
                                    </select>
                                    @error('payment_method')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('month_of_salary') error @enderror">
                                <label class="col-sm-3 col-form-label required"
                                    for="month_of_salary">{{ __('Salary Month') }}</label>
                                <div class="col-sm-9">
                                    <input type="month" name="month_of_salary" id="month_of_salary" class="form-control"
                                        value="{{ old('month_of_salary', date('Y-m', strtotime($salary_expense->month_of_salary)) ) }}" required>
                                    @error('month_of_salary')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('salary') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Salary') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="salary" min="0.0001" id="salary" step="0.0001"
                                        value="{{ old('salary', $salary_expense->salary) }}" placeholder="{{ __('Write Amount') }}" required>
                                    @error('salary')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('bonus') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Bonus') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="bonus" id="bonus" min="0" step="0.0001"
                                        value="{{ old('bonus', $salary_expense->bonus) }}" placeholder="{{ __('Write Amount') }}" required>
                                    @error('bonus')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-sm-3">

                            <div class="form-group row @error('total_salary') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Total Salary') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="total_salary" name="total_salary" min="0" step="0.0001" readonly
                                        value="{{ old('total_salary', $salary_expense->total_salary) }}" placeholder="{{ __('Write Amount') }}" required>
                                    @error('total_salary')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('trans_date') error @enderror">
                                <label class="col-sm-3 col-form-label required" for="trans_date">{{ __('Transaction Date') }}</label>
                                <div class="col-sm-9">
                                    <input type="date" name="trans_date" max="{{ now()->format('Y-m-d') }}" id="trans_date" class="form-control"
                                        value="{{old('trans_date', $salary_expense->trans_date)}}" required>
                                    @error('trans_date')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('note') error @enderror">
                                <label class="col-sm-3 col-form-label" for="note">{{ __('Notes') }}</label>
                                <div class="col-sm-9">
                                    <textarea type="text" name="note" class="form-control"
                                        placeholder="{{ __('Write Short Note') }}"
                                        rows="4">{{ old('notes', $salary_expense->note) }}</textarea>
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

@push('scripts')
@vite('resources/admin_assets/js/pages/expense/salary/create.js')
@endpush
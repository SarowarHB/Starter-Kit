@extends('admin.layouts.master')

@section('title', 'Employee Salary Details')

@section('content')

@php
$user_role = App\Models\User::getAuthUser()->roles()->first();
@endphp

<div class="content-wrapper">
    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.expense.salary.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Employee Salary Details')) }}</h4>
        </div>

    </div>

    <div class="row">

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="border-bottom text-center pb-2">
                        <div class="mb-3">
                            <h3>{{ $salary_expense->user->getFullNameAttribute() }} </h3>
                        </div>
                        <p class="mx-auto mb-2 w-75">{{ $salary_expense->note }}</p>
                    </div>
                    <table class="table org-data-table table-bordered show-table">
                        <tbody>
                            <tr>
                                <td>Month</td>
                                <td> {{ date('M Y', strtotime($salary_expense->month_of_salary)) }} </td>
                            </tr>
                            
                            <tr>
                                <td>Salary</td>
                                <td> {{ $salary_expense->salary }} </td>
                            </tr>

                            <tr>
                                <td>Bonus</td>
                                <td> {{ $salary_expense->bonus }} </td>
                            </tr>

                            <tr>
                                <td>Total Salary</td>
                                <td> {{ $salary_expense->total_salary }} </td>
                            </tr>

                            <tr>
                                <td>Date</td>
                                <td> {{ $salary_expense->trans_date }} </td>
                            </tr>

                            <tr>
                                <td>Operator</td>
                                <td> {{ $salary_expense->createUser->getFullNameAttribute() }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card shadow-sm">
                <div class="card-header bg-light-secondary">
                    <span><i class="fas fa-cog"></i> {{ __('Actions') }} </span>
                </div>

                <div class="card-body py-4">
                    <div class="text-left">
                        <a href="{{ route('admin.expense.salary.update', $salary_expense->id) }}"
                            class="btn btn-block  btn-sm btn-warning mr-1">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button class="btn btn-sm btn-block btn-danger"
                            onclick="confirmFormModal('{{ route('admin.expense.salary.delete.api', $salary_expense->id) }}', 'Confirmation', 'Are you sure to delete operation?')">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@stop


@push('scripts')
<script>
    function clickChangeStatus() {
        $(changeStatusModal).modal('show');
    }
</script>
@endpush
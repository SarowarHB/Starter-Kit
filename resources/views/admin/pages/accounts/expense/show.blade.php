@extends('admin.layouts.master') 

@section('title', 'Expense Details')

@section('content') 

@php
    $user_role = App\Models\User::getAuthUser()->roles()->first();
@endphp

<div class="content-wrapper">
    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.expense.general.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Expense Details')) }}</h4>
        </div>
    </div>

    <div class="row">

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="border-bottom text-center pb-2">
                        <div class="mb-3">
                            <h3>{{ $expense->title }} </h3>
                        </div>
                        <p class="mx-auto mb-2 w-75">{{ $expense->notes }}</p>
                    </div>
                    <table class="table org-data-table table-bordered show-table">
                        <tbody>
                            <tr>
                                <td>Type</td>
                                <td> {{ ucwords($expense->expense_type) }} </td>
                            </tr>
                            <tr>
                                <td>Amount</td>
                                <td> {{ $expense->amount }} </td>
                            </tr>
                            <tr>
                                <td>Date</td>
                                <td> {{ $expense->date }} </td>
                            </tr>
                            <tr>
                                <td>Operator</td>
                                <td> {{ $expense->user->nick_name }} </td>
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
                        <a href="{{ route('admin.expense.general.update', $expense->id) }}" class="btn btn-block  btn-sm btn-warning mr-1">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button class="btn btn-sm btn-block btn-danger"
                            onclick="confirmFormModal('{{ route('admin.expense.general.delete.api', $expense->id) }}', 'Confirmation', 'Are you sure to delete operation?')">
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

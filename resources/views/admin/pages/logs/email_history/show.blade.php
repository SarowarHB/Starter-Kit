@extends('admin.layouts.master')

@section('title', 'Email History Details')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.log.email.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Email History Details')) }}</h4>
        </div>
        
    </div>

    <div class="card">
        <div class="card-body p-4">
            <table class="table org-data-table table-bordered table-responsive">
                <tbody>
                    <tr>
                        <td>{{ __('ID') }}</td>
                        <td>{{ $emailHistory->id }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('User ID') }}</td>
                        <td>{{ $emailHistory->user_id }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Email') }}</td>
                        <td>{{ $emailHistory->email }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Subject') }}</td>
                        <td>{{ $emailHistory->subject }}</td>
                    </tr>
                    <tr>
                        <td style="width:15%;">{{ __('Message') }}</td>
                        <td style="white-space: unset;">{!! $emailHistory->message !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

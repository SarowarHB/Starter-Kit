@extends('admin.layouts.master')

@section('title', 'Email History')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Email History')) }}</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <table id="dataTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User ID</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Created At</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop



@include('admin.assets.dt')
@include('admin.assets.dt-buttons')

@push('scripts')
@vite('resources/admin_assets/js/pages/logs/email_history.js')
@endpush

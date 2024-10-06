@extends('admin.layouts.master')

@section('title', 'Email Signature')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Email Signature')) }}</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <table id="dataTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Signature</th>
                        <th>Updated At</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('admin.pages.config.email_signature.partials.modal_show_email_signature')
@stop
@include('admin.assets.dt')
@include('admin.assets.dt-buttons')


@push('scripts')
@vite('resources/admin_assets/js/pages/config/email_signature/index.js')
@endpush

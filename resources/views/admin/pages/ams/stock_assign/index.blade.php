@extends('admin.layouts.master')

@section('title', 'Stock Assign')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Stock Assign' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <table id="dataTable" class="table table-bordered ticket-data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Asset Id</th>
                        <th>Asset Type</th>
                        <th>Asset</th>
                        <th>Category</th>
                        <th>Assigned Date</th>
                        <th>Quantity</th>
                        <th>Acknowledgement</th>
                        <th>Operator</th>
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
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/admin_assets/js/pages/ams/stock_assign/index.js')
@endpush

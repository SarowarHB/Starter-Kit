@extends('admin.layouts.master')

@section('title', 'Stocks')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Stocks' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div id="filterArea" class="d-inline-flex justify-content-start">
                <ul class="nav nav-pills nav-pills-success"  role="tablist" >
                    @php $available_stock = \App\Library\Enum::STOCK_AVAILABLE; @endphp
                    @foreach(\App\Library\Enum::getStockStatus() as $key => $value)
                        <li class="nav-item">
                            <a class="nav-link tab-menu {{ $available_stock == $key ? 'active' : '' }}" href="#" onclick="filterStatus('{{$key}}')">{{ $value }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <input type="hidden" id="availableStock" value="{{ $available_stock }}">

            <table id="dataTable" class="table table-bordered stock-data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>UID</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Product </th>
                        <th>Location </th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
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
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/admin_assets/js/pages/ams/stock/index.js')
@endpush

@extends('admin.layouts.master')

@section('title', 'Stock Details')

@section('content')

@php
    $user_role = App\Models\User::getAuthUser()->roles()->first();
@endphp

<div class="content-wrapper">
    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.ams.stock.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Stock Details')) }}</h4>
        </div>
    </div>

    <div class="row">

        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="border-bottom text-center pb-2">
                        <img src="{{ $stock->product->getImage() }}" alt="profile" class="img-lg rounded-circle mb-3">
                        <div class="mb-3">
                            <h3>{{ $stock->product->name }} </h3>
                        </div>
                        <p class="mx-auto mb-2 w-75">{{ $stock->location }}</p>
                    </div>
                    <table class="table org-data-table table-bordered show-table">
                        <tbody>
                            <tr>
                                <td>Status</td>
                                <td>
                                    @if($stock->status == \App\Library\Enum::STOCK_AVAILABLE)
                                        <span class="badge btn2-secondary">Available</span>
                                    @elseif($stock->status == \App\Library\Enum::STOCK_ASSIGNED)
                                        <span class="badge btn-warning">Assigned</span>
                                    @elseif($stock->status == \App\Library\Enum::STOCK_WARRANTY)
                                        <span class="badge btn-danger">Warrenty</span>
                                    @elseif($stock->status == \App\Library\Enum::STOCK_DAMAGED)
                                        <span class="badge btn-warning">Damaged</span>
                                    @elseif($stock->status == \App\Library\Enum::STOCK_MISSING)
                                        <span class="badge btn-danger">Missing</span>
                                    @elseif($stock->status == \App\Library\Enum::STOCK_EXPIRED)
                                        <span class="badge btn-danger">Expired</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Unique ID</td>
                                <td> {{ $stock->unique_id }} </td>
                            </tr>
                            <tr>
                                <td>Type</td>
                                <td> {{ $stock->product->category->categoryType->name }} </td>
                            </tr>
                            <tr>
                                <td>Category</td>
                                <td> {{ $stock->product->category->name }} </td>
                            </tr>
                            <tr>
                                <td>Quantity</td>
                                <td> <b>{{ $stock->quantity }}</b> </td>
                            </tr>
                            <tr>
                                <td>Unit Price</td>
                                <td> <b>{{ env('CURRENCY_SIGN') }}{{ $stock->unit_price }}</b> </td>
                            </tr>
                            <tr>
                                <td>MAC ID</td>
                                <td> {{ $stock->mac_id }} </td>
                            </tr>
                            <tr>
                                <td>Purchased Date</td>
                                <td> {{ $stock->purchase_date }} </td>
                            </tr>
                            <tr>
                                <td>Warranty Date</td>
                                <td> {{ $stock->warranty_date }} </td>
                            </tr>
                            <tr>
                                <td>T&T Date</td>
                                <td> {{ $stock->testing_date }} </td>
                            </tr>
                            <tr>
                                <td style="width:30%;">Operator</td>
                                <td style="white-space: unset;"> {{ $stock->operator->getFullNameAttribute() }} </td>
                            </tr>
                        </tbody>
                    </table>


                    <div class="text-center mt-4">

                        @if($user_role->hasPermission('stock_change_status'))
                            <button class="btn btn-sm mb-2 mr-2 btn2-secondary" onclick="clickChangeStatus()">
                                <i class="fas fa-power-off"></i> Change Status
                            </button>
                        @endif

                        @if($user_role->hasPermission('stock_update'))
                            <a href="{{ route('admin.ams.stock.edit', $stock->id) }}" class="btn btn-sm btn-warning mb-2 mr-2">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        @endif

                        @if($user_role->hasPermission('stock_delete'))
                            <button class="btn btn-sm btn-danger mb-2"
                                onclick="confirmFormModal('{{ route('admin.ams.stock.delete', $stock->id) }}', 'Confirmation', 'Are you sure to delete operation?')">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        @endif

                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header bg-light-secondary">
                    <span><i class="fas fa-book"></i> {{ __('Descriptions') }} </span>
                </div>

                <div class="card-body py-4">
                    <div class="text-left">

                        {!! $stock->product->description !!}

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@include('admin.pages.ams.stock.change_status')

@stop
@push('scripts')
<script>
    function clickChangeStatus() {
        $(changeStatusModal).modal('show');
    }
</script>
@endpush

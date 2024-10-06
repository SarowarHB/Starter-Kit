@extends('admin.layouts.master') 

@section('title', 'Asset Details')

@section('content') 

@php
    $user_role = App\Models\User::getAuthUser()->roles()->first();
@endphp

<div class="content-wrapper">
    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.asset.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Asset Details')) }}</h4>
        </div>
    </div>

    <div class="row">

        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="border-bottom text-center pb-2">
                        <img src="{{ $asset->getAssetImage() }}" alt="profile" class="img-lg rounded-circle mb-3">
                        <div class="mb-3">
                            <h3>{{ $asset->name }} </h3>
                        </div>
                        <p class="mx-auto mb-2 w-75">{{ $asset->description }}</p>
                    </div>
                    <table class="table org-data-table table-bordered show-table">
                        <tbody>
                            <tr>
                                <td>Status</td>
                                <td>
                                    @if($asset->status == \App\Library\Enum::ASSET_GOOD)
                                        <span class="badge btn2-secondary">Good</span>
                                    @elseif($asset->status == \App\Library\Enum::ASSET_DAMAGE)
                                        <span class="badge btn-warning">Damage</span>
                                    @elseif($asset->status == \App\Library\Enum::ASSET_LOST)
                                        <span class="badge btn-danger">Lost</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Type</td>
                                <td> {{ ucwords($asset->asset_type) }} </td>
                            </tr>
                            <tr>
                                <td>Quantity</td>
                                <td> {{ $asset->quantity }} </td>
                            </tr>
                            <tr>
                                <td>Unit Price</td>
                                <td> {{ $asset->price }} </td>
                            </tr>
                            <tr>
                                <td>Total Price</td>
                                <td> {{ $asset->price }} </td>
                            </tr>
                            <tr>
                                <td>Stock</td>
                                <td> {{ $asset->stock }} </td>
                            </tr>
                            <tr>
                                <td>Purchase Date</td>
                                <td> {{ $asset->purchased_date }} </td>
                            </tr>
                            <tr>
                                <td>Warranty Date</td>
                                <td> {{ isset($asset->warranty_date) ? $asset->warranty_date : 'N/A' }} </td>
                            </tr>
                            <tr>
                                <td>Syatem Date</td>
                                <td> {{ $asset->created_at }} </td>
                            </tr>
                            <tr>
                                <td style="width:30%;">Vendor Info</td>
                                <td style="white-space: unset;"> {{ $asset->vender_info }} </td>
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
                    
                        @if($asset->status == \App\Library\Enum::ASSET_GOOD)
                        <button class="btn btn-block btn-sm mb-3 btn-secondary" onclick="clickChangeStatus()">
                            <i class="fas fa-power-off"></i> Change Status 
                        </button>
                        @endif
                        
                        <a href="{{ route('admin.asset.update', $asset->id) }}" class="btn btn-block btn-sm btn-warning mb-3">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        
                        @if($asset->stock > 0 && $asset->status == \App\Library\Enum::ASSET_GOOD)
                        <a href="{{ route('admin.asset.sale.create', $asset->id) }}" class="btn btn-block btn-sm btn2-secondary mb-3">
                            <i class="fas fa-edit"></i> Sale Asset
                        </a>
                        @endif

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@include('admin.pages.asset.change_status')

@stop
@push('scripts')
<script>
    function clickChangeStatus() {
        $(changeStatusModal).modal('show');
    }
</script>
@endpush

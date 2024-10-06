@extends('admin.layouts.master') 

@section('title', 'Asset Sale Details')

@section('content') 

@php
    $user_role = App\Models\User::getAuthUser()->roles()->first();
@endphp

<div class="content-wrapper">
    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.asset.sale.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Asset Sale Details')) }}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="border-bottom text-center pb-2">
                        <img src="{{ $assetSale->asset->getAssetImage() }}" alt="profile" class="img-lg rounded-circle mb-3">
                        <div class="mb-3">
                            <h3>{{ $assetSale->name }} </h3>
                        </div>
                        <p class="mx-auto mb-2 w-75">{{ $assetSale->asset->description }}</p>
                    </div>
                    <table class="table org-data-table table-bordered show-table">
                        <tbody>
                            <tr>
                                <td style="width:30%;">Sale To</td>
                                <td style="white-space: unset;"> {{ $assetSale->sale_to }} </td>
                            </tr>
                            <tr>
                                <td>Asset Types</td>
                                <td> {{ ucwords($assetSale->asset->asset_type) }} </td>
                            </tr>
                            <tr>
                                <td>Quantity</td>
                                <td> {{ $assetSale->quantity }} </td>
                            </tr>
                            <tr>
                                <td>Unit Price</td>
                                <td> {{ $assetSale->price }} </td>
                            </tr>
                            <tr>
                                <td>Total Price</td>
                                <td> {{ $assetSale->price }} </td>
                            </tr>
                            <tr>
                                <td>Profit or Lose</td>
                                <td>
                                    @if($assetSale->lose_or_profit < 0)
                                        <span class="badge btn-danger">{{ $assetSale->lose_or_profit }}</span>
                                    @else
                                        <span class="badge btn2-secondary">{{ $assetSale->lose_or_profit }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Sale Date</td>
                                <td> {{ $assetSale->sale_date }} </td>
                            </tr>
                            <tr>
                                <td>System Date</td>
                                <td> {{ $assetSale->created_at }} </td>
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
                        
                        <a href="{{ route('admin.asset.sale.update', [$assetSale->asset_id, $assetSale->id]) }}" class="btn btn-block btn-sm btn-warning mb-3">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


@stop


@push('scripts')
<script>
    
</script>
@endpush

@extends('admin.layouts.master')

@section('title', 'Product Details')

@section('content')

@php
$user_role = App\Models\User::getAuthUserRole();
@endphp

<div class="content-wrapper">
    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.ams.product.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Product Details')) }}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm">
                <div class="card-body py-sm-4">
                    <div class="border-bottom text-center pb-2">
                        <div class="mb-3 border-bottom">
                            <img src="{{ $product->getImage() }}" alt="profile" class="img-fluid mb-3">
                        </div>
                        <div class="mb-3">
                            <h3>{{$product->name}}</h3>
                        </div>
                    </div>

                    <div class="text-center mt-4 border-bottom pb-2">

                        @if($user_role->hasPermission('product_update'))
                        <a href="{{ route('admin.ams.product.edit', $product->id) }}"
                            class="btn btn-sm btn-warning mb-2 mr-2"><i class="fas fa-edit"></i> Edit</a>
                        @endif

                        @if($user_role->hasPermission('product_delete'))
                        <button class="btn btn-sm btn-danger mb-2"
                            onclick="confirmFormModal('{{ route('admin.ams.product.delete', $product->id) }}', 'Confirmation', 'Are you sure to delete operation?')"><i
                                class="fas fa-trash-alt"></i> Delete </button>
                        @endif
                    </div>
                </div>
            </div>


            <div class="card shadow-sm mt-2">
                <div class="card-body py-sm-4">
                    <table class="table org-data-table table-bordered">
                        <tbody>
                            <tr>
                                <td>Status</td>
                                <td>
                                    <span class="badge {{($product->is_active) ? "btn2-secondary" : "btn-secondary"}}">
                                        {{($product->is_active) ? "Active" : "Inactive"}}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>ID</td>
                                <td>{{ $product->id }}</td>
                            </tr>

                            <tr>
                                <td>Category</td>
                                <td>{{ $product->category->name }}</td>
                            </tr>

                            <tr>
                                <td>brand</td>
                                <td>{{ $product->brand }}</td>
                            </tr>

                            <tr>
                                <td>Model</td>
                                <td>{{ $product->model }}</td>
                            </tr>

                            <tr>
                                <td>Operator</td>
                                <td>{{ $product->operator->getFullNameAttribute() }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p>{{ $product->description }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<common-update-password></common-update-password>

@stop

@push('scripts')
@endpush
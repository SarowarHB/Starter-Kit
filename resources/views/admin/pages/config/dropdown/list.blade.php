@extends('admin.layouts.master')

@php
    $user_role = App\Models\User::getAuthUserRole();
@endphp
@section('title', 'Manage Dropdown List')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">DROPDOWN LIST</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <table id="dataTable" class="table display nowrap table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                        </tr>
                        </thead>
                        <tbody>
                            @php $sn = 1; @endphp
                            @foreach(\App\Library\Enum::getConfigDropdown() as $key => $value)
                            <tr>
                                <td>{{ $sn++ }}</td>
                                <td>
                                    <a class="text-primary fs-1" href="{{ $user_role->hasPermission('config_dropdown_index') ? route('admin.config.dropdown.index', $key) : '#' }}">{{ $value }}</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')

@push('scripts')
    @vite('resources/admin_assets/js/pages/config/dropdown/list.js')
@endpush

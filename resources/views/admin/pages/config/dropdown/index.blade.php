@extends('admin.layouts.master')

@php
    $dropdown_label = \App\Library\Enum::getConfigDropdown($dropdown);
    $user_role = App\Models\User::getAuthUserRole();
@endphp

@section('title', "Manage $dropdown_label")

@section('content')

<div class="content-wrapper">

    <div class="row content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.config.dropdown.menu')) !!}
        <div class="d-block">
            <h4 class="content-title" style="text-transform: uppercase">{{ $dropdown_label }}</h4>
        </div>
        
    </div>
    <div class="row">
        <div class="col-sm-6 ">
            <div class="card shadow-sm">
                <div class="card-body">
                     <table class="table table-bordered" id="dropdownTable">
                         <thead>
                         <tr>
                             <th class="text-center" width="100px">#</th>
                             <th>Name</th>
                             <th class="text-center" width="120px">Action</th>
                         </tr>
                         </thead>
                         <tbody>
                         @foreach ($data as $key => $value)
                             <tr>
                                 <td class="text-center"  style="max-width: 30px;">{{ $key + 1 }}</td>
                                 <td>{{ $value }}</td>
                                 <td class="text-center" style="display: flex;">
                                     <div class="action dropdown">
                                         <button class="btn btn2-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                             <i class="fas fa-tools"></i> Action
                                         </button>
                                         <div class="dropdown-menu">
                                            @if($user_role->hasPermission('config_dropdown_update'))
                                                <a class="dropdown-item text-secondary" href="javascript:void(0)" onclick="clickEditAction('{{ $key }}', '{{ $value }}')" ><i class="far fa-edit"></i> Edit</a>
                                            @endif
                                            @if($user_role->hasPermission('config_dropdown_delete'))
                                                <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="confirmModal(deleteDropdown, '{{ $key }}', 'Are you sure to delete operation?')" ><i class="far fa-trash-alt"></i> Delete</a>
                                            @endif
                                         </div>
                                     </div>
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

@include('admin.pages.config.dropdown.partial.modal_create')
@include('admin.pages.config.dropdown.partial.modal_update')

@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')

@push('scripts')
    <script>
        window.dropdown_key = '{{ $dropdown }}';
    </script>

    @vite('resources/admin_assets/js/pages/config/dropdown/index.js')
@endpush

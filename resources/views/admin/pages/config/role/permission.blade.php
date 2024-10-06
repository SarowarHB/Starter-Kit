@extends('admin.layouts.master')

@section('title', 'Role Permissions')

@section('content')

@php
    $user_role = App\Models\User::getAuthUser()->roles()->first();
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.config.role.index')) !!}
        <div class="d-block">
            <h4 class="content-title">ROLE PERMISSIONS</h4>
        </div>
       
    </div>
    <form action="{{ route('admin.config.role.permission.update', $role->id) }}" method="post">
        @csrf
        <div class="card mb-4 shadow-sm">
            <div class="card-body d-flex justify-content-between py-2">
                <h4 class="my-3 pl-3" style="padding-top: 7px;"><i class="fas fa-unlock-alt"></i> {{ ucwords($role->name) }} </h4>
                <div>
                    @if($user_role->hasPermission('role_permission_update'))
                        {!! \App\Library\Html::btnSubmit('btn-sm') !!}
                    @endif
                </div>
            </div>
        </div>


        <div class="row">
            @foreach($all_permissions as $group => $permissions)
                <div class="col-sm-2 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header d-inline-flex justify-content-between"><span>{{ ucwords(str_replace('_', ' ', $group)) }}</span> <input class="check-all" type="checkbox"></div>
                        <div class="card-body">
                            @foreach($permissions as $permission)

                                <div class="form-check">
                                    <input name="permission_ids[]" id="permission_{{ $permission->id }}" class="form-check-input ml-0" type="checkbox" value="{{ $permission->id }}" {{ in_array($permission->id, $role_permissions) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>

                            @endforeach
                            @if($group == 'user')
                                <span style="font-size: 0.8rem;color:#176e39;">Common Operation for Employee / Member</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </form>
</div>

@stop

@push('scripts')
    <script>
        $(document).ready(function (){
            $("input[type='checkbox'].check-all").click(function(){
                let t = $(this);
                if(t.prop("checked") == true){
                    t.parents('.card').find(".card-body").find("input[type='checkbox']").prop("checked", true);
                }
                else{
                    t.parents('.card').find(".card-body").find("input[type='checkbox']").prop("checked", false);
                }
            });
        })

    </script>
@endpush

@extends('admin.layouts.master')

@section('title', __('Profile'))

@section('content')

@php
    $user_role = App\Models\User::getAuthUser()->roles()->first();
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ __('My Profile') }}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body py-sm-4">
                    <div class="border-bottom text-center pb-2">
                        <div class="mb-3 border-bottom">
                            <img src="{{ \App\Models\Employee::getAuthProfileImage() }}" alt="profile" class="img-lg rounded-circle mb-3">
                        </div>
                        <div class="mb-3">
                            <h3>{{ $user->getFullNameAttribute() }}</h3>
                            <div class="d-flex align-items-center justify-content-center">
                                <h5 class="mb-0 me-2 text-muted">{{ $user->country }}</h5>
                            </div>
                        </div>
                        <p class="mx-auto mb-2">{{ $employee ? $employee->about_me : 'N/A' }}</p>
                    </div>

                    <div class="text-center mt-4">
                        @if($user_role->hasPermission('profile_update_password'))
                            <a href="{{ route('admin.profile.update_password') }}" class="btn btn-sm btn2-light-secondary mb-2 mr-2">
                                <i class="fas fa-key"></i> Update Password
                            </a>
                        @endif

                        @if($user_role->hasPermission('profile_update'))
                            <a href="{{ route('admin.profile.update') }}" class="btn btn-sm btn-warning mb-2 mr-2">
                                <i class="fas fa-edit"></i> Edit Profile
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table org-data-table table-bordered">
                        <tbody>
                        <tr>
                            <td>Status</td>
                            <td>
                                <span class="badge {{ $user->is_active == 1 ? 'btn-success' : 'btn-warning'}}">
                                    {{ $user->is_active == 1 ? "Active" : "Inactive" }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Date Of Birth</td>
                            <td> {{ $employee ? $employee->dob : 'N/A' }} </td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td> {{ $employee ? $employee->mobile : 'N/A' }} </td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td> {{ $user->email }} </td>
                        </tr>
                        <tr>
                            <td>Designation</td>
                            <td> {{ $employee ? ucwords($employee->designation) : 'N/A'}} </td>
                        </tr>
                        <tr>
                            <td>Type</td>
                            <td> {{ $employee ? ucwords($employee->emp_type) : 'N/A' }} </td>
                        </tr>
                        <tr>
                            <td style="width:30%;">Address</td>
                            <td style="white-space: unset;"> {{ $employee ? $employee->getFullAddressAttribute() : 'N/A' }} </td>
                        </tr>
                        <tr>
                            <td>Joined At</td>
                            <td> {{ $employee ? $employee->created_at->format('d-m-Y H:i a') : "--:--:--" }} </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

@include('admin.components.update_password')

@stop

@include('admin.assets.dt')

@push('scripts')

<script type="text/javascript">

</script>
@endpush

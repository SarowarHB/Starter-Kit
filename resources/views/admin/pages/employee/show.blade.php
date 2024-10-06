@extends('admin.layouts.master')

@section('title', 'Employee Details')

@section('content')

@php
    $user_role = App\Models\User::getAuthUserRole();
@endphp

<div class="content-wrapper">
    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.employee.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Employee Details')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <ul class="nav nav-tabs" id="tabMenu" role="tablist">
                <li class="nav-item">
                    <a  class="nav-link default"  data-toggle="tab" href="#tab-home" role="tab" aria-controls="One" aria-selected="true">Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"  data-toggle="tab" href="#tab-attendance" role="tab" aria-controls="Two" aria-selected="false">Attendance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"  data-toggle="tab" href="#tab-payslip" role="tab" aria-controls="Two" aria-selected="false">Pay Slip</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"  data-toggle="tab" href="#tab-econtact" role="tab" aria-controls="Two" aria-selected="false">Emergency Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"  data-toggle="tab" href="#tab-assign_stock" role="tab" aria-controls="Two" aria-selected="false">Assigned Stock</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content mt-4" id="tabContent">
        <!-- Home -->
        <div class="tab-pane fade"  id="tab-home" role="tabpanel" aria-labelledby="tab-home">
            <div class="row">
                <div class="col-md-5 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body py-sm-4">
                            <div class="border-bottom text-center pb-2">
                                <div class="mb-3 border-bottom">
                                    <img src="{{ $employee->getProfileImage() }}" alt="profile" class="img-lg rounded-circle mb-3">
                                </div>
                                <div class="mb-3">
                                    <h3>{{$employee->user->getFullNameAttribute()}}</h3>
                                </div>
                                <p class="mx-auto mb-2">{{$employee->about_me}}</p>
                            </div>

                            <div class="text-center mt-4">
                                @php $user = $employee->user; @endphp

                                @if($user_role->hasPermission('user_update_status'))
                                    <button class="btn btn-sm mb-2 mr-2 {{ $user->is_active ? 'btn-secondary' : 'btn2-secondary' }}"
                                            onclick="confirmFormModal('{{ route('admin.user.update_status.api', $user->id) }}', 'Confirmation', 'Are you sure to change status?')"><i class="fas fa-power-off"></i> {{ $user->is_active ? 'Inactive' : 'Active' }} </button>
                                @endif

                                @if($user_role->hasPermission('user_update_password'))
                                    <button class="btn btn-sm mb-2 mr-2 btn2-light-secondary"
                                            onclick="bus.emit('common-update-password', {{ $employee->user_id }})" ><i class="fas fa-edit"></i> Password</button>
                                @endif

                                @if($user_role->hasPermission('employee_update'))
                                    <a href="{{ route('admin.employee.update', $employee->id) }}" class="btn btn-sm btn-warning mb-2 mr-2"><i class="fas fa-edit"></i> Edit</a>
                                @endif

                                @if($user_role->hasPermission('user_delete'))
                                    <button class="btn btn-sm btn-danger mb-2"
                                            onclick="confirmFormModal('{{ route('admin.user.delete.api', $user->id) }}', 'Confirmation', 'Are you sure to delete operation?')"><i class="fas fa-trash-alt"></i> Delete </button>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-7 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <table class="table org-data-table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Status</td>
                                        <td>
                                            <span class="badge {{($employee->user->is_active) ? "btn2-secondary" : "btn-secondary"}}">
                                                {{($employee->user->is_active) ? "Active" : "Inactive"}}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr><td>ID</td><td>{{ $employee->user->id }}</td></tr>
                                    <tr>
                                        <td>Date Of Birth</td>
                                        <td> {{$employee->dob}} </td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td> {{$employee->mobile}} </td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td> {{$employee->user->email}} </td>
                                    </tr>
                                    <tr>
                                        <td>Type</td>
                                        <td> {{ \App\Library\Enum::getEmployeeType($employee->emp_type) }} </td>
                                    </tr>

                                    <tr>
                                        <td>Role</td>
                                        <td> {{ $employee->user->role()->name }} </td>
                                    </tr>

                                    <tr>
                                        <td style="width:30%;">Address</td>
                                        <td style="white-space: unset;"> {{$employee->getFullAddressAttribute()}} </td>
                                    </tr>
                                    <tr>
                                        <td>Joined At</td>
                                        <td> {{ $employee->created_at->format('d-m-Y H:i a') }} </td>
                                    </tr>

                                    <tr>
                                        <td>Roles</td>
                                        <td>
                                            @foreach($employee->user->getRole() as $key => $value)
                                                <span class="badge btn2-secondary mr-2">{{ $value->name }}</span>
                                            @endforeach
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade"  id="tab-attendance" role="tabpanel" aria-labelledby="tab-donations">
            <h5 class="card-title">Attendance</h5>
        </div>

        <div class="tab-pane fade"  id="tab-payslip" role="tabpanel" aria-labelledby="tab-donations">
            <h5 class="card-title">Pay Slip</h5>
        </div>

        <div class="tab-pane fade"  id="tab-econtact" role="tabpanel" aria-labelledby="tab-donations">
            @include('admin.pages.emergency_contact.emergency_contact')
        </div>

        <div class="tab-pane fade"  id="tab-assign_stock" role="tabpanel" aria-labelledby="tab-donations">
            @include('admin.pages.employee.partials.assign_stock')
        </div>

    </div>

</div>

<common-update-password></common-update-password>

@stop

@include('admin.pages.member.partials.modal_change_status')
@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/admin_assets/js/pages/member/show.js')
@endpush


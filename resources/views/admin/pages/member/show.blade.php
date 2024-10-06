@extends('admin.layouts.master')

@section('title', 'Member Details')

@section('content')

@php
    $user_role = App\Models\User::getAuthUser()->roles()->first();
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.member.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Member Details')) }}</h4>
        </div>
    </div>

    @php $user = $member->user; @endphp

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <ul class="nav nav-tabs" id="tabMenu" role="tablist">
                <li class="nav-item">
                    <a  class="nav-link default"  data-toggle="tab" href="#tab-home" role="tab" aria-controls="One" aria-selected="true">Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"  data-toggle="tab" href="#tab-campaigns" role="tab" aria-controls="Two" aria-selected="false">Payments</a>
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
                <div class="col-md-5 pb-4">
                    <div class="card shadow-sm">
                        <div class="card-body py-sm-4">
                            <div class="border-bottom text-center pb-2">
                                <div class="mb-3 border-bottom">
                                    <img src="{{ $member->getProfileImage() }}" alt="profile" class="img-lg rounded-circle mb-3">
                                </div>
                                <div class="mb-3">
                                    <h3>{{ $user->full_name }}</h3>
                                </div>
                                <p class="mx-auto mb-2">{{ $member->about_me }}</p>
                            </div>
                            <div class="text-center mt-4">
                                @if($user_role->hasPermission('transaction_create_deposit'))
                                <form action="{{ route('admin.transaction.manual.deposit') }}" method="get" style="display: inline-block;">
                                    <input type="hidden" name="did" value="{{ $member->user_id }}">
                                    <button type="submit" class="btn btn-sm btn-warning mb-2 mr-2">
                                        <i class="fas fa-edit"></i> Make Deposit
                                    </button>
                                </form>
                                @endif
                                @if($user_role->hasPermission('user_update_status'))
                                    <button class="btn btn-sm mb-2 mr-2 {{ $user->is_active ? 'btn-secondary' : 'btn2-secondary' }}"
                                            onclick="confirmFormModal('{{ route('admin.user.update_status.api', $user->id) }}', 'Confirmation', 'Are you sure to change status?')"><i class="fas fa-power-off"></i> {{ $user->is_active ? 'Inactive' : 'Active' }} </button>
                                @endif

                                @if($user_role->hasPermission('user_update_password'))
                                    <button class="btn btn-sm mb-2 mr-2 btn2-light-secondary"
                                            onclick="bus.emit('common-update-password', {{ $user->id }})" ><i class="fas fa-edit"></i> Password</button>
                                @endif

                                @if($user_role->hasPermission('member_update'))
                                    <a href="{{ route('admin.member.update', $member->id) }}" class="btn btn-sm btn-warning mb-2 mr-2"><i class="fas fa-edit"></i> Edit</a>
                                @endif

                                @if($user_role->hasPermission('user_delete'))
                                    <button class="btn btn-sm mb-2 mr-2 btn-danger"
                                            onclick="confirmFormModal('{{ route('admin.user.delete.api', $user->id) }}', 'Confirmation', 'Are you sure to delete operation?')"><i class="fas fa-trash-alt"></i> Delete </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card shadow-sm">
                        <div class="card-body py-4">
                            <table class="table org-data-table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Status</td>
                                        <td>
                                        <span class="badge {{($user->is_active) ? "btn2-secondary" : "btn-secondary"}}">
                                            {{ ($user->is_active) ? "Active" : "Inactive" }}
                                        </span>
                                        </td>
                                    </tr>
                                    <tr><td>ID</td><td>{{ $member->user->id }}</td></tr>
                                    <tr>
                                        <td>Date Of Birth</td>
                                        <td> {{ $member->dob }} </td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td> {{ $member->mobile }} </td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td> {{ $user->email }} </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('nid_image') }}</td>
                                        <td>  <img src="{{ $member->getNIDImage() }}" alt="photo_id" class="img-nid"> </td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%;">Address</td>
                                        <td style="white-space: unset;"> {{ $member->full_address }} </td>
                                    </tr>
                                    <tr>
                                        <td>Joined At</td>
                                        <td> {{ $member->created_at->format('d-m-Y H:i a') }} </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade"  id="tab-econtact" role="tabpanel" aria-labelledby="tab-donations">
            @include('admin.pages.emergency_contact.emergency_contact')
        </div>

        <div class="tab-pane fade"  id="tab-assign_stock" role="tabpanel" aria-labelledby="tab-donations">
            @include('admin.pages.member.partials.assign_stock')
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

@extends('admin.layouts.master')

@section('title', 'All Notifications')

@section('content')

@php
    $user_role = App\Models\User::getAuthUser()->roles()->first();
    $hasPermission = $user_role->hasPermission('notification_create');
@endphp


<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Notifications' )) }}</h4>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">

            <table id="dataTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Message</th>
                        <th>Subject</th>
                        <th>Send Date</th>
                        <th>Created At</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notifications as $key => $notification)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ substr($notification->message, 0, 50) }} ... </td>
                            <td>{{ $notification->subject }}</td>
                            <td>{{ $notification->send_date ? $notification->send_date : "N/A" }}</td>
                            <td>{{ $notification->created_at }}</td>
                            <td>
                                <div class="action dropdown">
                                    <button class="btn btn2-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-tools"></i> Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item text-primary" href="javascript:void(0)" onclick="showViewModal( '{{$notification->message}}', '{{$notification->type}}' )" ><i class="fas fa-eye"></i> View </a>
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
@stop
@include('admin.pages.notification.partials.modal_show_notification')
@include('admin.assets.dt')
@include('admin.assets.dt-buttons')

@push('scripts')
@vite('resources/admin_assets/js/pages/profile/all_nofification.js')
@endpush
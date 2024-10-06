@extends('admin.layouts.master')

@section('title',  settings('app_title') ? settings('app_title') : 'Sarowar SK')

@push('styles')
<style>
    .background-primary {
        background: #4ACE8B !important;
    }

    .card .card-body {
        padding: 0 1.25rem 1.25rem;
    }
</style>
@endpush

@section('content')

<div class="content-wrapper">
    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title text-blod" style="font-size: 20px;">DASHBOARD</h4>
        </div>
    </div>

    <div class="row">
        {{-- Member --}}
        <div class="col-lg-4 stretch-card mb-3">
            <div class="card">
                <div class="card-body">
                    <div style="font-size: 15px; font-weight: bold;" class="table-responsive pt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center text-white background-primary">
                                    <th colspan="2" style="font-size: 20px; font-weight: bold;">
                                        Member
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach(\App\Library\Enum::getUserStatus() as $key => $value)
                                <tr style="font-size: 15px; font-weight: bold;"
                                    class="table-{{ \App\Library\Helper::getColorClass($value) }}">
                                    <td>
                                        {{ \App\Library\Enum::getUserStatus($key) }}
                                    </td>
                                    <td>
                                        {{  isset($member[$key]) ? $member[$key] : 0 }}
                                    </td>
                                </tr>
                                @endforeach

                                <tr style="font-size: 15px; font-weight: bold;" class="table-danger">
                                    <td>
                                        Deleted
                                    </td>
                                    <td>
                                        {{ $deletedMember }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Employee --}}
        <div class="col-lg-4 stretch-card mb-3">
            <div class="card">
                <div class="card-body">
                    <div style="font-size: 15px; font-weight: bold;" class="table-responsive pt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center text-white background-primary">
                                    <th colspan="2" style="font-size: 20px; font-weight: bold;">
                                        Employee
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach(\App\Library\Enum::getUserStatus() as $key => $value)
                                <tr style="font-size: 15px; font-weight: bold;"
                                    class="table-{{ \App\Library\Helper::getColorClass($value) }}">
                                    <td>
                                        {{ \App\Library\Enum::getUserStatus($key) }}
                                    </td>
                                    <td>
                                        {{  isset($employee[$key]) ? $employee[$key] : 0 }}
                                    </td>
                                </tr>
                                @endforeach

                                <tr style="font-size: 15px; font-weight: bold;" class="table-danger">
                                    <td>
                                        Deleted
                                    </td>
                                    <td>
                                        {{ $deletedEmployee }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ticket --}}
        <div class="col-lg-4 stretch-card mb-3">
            <div class="card">
                <div class="card-body">
                    <div style="font-size: 15px; font-weight: bold;" class="table-responsive pt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center text-white background-primary">
                                    <th colspan="2" style="font-size: 20px; font-weight: bold;">
                                        Ticket Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach(\App\Library\Enum::getTicketStatus() as $key => $value)
                                <tr style="font-size: 15px; font-weight: bold;"
                                    class="table-{{ \App\Library\Helper::getColorClass($value) }}">
                                    <td>
                                        {{ \App\Library\Enum::getTicketStatus($key) }}
                                    </td>
                                    <td>
                                        {{  isset($ticket[$key]) ? $ticket[$key] : 0 }}
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
</div>
@stop

@include('admin.assets.chart')

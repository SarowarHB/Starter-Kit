@extends('admin.layouts.master')

@section('title', 'Activity Logs')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Activity Logs')) }}</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <table id="dataTable" class="table table-bordered ">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Date & Time</th>
                        <th>Operation</th>
                        <th>Model</th>
                        <th>Record Id</th>
                        <th>Details</th>
                        <th>Action By</th>
                        <th>User Type</th>
                        <th>Ip</th>
                        <th>Browser</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

  <!-- Modal -->
<div class="modal fade" id="activityLogModal" tabindex="-1" role="dialog" aria-labelledby="activityLogModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content" style="width: 65%; margin: 0 auto;">
        <div class="modal-body" style="padding-bottom: 0;">
            <table class="table table-bordered">
                <thead id="logTableHead">
                </thead>
                <tbody id="logTableBody">
                </tbody>
              </table>
        </div>
        <div class="modal-footer" style="border: none; margin: 0 auto">
          <button type="submit" class="btn btn2-secondary" data-dismiss="modal"><i class="fas fa-close"></i> Close</button>
        </div>
      </div>
    </div>
</div>
@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/admin_assets/js/pages/logs/activity_log.js')
@endpush

@push('styles')
    <style>
        #activityLogModal td{
            white-space: inherit !important;
        }
    </style>
@endpush


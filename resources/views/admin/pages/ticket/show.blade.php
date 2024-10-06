@extends('admin.layouts.master')

@section('title', __('Ticket Reply'))

@section('content')

@php
$user_role = App\Models\User::getAuthUser()->roles()->first();
$user_type = App\Models\User::getAuthUser()->user_type;
@endphp

<div class="content-wrapper">
    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.ticket.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Ticket Reply')) }}</h4>
        </div>

    </div>
    <div class="row">
        <div class="col-md-4 pb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="p-3">
                        <p class="clearfix">
                            <span class="float-left">
                                Submitted
                            </span>
                            <span class="float-right text-muted">
                                {{ $ticket->created_at->format('d-m-Y H:i a') }}
                            </span>
                        </p>
                        <hr>
                        <p class="clearfix">
                            <span class="float-left">
                                Contact
                            </span>
                            <span class="float-right text-muted">
                                {{ $ticket->full_name }}
                            </span>
                        </p>
                        <hr>
                        <p class="clearfix">
                            <span class="float-left">
                                Status
                            </span>
                            <span class="float-right text-muted">
                                @if($ticket->status == \App\Library\Enum::TICKET_STATUS_OPEN)
                                <span class="badge btn-success">Open</span>
                                @elseif($ticket->status == \App\Library\Enum::TICKET_STATUS_HOLD)
                                <span class="badge btn-warning">Hold</span>
                                @elseif($ticket->status == \App\Library\Enum::TICKET_STATUS_CLOSED)
                                <span class="badge btn-danger">Closed</span>
                                @endif

                                @if($user_role->hasPermission('ticket_change_status'))
                                <a href="javascript:void(0)" onclick="clickUpdateStatus()">
                                    <i class="ti-pencil-alt text-primary pl-3"></i>
                                </a>
                                @endif
                            </span>
                        </p>
                        <hr>
                        <p class="clearfix">
                            <span class="float-left">
                                Priority
                            </span>
                            <span class="float-right text-muted">
                                {{ App\Library\Enum::getTicketPriority($ticket->priority) }}
                            </span>
                        </p>
                        <hr>
                        <p class="clearfix">
                            <span class="float-left">
                                Department
                            </span>
                            <span class="float-right text-muted">
                                {{ ucwords($ticket->department) }}
                            </span>
                        </p>
                        <hr>

                        <p class="clearfix">
                            <span class="float-left">
                                Assign To
                            </span>
                            <span class="float-right text-muted">
                                <span
                                    id="assign_to_name">{{ $ticket->assign_to_id != null ? $ticket->employee->full_name : 'N/A' }}
                                </span>

                                @if($user_role->hasPermission('ticket_assignee'))
                                <a href="javascript:void(0)" onclick="clickUpdateAssignAction()">
                                    <i class="ti-pencil-alt text-primary pl-3"></i>
                                </a>
                                @endif
                            </span>
                        </p>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm {{ $ticket->status == App\Library\Enum::TICKET_STATUS_CLOSED ? 'd-none' : '' }}">
                <div class="card-body">
                    <div class="add-items mb-0">
                        <form class="mb-0" action="{{ route('admin.ticket.reply', $ticket->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row @error('comment') error @enderror">
                                        <div class="col-sm-12">
                                            <textarea style="line-height: inherit;" type="text" id="ticketMessage"
                                                class="form-control todo-list-input" name="comment" rows="10"
                                                placeholder="Add Reply Text">{{ old('comment') }}</textarea>
                                            @error('comment')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                @if($user_type ==  App\Library\Enum::USER_TYPE_ADMIN)
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label required">{{ __('Solution Time') }}</label>
                                        <div class="col-sm-2 col-6 @error('hour') error @enderror">
                                            <input type="number" name="hour" value="{{ old('hour') }}" class="form-control" placeholder="Hour">
                                            @error('hour')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-sm-2 col-6 @error('minute') error @enderror">
                                            <input type="number" name="minute" value="{{ old('minute') }}" class="form-control" placeholder="Min">
                                            @error('minute')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="col-md-12">

                                    @if($user_role->hasPermission('ticket_reply'))
                                    @if($ticket->status != App\Library\Enum::TICKET_STATUS_CLOSED)
                                    <button type="submit" class="btn btn-sm btn2-secondary text-white ml-0">
                                        <i class="ti-share-alt text-white me-1"></i> Reply
                                    </button>
                                    <button type="button" class=" btn btn-sm btn2-light-secondary" id="fileButton">
                                        <i class="ti-clip me-1"></i>Attach
                                    </button>
                                    @else
                                    <a href="{{ route( 'admin.ticket.reopen',  $ticket->id ) }}"
                                        class="edit btn btn-sm btn-info pr-2"> <i class="fas fa fa-envelope-open"></i>
                                        Reopen </a>
                                    <button type="button" class=" btn btn-sm btn2-light-secondary" id="fileButton">
                                        <i class="ti-clip me-1"></i>Attach
                                    </button>
                                    @endif
                                    @endif

                                    <span id="fileName"></span>
                                    <input name="attachment" type="file" id="fileOpen"
                                        class="form-control @error('attachment') error @enderror d-none">
                                    @error('attachment')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @foreach($ticket_assigns as $assign)

            @php
            $replies = App\Models\TicketReply::where('ticket_assign_id', $assign->id)->orderBy('id', 'desc')->get();
            @endphp

            @foreach($replies as $key => $reply)
            <div class="card mt-4 shadow-sm">
                <div class="card-body">
                    <div class="col-md-12 pl-1">
                        <div class="row">
                            <div class="col-sm-3">
                                <h5>{{$reply->user_name}}</h5>
                                <p class="mb-3">
                                    {{ ucwords($reply->user->user_type) }}
                                </p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-3">
                                    {{ App\Library\Helper::replaceWithUrl(nl2br($reply->comment)) }}
                                </p>
                                <p class="mb-1 @if($reply->attachment == null) d-none @endif">
                                    Attachment: <a href="{{ asset($reply->attachment) }}" download class="mb-1">
                                        <i class="fas fa-download"></i> Download</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer 1">
                @if($user_type ==  App\Library\Enum::USER_TYPE_ADMIN)
                    <small class="float-left">Solution Time: {{ $reply->solution_time }} Min</small>
                @endif
                    <small class="float-right">Replied: {{ date('Y-m-d H:i', strtotime($reply->created_at)) }}</small>
                </div>
            </div>
            @endforeach

            <div class="card mt-4 shadow-sm bg-light-secondary">
                <div class="card-body">
                    <div class="col-md-12 pl-1">
                        <div class="row">
                            <div class="col-sm-3">
                                <h5>{{$assign->assigned_by_name}}</h5>
                                <p> Assignend To </p>
                                <h5 class="mb-3">
                                    {{$assign->assign_to_name}}
                                </h5>
                            </div>
                            <div class="col-sm-9">

                                <p class="mb-3">
                                    {{ $assign->notes }}
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <small class="float-right">Assigned: {{ date('Y-m-d H:i', strtotime($assign->created_at)) }}</small>
                </div>
            </div>

            @endforeach

            <div class="card mt-4 shadow-sm">
                <div class="card-header">Ticket</div>
                <div class="card-body">
                    <div class="col-md-12 pl-1">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6>{{$ticket->full_name}}</h6>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-3">
                                    {{  App\Library\Helper::replaceWithUrl($ticket->message) }}
                                </p>
                                <p class="mb-1 @if($ticket->attachment == null) d-none @endif">
                                    Attachment: <a href="{{asset($ticket->attachment)}}" download class="mb-1">
                                        <i class="fas fa-download"></i> Download</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.pages.ticket.partial.modal_update_assign')
@include('admin.pages.ticket.partial.modal_update_status')
@include('admin.assets.summernote-text-editor')

@stop

@push('scripts')
@vite('resources/admin_assets/js/pages/ticket/show.js')
@endpush
<?php

namespace App\Http\Controllers\Admin;

use App\Library\Enum;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ticket\ReplyRequest;
use App\Http\Requests\Admin\Ticket\CreateRequest;
use App\Http\Requests\Admin\Ticket\UpdateRequest;
use App\Http\Requests\Admin\Ticket\UpdateAssignToRequest;
use App\Library\Services\Admin\ConfigService;
use App\Http\Traits\ApiResponse;
use App\Library\Services\Admin\EmployeeService;
use App\Library\Services\Admin\MemberService;
use App\Library\Services\Admin\TicketService;

class TicketController extends Controller
{
    use ApiResponse;

    private $ticket_service;

    function __construct(TicketService $ticket_service)
    {
        $this->ticket_service = $ticket_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->ticket_service->dataTable($request->status);
        }
        $count_total = $this->ticket_service->countTicket();

        return view('admin.pages.ticket.index', compact('count_total'));
    }

    public function showCreateForm()
    {
        return view( 'admin.pages.ticket.create', [
            'members'        => MemberService::getByStatus(Enum::USER_STATUS_ACTIVE),
            'organizations' => [],
            'departments'   => ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_TICKET_DEPARTMENT)
        ]);
    }

    public function create(CreateRequest $request)
    {
        $result = $this->ticket_service->createTicket($request->validated());

        if ($result)
            return redirect()->route('admin.ticket.index')->with('success', $this->ticket_service->message);

        return back()->withInput($request->all())->with('error', $this->ticket_service->message);
    }

    public function showUpdateForm(Ticket $ticket)
    {
        abort_unless($ticket , 404);
        return view('admin.pages.ticket.update',[
            'ticket'      => $ticket,
            'members'        => MemberService::getByStatus(Enum::USER_STATUS_ACTIVE),
            'departments'   => ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_TICKET_DEPARTMENT)
        ]);
    }

    public function update(Ticket $ticket, UpdateRequest $request)
    {
        abort_unless($ticket->user , 404);
        $result = $this->ticket_service->updateTicket($ticket, $request->validated());
        if($result)
            return redirect()->route('admin.ticket.show', $ticket->id)->with('success', $this->ticket_service->message);

        return back()->withInput($request->all())->with('error', $this->ticket_service->message);
    }

    public function show(Ticket $ticket)
    {
        return view( 'admin.pages.ticket.show', [
            'assigns'       => $ticket->assign('desc')->get(),
            'employees'     => EmployeeService::getByStatus(Enum::USER_STATUS_ACTIVE),
            'ticket'        => $ticket,
            'ticket_assigns' => $ticket->assign('desc')->get(),
        ]);
    }

    public function reply(Ticket $ticket, ReplyRequest $request)
    {
        $result = $this->ticket_service->replyTicket( $ticket, $request->validated() );

        if ($result)
            return redirect()->route( 'admin.ticket.show', $ticket->id )->with('success', $this->ticket_service->message);

        return back()->withInput($request->all())->with('error', $this->ticket_service->message);
    }

    public function changeAssignee(Ticket $ticket, UpdateAssignToRequest $request)
    {
        $result = $this->ticket_service->ticketChangeAssignee( $ticket, $request->validated() );
        
        if ($result)
            return redirect()->route('admin.ticket.index')->with('success', $this->ticket_service->message);

        return back()->withInput($request->all())->with('error', $this->ticket_service->message);
    }

    public function changeStatus(Ticket $ticket, Request $request)
    {
        $result = $this->ticket_service->ticketChangeStatus( $ticket, $request->all() );
        if ($result)
            return redirect()->route('admin.ticket.show',$ticket->id)->with('success', $this->ticket_service->message);

        return back()->withInput($request->all())->with('error', $this->ticket_service->message);
    }

    public function reOpen(Ticket $ticket)
    {
        $result = $this->ticket_service->ticketReOpen( $ticket );
        if ($result)
            return redirect()->route('admin.ticket.show',$ticket->id)->with('success', $this->ticket_service->message);

        return back()->with('error', $this->ticket_service->message);
    }

}

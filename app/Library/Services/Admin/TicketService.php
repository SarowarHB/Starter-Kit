<?php


namespace App\Library\Services\Admin;

use App\Events\Ticket\CreatedEvent;
use App\Events\Ticket\RepliedEvent;
use App\Events\Ticket\AssignedEvent;
use App\Library\Enum;
use App\Library\Helper;
use App\Models\Ticket;
use App\Models\TicketAssign;
use App\Models\TicketReply;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TicketService extends BaseService
{

    private function filter(string $status = null)
    {
        $authUser = User::getAuthUser();
        $authUserRole = $authUser->roles->first()->slug;
        $query = Ticket::query();
        if($authUserRole != Enum::ROLE_ADMIN_SLUG){
            $query->where('assign_to_id', $authUser->id);
        }
        if($status){
            $query->where('status', $status);
        }
        return $query->get();
    }


    private function actionHtml($row)
    {
        $user_role = User::getAuthUserRole();

        if($row->status != Enum::TICKET_STATUS_CLOSED && $user_role->hasPermission('ticket_reply'))
        {
            $route = ($row->created_by == User::getAuthUser()->id ) ? route( 'admin.ticket.update',  $row->id ) : '#' ;
            $btn = '<div class="action dropdown">
                    <button class="btn btn2-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <i class="fas fa-tools"></i> Action
                    </button>
                    <div class="dropdown-menu">
                        <a href="' . route( 'admin.ticket.show',  $row->id ) . '" class="dropdown-item text-primary"> <i class="fas fa-reply"></i> Reply </a>
                        <a href="' . $route . '" class="dropdown-item text-secondary"> <i class="far fa-edit"></i> Edit</a>
                    </div>
                </div>';
        }
        else if( $row->status == Enum::TICKET_STATUS_CLOSED && User::getAuthUser()->roles->first()->slug == Enum::ROLE_ADMIN_SLUG && $user_role->hasPermission('ticket_reopen')){
            $btn = '<a href="' . route( 'admin.ticket.reopen',  $row->id ) . '" class="edit btn btn-sm btn-info pr-2"> <i class="fas fa fa-envelope-open"></i> Reopen </a>';
        }
        else{
            $btn = '<a href="javascript:void(0)" class="btn btn-sm btn2-secondary disabled"> <i class="fas fa-reply"></i> Reply </a>';
        }
        return $btn;
    }

    private function statusHtml( $row )
    {
        if($row->status == Enum::TICKET_STATUS_OPEN)
            $class = 'badge-success';
        else if($row->status == Enum::TICKET_STATUS_HOLD)
            $class = 'badge-warning';
        else if($row->status == Enum::TICKET_STATUS_CLOSED)
            $class = 'badge-danger';
        else
            $class = 'badge-secondary';

        return '<div class="badge ' . $class . '">' . Enum::getTicketStatus($row->status) . '</div>';
    }

    public function dataTable(string $status)
    {
        $data = $this->filter($status);
       
        return Datatables::of($data)
                ->addColumn('priority', function($row){
                    return Enum::getTicketPriority($row->priority);
                })

                ->addColumn('subject', function($row){
                    return  '<a href="' . route('admin.ticket.show', $row->id) . '" class="text-success pr-2">'. $row->subject .'</a>';
                })

                ->addColumn('assign_to', function($row){
                    return $row->assign_to_id != null ? $row->employee->full_name : 'N/A';
                })

                ->addColumn('created_by', function($row){
                    return $row->created_by != null ? $row->createBy->full_name : 'N/A';
                })

                ->addColumn('last-reply',  function( $row){
                    $lr = $row->updated_at->diffForHumans();
                    return $lr;
                })
                ->addColumn('status',  function($row){
                    return $this->statusHtml($row);
                })
                ->addColumn('created_at', function($row){
                    return $row->created_at->format('d-m-Y H:i a');
                })
                ->addColumn('action',  function($row){
                    return $this->actionHtml($row);
                })
                ->rawColumns(['action', 'created_at', 'assign_to', 'subject' ,'status'])
                ->make( true );
    }

    public function countTicket()
    {
        $user = User::getAuthUser();
        $user_role = $user->roles->first()->slug;
        $query = Ticket::select('status', DB::raw('count(*) as total'));

        if($user_role != Enum::ROLE_ADMIN_SLUG)
            $query->where('assign_to_id', $user->id);

        $data = $query->groupBy('status')->pluck('total', 'status')->toArray();

        $total = Enum::getTicketStatus();
        foreach($total as $key => $value){
            $total[$key] = $data[$key] ?? 0;
        }
        return $total;
    }

    public function createTicket(array $data): bool
    {
        DB::beginTransaction();
        try{
            $find_user = User::find($data['user_id']);
            $data['full_name'] = $find_user->full_name;

            if(isset($data['attachment'])){
                $data['attachment'] = Helper::uploadFile($data['attachment'], Enum::TICKET_ATTACHMENT_DIR);
            }

            $ticket_data = Ticket::create($data);

            $assign_data['assigned_to'] = User::where('user_type', Enum::USER_TYPE_ADMIN)->first()->id;
            $assign_data['notes'] = "New Ticket Create";

            $ticket_assign_data = $this->ticketChangeAssignee($ticket_data, $assign_data);

            event(new CreatedEvent($ticket_data));

            DB::commit();

            return $this->handleSuccess('Successfully created', $ticket_data);
        }
        catch (Exception $e){
            DB::rollBack();
            return $this->handleException($e);
        }
    }

    public function updateTicket(Ticket $ticket, array $data): bool
    {
        DB::beginTransaction();
        try{
            $find_user = User::find($data['user_id']);
            $data['full_name'] = $find_user->full_name;

            if(isset($data['attachment'])){
                $data['attachment'] = Helper::uploadFile($data['attachment'], Enum::TICKET_ATTACHMENT_DIR);
            }
            $ticket->update($data);

            event(new CreatedEvent($ticket));

            DB::commit();

            return $this->handleSuccess('Successfully created', $ticket);
        }
        catch (Exception $e){
            DB::rollBack();
            return $this->handleException($e);
        }
    }

    public function replyTicket(Ticket $ticket, array $data)
    {
        DB::beginTransaction();
        try{
            $find_user = User::getAuthUser();
            $data['user_id'] = $find_user->id;
            $data['user_name'] = $find_user->full_name;
            $data['is_admin_reply'] = $find_user->user_type == 'admin' ? 1 : 0;
            $data['ticket_assign_id'] = $ticket->assign_id;

            $data['ticket_id'] = $ticket->id;

            if(isset($data['attachment'])){
                $data['attachment'] = Helper::uploadFile($data['attachment'], Enum::TICKET_ATTACHMENT_DIR);
            }
            $ticket_data = TicketReply::create($data);
            event( new RepliedEvent( $ticket_data ) );

            $ticket->updated_at = Carbon::now();
            $ticket->save(); 
            
            DB::commit();  

            return $this->handleSuccess('Successfully Replied', $ticket_data);
        }
        catch (Exception $e){
            DB::rollBack();
            return $this->handleException($e);
        }
    }

    public function ticketChangeAssignee(Ticket $ticket, array $data)
    {
        DB::beginTransaction();
        try {
            $assigner = User::getAuthUser();
            $data['assigned_by'] = $assigner->id;
            $data['assigned_by_name'] = $assigner->full_name;

            $assignee = User::find($data['assigned_to']);
            $data['assign_to_name'] = $assignee->full_name;

            $data['ticket_id'] = $ticket->id;
            $assign_data = TicketAssign::create($data);

            $ticket_data = $ticket->update([
                'assign_to_id'  => $data['assigned_to'],
                'assign_id'     =>  $assign_data->id,
            ]);

            event(new AssignedEvent($ticket));

            DB::commit();

            return $this->handleSuccess('Successfully Updated', $ticket_data);
        }
        catch (Exception $e){
            DB::rollBack();
            return $this->handleException($e);
        }
    }

    public function ticketChangeStatus(Ticket $ticket, array $data)
    {
        try{
            $ticket->update( ['status' => $data['status'],] );
            return $this->handleSuccess('Successfully Updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function ticketReOpen(Ticket $ticket)
    {
        try{
            $this->data = $ticket->update(['status' => Enum::TICKET_STATUS_OPEN]);
            return $this->handleSuccess('Successfully Re-Opened');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

}

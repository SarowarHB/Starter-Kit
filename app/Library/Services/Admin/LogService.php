<?php


namespace App\Library\Services\Admin;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use App\Models\LoginHistory;
use App\Models\EmailHistory;
use App\Models\ActivityLog;
use App\Library\Enum;
use App\Models\User;
use Exception;

class LogService extends BaseService
{
    // Login History Start
    public function loginDataTable()
    {
        $data = LoginHistory::select('*');
        return Datatables::of($data)
            ->addIndexColumn()

            ->addColumn('status', function($row){
                return $row->status == "success" ? '<div class="text-success">'.ucwords($row->status).'</div>' : '<div class="text-danger">'.ucwords($row->status).'</div>';
            })

            ->addColumn('action', function($row){
                $user_role = User::getAuthUserRole();
                $actionHtml = '';
                if($user_role->hasPermission('log_delete_login')){
                    $actionHtml = '<a class="dropdown-item text-primary" href="javascript:void(0)" onclick="confirmModal(deleteLoginHistory, '. $row->id .', \'Are you sure to delete operation?\')" ><i class="far fa-trash-alt"></i> Delete</a>';
                }
                return '<div class="action dropdown">
                            <button class="btn btn2-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3">' . $actionHtml . '</div>
                        </div>';
            })

            ->rawColumns(['status','action'])
            ->make(true);
    }

    public function deleteLogin(LoginHistory $login)
    {
        try{
            $login->delete();
            return $this->handleSuccess('Successfully deleted');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }
    // Login History End

    // Activity log Start
    public function activityDataTable()
    {
        $data = ActivityLog::with('user')->get();
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action_by', function($row){
                    return $row->user ? $row->user->full_name: '';
                })
                ->addColumn('user_type', function($row){
                    return $row->user ? Enum::getUserType($row->user->user_type) : '';
                })
                ->addColumn('event_type', function($row){
                    return $row->action;
                })
                ->addColumn('log_time', function($row){
                    return Carbon::parse($row->log_time)->format('d-m-Y H:i A');
                })
                ->addColumn('details', function($row) {
                    $user_role = User::getAuthUserRole();
                    return $user_role->hasPermission('log_activity_show') ? '<a href="javascript:void(0)" onclick="showActivityLogDetails('. $row->id  .')" ></i> <u>Details</u></a>' : 'Details';
                })
                ->addColumn('action', function($row){
                    $user_role = User::getAuthUserRole();
                    $actionHtml = '';
                    if($user_role->hasPermission('log_activity_delete')){
                        $actionHtml = '<a class="dropdown-item text-primary" href="javascript:void(0)" onclick="confirmModal(deleteActivityLog, '. $row->id .', \'Are you sure to delete operation?\')" ><i class="far fa-trash-alt"></i> Delete</a>';
                    }
                    return '<div class="action dropdown">
                                <button class="btn btn2-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3">' . $actionHtml . '</div>
                            </div>';
                })
                ->rawColumns(['action', 'details'])
                ->make(true);
    }

    public function deleteActivity(ActivityLog $activity)
    {
        try{
            $activity->delete();
            return $this->handleSuccess('Successfully deleted');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }
    // Activity Log End

    // Email History Start
    public function emailDataTable()
    {
        return Datatables::of(EmailHistory::select('*'))
                ->addIndexColumn()

                ->addColumn('created_at', function($row) {
                    return $row->created_at->format('d-m-Y H:i A');
                })

                ->addColumn('action', function($row){
                    $user_role = User::getAuthUserRole();
                    $actionHtml = '';

                    if($user_role->hasPermission('log_email_show')){
                        $actionHtml .= '<a class="dropdown-item text-primary" href="' . route('admin.log.email.show', $row->id) . '" ><i class="fas fa-eye"></i> View</a>';
                    }
                    if($user_role->hasPermission('log_email_delete')){
                        $actionHtml .= '<a class="dropdown-item text-primary" href="javascript:void(0)" onclick="confirmModal(deleteEmailHistory, '. $row->id .', \'Are you sure to delete operation?\')" ><i class="far fa-trash-alt"></i> Delete</a>';
                    }

                    return '<div class="action dropdown">
                                <button class="btn btn2-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3">' . $actionHtml . '</div>
                            </div>';
                })

                ->rawColumns(['action'])
                ->make(true);
    }

    public function deleteEmail(EmailHistory $emailHistory)
    {
        try{
            $emailHistory->delete();
            return $this->handleSuccess('Successfully deleted');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }
    // Email History End

}

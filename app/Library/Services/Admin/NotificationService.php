<?php


namespace App\Library\Services\Admin;

use App\Models\Notification;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class NotificationService extends BaseService
{
    private function filter(array $params)
    {
        $query = Notification::query();
        $query->orderBy('id','desc');

        if(isset($params['is_for_emp'])){
            $query->where('is_for_emp', 1);
        }
        if(isset($params['is_for_member'])){
            $query->where('is_for_member', 1);
        }
        
        return $query->get();
    }

    private function actionHtml($row)
    {
        $user_role = User::getAuthUserRole();
        if($user_role->hasPermission('notification_delete')){
            $actionHtml =  '<a class="dropdown-item text-primary" href="javascript:void(0)" onclick="showViewModal(\'' . $row->message .'\', \'' . $row->subject .'\', \'' . $row->send_date .'\')" ><i class="fas fa-eye"></i> View </a>
                            <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="confirmModal(deleteNotification, '. $row->id .', \'Are you sure to delete operation?\')" ><i class="far fa-trash-alt"></i> Delete </a>';
        }else{
            $actionHtml = '';
        }

        return '<div class="action dropdown">
                    <button class="btn btn2-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <i class="fas fa-tools"></i> Action
                    </button>
                    <div class="dropdown-menu">
                        '.$actionHtml.'
                    </div>
                </div>';
    }

    public function dataTable(array $filter_params)
    {
        $data = $this->filter($filter_params);
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('employee', function($row){
                    return $row->is_for_emp ? '<i class="fas fa-check-circle"></i>' : '';
                })
                ->addColumn('member', function($row){
                    return $row->is_for_member ? '<i class="fas fa-check-circle"></i>' : '';
                })
                ->addColumn('created_at', function($row){
                    return $row->created_at->format('d-m-Y H:i a');
                })
                ->addColumn('message', function($row){
                    return substr($row->message, 0, 50);
                })
                ->addColumn('send_date', function($row){
                    return $row->send_date ? $row->send_date : 'N/A';
                })
                ->addColumn('action', function($row){
                    return $this->actionHtml($row);
                })
                ->rawColumns(['employee', 'member', 'message', 'created_at', 'action'])
                ->make(true);
    }

    public function createNotification(array $data): bool
    {
        try{
            $notification_data = Notification::create($data);
            return $this->handleSuccess('Successfully created', $notification_data);
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function deleteNotification(Notification $notification)
    {
        try{
            $notification_data = $notification;
            $notification->delete();
            return $this->handleSuccess('Successfully deleted', $notification_data);
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public static function updateByType(string $type, array $data)
    {
        return Notification::where('type', $type)->update($data);
    }

}

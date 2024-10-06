<?php

namespace App\Library\Services\Admin;

use App\Library\Enum;
use App\Library\Helper;
use App\Models\Room;
use App\Models\Supplier;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Illuminate\Support\Facades\Hash;

class RoomService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';

        if($row->id){
            $actionHtml = '
            <a class="dropdown-item" href="' . route('admin.ams.room.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>
            <a class="dropdown-item text-danger" href="' . route('admin.ams.room.delete', $row->id) . '" ><i class="fas fa-trash-alt"></i> Delete</a>';
        }
        else{
            $actionHtml = '';
        }

        return '<div class="action dropdown">
                    <button class="btn btn2-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <i class="fas fa-tools"></i> Action
                    </button>
                    <div class="dropdown-menu">
                        '.$actionHtml.'
                    </div>
                </div>';
    }

    private function getSwitch($row){
        $is_check =  $row->is_active  ? "checked" : "";
        $route = "'". route('admin.ams.supplier.change_status', $row->id)."'";

        return '<div class="custom-control custom-switch">
                    <input type="checkbox"
                        onchange="changeStatus(event, '. $route .')"
                        class="custom-control-input"
                        id="primarySwitch_'. $row->id .'" '. $is_check .' >
                    <label class="custom-control-label" for="primarySwitch_'. $row->id .'"></label>
                </div>';
    }

    public function dataTable()
    {
        $query = Room::select('*');
        $data = $query->get();

        return Datatables::of($data)
                ->addIndexColumn()

                ->editColumn('user_id', function($row){
                    return $row->user->f_name;
                })

                ->editColumn('operator', function($row){
                    return $row->operator->getFullNameAttribute();
                })
                
                ->addColumn('action', function($row){
                    return $this->actionHtml($row);
                })

                ->editColumn('responsible', function($row){
                    return $row->responsible->getFullNameAttribute();
                })

                ->rawColumns(['action','operator', 'user_id', 'responsible'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();
            $user_data['f_name']    = $data['office_room'];
            $user_data['l_name']    = fake()->name();
            $user_data['nick_name'] = fake()->name();
            $user_data['email']     = fake()->unique()->safeEmail();
            $user_data['password']  = bcrypt(12345678);
            $user_data['user_type'] = Enum::USER_TYPE_ROOM;

            $user = User::create($user_data);

            $data['user_id'] = $user->id;
            $this->data = Room::create($data);

            return $this->handleSuccess('Successfully created');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function update(Room $room, array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();

            $user_data['f_name']    = $data['office_room'];
            $user = $room->user;
            $user->update($user_data);

            $this->data = $room->update($data);

            return $this->handleSuccess('Successfully Updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function changeStatus(Supplier $supplier): bool
    {
        try {
            $this->data = $supplier->update(['is_active' => !$supplier->is_active]);
            return $this->handleSuccess('Successfully Updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }
}

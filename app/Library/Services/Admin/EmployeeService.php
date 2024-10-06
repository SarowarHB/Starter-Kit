<?php


namespace App\Library\Services\Admin;

use App\Library\Enum;
use App\Library\Helper;
use App\Models\EmergencyContact;
use App\Models\Employee;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Illuminate\Support\Facades\DB;

class EmployeeService extends BaseService
{

    private function filter(array $params)
    {
        $query = User::select('employees.id as employee_id', 'employees.*', 'users.*')
            ->join('employees', 'users.id', '=', 'employees.user_id')
            ->where('user_type', Enum::USER_TYPE_ADMIN);

        if (isset($params['is_deleted']) && $params['is_deleted'] == 1) {
            $query->onlyTrashed();
            $query->whereNotNull('employees.deleted_at');
        }
        else if(isset($params['status'])){
            $query->where('is_active', $params['status']);
            $query->whereNull('employees.deleted_at');
        }
        return $query->get();
    }


    private function actionHtml($row)
    {
        if(is_null($row->employee_id))
        {
            return '';
        }

        $user_role = User::getAuthUserRole();
        $actionHtml = '';
        if($user_role->hasPermission('user_restore') && $row->deleted_at){
            $actionHtml .=  '<a class="dropdown-item text-secondary" href="javascript:void(0)" onclick="confirmModal(restoreEmployee, '. $row->id .', \'Are you sure to restore operation?\')" ><i class="fas fa-trash-restore-alt"></i> Restore</a>';
        }
        else if($row->employee_id && !$row->deleted_at){
            if($user_role->hasPermission('employee_show')){
                $actionHtml .= '<a class="dropdown-item text-primary" href="' . route('admin.employee.show', $row->employee_id) . '" ><i class="fas fa-eye"></i> View</a>';
            }
            if($user_role->hasPermission('employee_update')){
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.employee.update', $row->employee_id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }
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

    public function dataTable(array $filter_params)
    {
        $data = $this->filter($filter_params);
        return Datatables::of($data)
                ->addColumn('name', function($row){
                    $user_role = User::getAuthUserRole();
                    $name = $row->full_name;
                    return !$user_role->hasPermission('employee_show') || $row->deleted_at || $row->employee_id == null ? $name : '<a href="' . route('admin.employee.show', $row->employee_id) . '" class="text-success pr-2">'. $name .'</a>';
                })
                ->addColumn('emp_type', function($row){
                    return ucwords(str_replace('_', ' ', $row->emp_type));
                })
                ->addColumn('designation', function($row){
                    return ucwords($row->designation);
                })
                ->addColumn('country', function($row){
                    return Helper::getCountryName($row->country);
                })
                ->addColumn('action', function($row){
                    return $this->actionHtml($row);
                })
                ->editColumn('id', function($row){
                    return "E{$row->id}";
                })
                ->rawColumns(['name', 'action'])
                ->make(true);
    }

    public function createEmployee(array $data): bool
    {
        DB::beginTransaction();
        try {
            $user_data = $data['user'];
            $user_data['user_type'] = Enum::USER_TYPE_ADMIN;
            unset($data['user']);
            $user_data['password'] = bcrypt($user_data['password']);

            $user = User::create($user_data);
            $user->roles()->attach($data['role_id']);

            if(isset($data['profile_image'])){
                $data['profile_image'] = Helper::uploadImage($data['profile_image'], Enum::EMPLOYEE_PROFILE_IMAGE, 200, 200);
            }

            $data['user_id'] = $user->id;
            $this->data = Employee::create($data);

            DB::commit();
            return $this->handleSuccess('Successfully created');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function updateEmployee(Employee $employee, array $data): bool
    {
        DB::beginTransaction();
        try {
            $user_data = $data['user'];
            $user = $employee->user;
            $user->update($user_data);
            $user->roles()->sync($data['role_id']);

            if(isset($data['profile_image'])){
                $data['profile_image'] = Helper::uploadImage($data['profile_image'], Enum::EMPLOYEE_PROFILE_IMAGE, 200, 200);
            }

            unset($data['user']);
            $employee->update($data);

            DB::commit();
            return $this->handleSuccess('Successfully updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public static function updateByDesignation(string $designation, array $data)
    {
        return Employee::where('designation', $designation)->update($data);
    }

    public static function getByStatus(int $status)
    {
        return User::whereHas('employee')->with('employee')
            ->where('user_type', Enum::USER_TYPE_ADMIN)
            ->where('is_active', $status)
            ->get();
    }

    public function createEmergencyContact( Employee $employee, array $data): bool
    {
        try {
            if(isset($data['image'])){
                $data['image'] = Helper::uploadImage($data['image'], Enum::EMPLOYEE_CONTACT_PERSION_IMAGE, 200, 200);
            }
            $data['employee_id'] = $employee->id;
            $data['created_by'] = User::getAuthUser()->id;

            $this->data = EmergencyContact::create($data);
            return $this->handleSuccess('Successfully created');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function updateEmergencyContact(EmergencyContact $emergency, array $data): bool
    {
        try {
            $data['created_by'] = User::getAuthUser()->id;

            if(isset($data['image'])){
                $data['image'] = Helper::uploadImage($data['image'], Enum::EMPLOYEE_CONTACT_PERSION_IMAGE, 200, 200);
            }
            $this->data = $emergency->update($data);
            return $this->handleSuccess('Successfully updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

}

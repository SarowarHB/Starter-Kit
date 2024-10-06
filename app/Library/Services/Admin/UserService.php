<?php


namespace App\Library\Services\Admin;

use App\Library\Enum;
use App\Library\Helper;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{

    public function updatePassword(User $user, array $data)
    {
        $this->checkRolePermission($user, 'user_update_password');

        try {
            $user->update([
                'password' => bcrypt($data['password']),
            ]);

            return $this->handleSuccess('Successfully updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function updateStatus(User $user)
    {
        $this->checkRolePermission($user, 'user_update_status');
        try{
            $user->is_active = !$user->is_active;
            $user->save();
            return $this->handleSuccess('Successfully updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function deleteUser(User $user)
    {
        DB::beginTransaction();
        try {
            if($user->isEmployee())
                $user->employee()->delete();
            else if($user->isMember())
                $user->member()->delete();

            $user->delete();

            DB::commit();
            return $this->handleSuccess('Successfully Deleted');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function restoreUser($id)
    {
        $user = User::onlyTrashed()->find($id);
        abort_unless($user, 404, 'Not found');
        $this->checkRolePermission($user, 'user_restore');

        DB::beginTransaction();
        try {
            $user->restore();

            if($user->isMember())
                $user->member()->restore();
            else if($user->isEmployee())
                $user->employee()->restore();

            DB::commit();
            return $this->handleSuccess('Successfully Restored');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function checkRolePermission(User $user, string $permission_suffix)
    {
        $auth_role = User::getAuthUser()->role();
        if($user->isEmployee())
        {
            abort_unless($auth_role->hasPermission($permission_suffix), 401, 'Permission denied');
            $redirect = route('admin.employee.index');
        }
        else if($user->isMember()){
            abort_unless($auth_role->hasPermission($permission_suffix), 401, 'Permission denied');
            $redirect = route('admin.member.index');
        }

        //This redirect variable will be used only for delete operation
        return $redirect;

    }

    //==================----- For User Profile -----=====================//
    public function updateProfile($data)
    {
        DB::beginTransaction();
        try {
            $user = User::getAuthUser();
            $user_data = $data['user'];
            $user->update($user_data);
            unset($data['user']);

            if(isset($data['profile_image'])){
                $data['profile_image'] = Helper::uploadImage($data['profile_image'], Enum::EMPLOYEE_PROFILE_IMAGE, 200, 200);
            }
            if($user->employee){
                $user->employee()->update($data);
            }
            else{
                $data['user_id'] = $user->id;
                $data['designation'] = 'admin';
                $user->employee()->create($data);
            }
            DB::commit();
            return $this->handleSuccess('Successfully Updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function updateProfilePassword($data)
    {
        DB::beginTransaction();
        try {
            $user = User::getAuthUser();
            $user->update([
                'password' => bcrypt($data['password']),
            ]);
            return $this->handleSuccess('Successfully Password Updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }
}

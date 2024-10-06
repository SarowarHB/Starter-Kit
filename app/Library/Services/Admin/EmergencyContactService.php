<?php


namespace App\Library\Services\Admin;

use App\Library\Enum;
use App\Library\Helper;
use App\Models\EmergencyContact;
use App\Models\Employee;
use App\Models\User;
use Exception;

class EmergencyContactService extends BaseService
{
    public function createEmergencyContact( User $user, array $data): bool
    {
        try {
            if(isset($data['image'])){
                $data['image'] = Helper::uploadImage($data['image'], Enum::EMPLOYEE_CONTACT_PERSION_IMAGE, 200, 200);
            }
            $data['user_id'] = $user->id;
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

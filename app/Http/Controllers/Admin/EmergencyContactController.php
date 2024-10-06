<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\User;
use App\Http\Requests\Admin\Employee\EmergencyContact\CreateRequest;
use App\Http\Requests\Admin\Employee\EmergencyContact\UpdateRequest;
use App\Http\Traits\ApiResponse;
use App\Library\Enum;
use App\Library\Services\Admin\EmergencyContactService;
use App\Models\EmergencyContact;

class EmergencyContactController extends Controller
{

    use ApiResponse;

    private $emergency_service;

    function __construct(EmergencyContactService $emergency_service)
    {
        $this->emergency_service = $emergency_service;
    }

    public function showCreateForm(User $user)
    {
        if($user->user_type == Enum::USER_TYPE_ADMIN ){
            $route = route('admin.employee.show', $user->employee->id);
        }
        else{
            $route = route('admin.member.show', $user->member->id);
        }

        return view('admin.pages.emergency_contact.create_emergency',[
            'user'          => $user,
            'countries'     => Helper::getCountries(),
            'route'         => $route,
        ]);
    }

    public function create(User $user, CreateRequest $request)
    {
        $result = $this->emergency_service->createEmergencyContact($user, $request->validated());

        if($result)
            if($user->user_type == Enum::USER_TYPE_ADMIN ){
                return redirect(route('admin.employee.show', $user->employee->id) . '#tab-econtact')->with('success', $this->emergency_service->message);
            }
            elseif($user->user_type == Enum::USER_TYPE_MEMBER){
                return redirect(route('admin.member.show', $user->member->id) . '#tab-econtact')->with('success', $this->emergency_service->message);
            }else{
                return redirect()->back()->with('success', $this->emergency_service->message);
            }

        return back()->withInput($request->all())->with('error', $this->emergency_service->message);
    }

    public function showUpdateForm(EmergencyContact $emergency)
    {
        $user = User::find($emergency->user_id);
        if($user->user_type == Enum::USER_TYPE_ADMIN ){
            $route = route('admin.employee.show', $user->employee->id);
        }
        else{
            $route = route('admin.member.show', $user->member->id);
        }
        
        abort_unless($emergency , 404);
        return view('admin.pages.emergency_contact.update_emergency',[
            'emergency_contact'     => $emergency,
            'countries'             => Helper::getCountries(),
            'route'         => $route,
        ]);
    }

    public function update(EmergencyContact $emergency, UpdateRequest $request)
    {
        abort_unless($emergency , 404);
        $result = $this->emergency_service->updateEmergencyContact($emergency, $request->validated());
        if($result)
            if($emergency->user->user_type == Enum::USER_TYPE_ADMIN ){
                return redirect(route('admin.employee.show', $emergency->user->employee->id) . '#tab-econtact')->with('success', $this->emergency_service->message);
            }
            elseif($emergency->user->user_type == Enum::USER_TYPE_MEMBER){
                return redirect(route('admin.member.show', $emergency->user->member->id) . '#tab-econtact')->with('success', $this->emergency_service->message);
            }else{
                return redirect()->back()->with('success', $this->emergency_service->message);
            }

        return back()->withInput($request->all())->with('error', $this->emergency_service->message);
    }

    public function deleteApi(EmergencyContact $emergency)
    {
        $emergency->delete();

        if($emergency)
            if($emergency->user->user_type == Enum::USER_TYPE_ADMIN ){
                return redirect(route('admin.employee.show', $emergency->user->employee->id) . '#tab-econtact')->with('success', $this->emergency_service->message);
            }
            elseif($emergency->user->user_type == Enum::USER_TYPE_MEMBER){
                return redirect(route('admin.member.show', $emergency->user->member->id) . '#tab-econtact')->with('success', $this->emergency_service->message);
            }else{
                return redirect()->back()->with('success', $this->emergency_service->message);
            }
        else
            return back()->with('error', 'Unable to delete now');
    }

}

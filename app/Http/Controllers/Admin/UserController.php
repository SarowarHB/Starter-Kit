<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UpdatePasswordRequest;
use App\Http\Traits\ApiResponse;
use App\Library\Response;
use App\Library\Services\Admin\UserService;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponse;

    private $user_service;

    function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }

    public function updatePasswordApi(User $user, UpdatePasswordRequest $request)
    {
        $result = $this->user_service->updatePassword($user, $request->validated());

        if($request->ajax())
            return $result ? Response::success($this->user_service->message) : Response::error($this->user_service->message);
        else
            return back()->with($result ? 'success' : 'error', $this->user_service->message);
    }

    public function updateStatusApi(Request $request, User $user)
    {
        $result = $this->user_service->updateStatus($user);

        if($request->ajax())
            return $result ? Response::success($this->user_service->message) : Response::error($this->user_service->message);
        else
            return back()->with($result ? 'success' : 'error', $this->user_service->message);
    }

    public function deleteApi(Request $request, User $user)
    {
        $redirect = $this->user_service->checkRolePermission($user, 'user_delete');
        $result = $this->user_service->deleteUser($user);

        if($request->ajax())
            return $result ? Response::success($this->user_service->message) : Response::error($this->user_service->message);
        else
            return redirect($redirect)->with($result ? 'success' : 'error', $this->user_service->message);
    }

    public function restoreApi(Request $request, $id)
    {
        $result = $this->user_service->restoreUser($id);

        if($request->ajax())
            return $result ? Response::success($this->user_service->message) : Response::error($this->user_service->message);
        else
            return back()->with($result ? 'success' : 'error', $this->user_service->message);
    }

    public function show(User $user)
    {
        return response($user);
    }
}

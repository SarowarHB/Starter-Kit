<?php

namespace App\Http\Controllers\Admin;

use App\Events\Notification\CreateEvent;
use App\Events\Notification\DeleteEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notification\CreateRequest;
use App\Http\Traits\ApiResponse;
use App\Library\Enum;
use App\Library\Services\Admin\ConfigService;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Library\Services\Admin\NotificationService;
use App\Models\Config;

class NotificationController extends Controller
{
    use ApiResponse;

    private $notification_service;

    function __construct(NotificationService $notification_service)
    {
        $this->notification_service = $notification_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $filter_request = $request->only(['is_for_emp', 'is_for_member']);
            return $this->notification_service->dataTable($filter_request);
        }
        return view('admin.pages.notification.index');
    }

    public function showCreateForm()
    {
        $notification_types = ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_NOTIFICATION_TYPE);
        return view('admin.pages.notification.create', [
            'notification_types' => $notification_types,
        ]);
    }

    public function create(CreateRequest $request)
    {
        $result = $this->notification_service->createNotification($request->validated());
        event(new CreateEvent($this->notification_service->data));
        if ($result)
            return redirect()->route('admin.notification.index')->with('success', $this->notification_service->message);

        return back()->withInput($request->all())->with('error', $this->notification_service->message);
    }

    public function deleteApi( Notification $notification )
    {
        $result = $this->notification_service->deleteNotification($notification);
        event(new DeleteEvent($this->notification_service->data));
        if ($result)
            return $this->response($result, $this->notification_service->message);

        return back()->with('error', $this->notification_service->message);
    }
}

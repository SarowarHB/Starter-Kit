<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Event\CreateRequest;
use App\Http\Requests\Admin\Event\UpdateRequest;
use App\Http\Traits\ApiResponse;
use App\Library\Enum;
use App\Library\Services\Admin\ConfigService;
use App\Library\Services\Admin\EventService;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    use ApiResponse;

    private $event_service;

    function __construct(EventService $event_service)
    {
        $this->event_service = $event_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $filter_request = $request->only(['status']);
            return $this->event_service->dataTable($filter_request);
        }
        return view('admin.pages.website.event.index');
    }

    public function showCreateForm()
    {
        return view('admin.pages.website.event.create', [
            'event_type'  => ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_EVENT_TYPE)
        ]);
    }

    public function create(CreateRequest $request)
    {
        $result = $this->event_service->createEvent($request->validated());
        if($result)
            return redirect()->route('admin.website.event.index')->with('success', $this->event_service->message);
        else
            return back()->withInput(request()->all())->with('error', $this->event_service->message);
    }

    public function show(Event $event)
    {
        return view('admin.pages.website.event.show', [
            'event'  => $event,
        ]);
    }

    public function showUpdateForm(Event $event)
    {
        return view('admin.pages.website.event.update', [
            'event'  => $event,
            'event_type'  => ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_EVENT_TYPE)
        ]);
    }

    public function update(Event $event, UpdateRequest $request)
    {
        abort_unless($event , 404);
        $result = $this->event_service->updateEvent($event, $request->validated());
        if($result)
            return redirect()->route('admin.website.event.index')->with('success', $this->event_service->message);
        else
            return back()->withInput(request()->all())->with('error', $this->event_service->message);
    }

    public function changeStatusApi(Event $event)
    {
        $event->is_active = !$event->is_active;
        $event->save();

        if($event)
            return back()->with('success', __('Successfully updated'));
        else
            return back()->with('error', 'Unable to update now');
    }

    public function deleteApi(Event $event)
    {
        $event->delete();

        if($event)
            return redirect()->route('admin.website.event.index')->with('success', __('Successfully Deleted'));
        else
            return back()->with('error', 'Unable to delete now');
    }
}

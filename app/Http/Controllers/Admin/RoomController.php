<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Room\StoreRoomRequest;
use App\Http\Requests\Admin\Room\UpdateRoomRequest;
use App\Http\Traits\ApiResponse;
use App\Library\Enum;
use App\Library\Services\Admin\RoomService;
use App\Models\Room;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Library\Helper;
use App\Models\User;

class RoomController extends Controller
{
    use ApiResponse;

    private $room_service;

    function __construct(RoomService $room_service)
    {
        $this->room_service = $room_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->room_service->dataTable();
        }
        return view('admin.pages.ams.room.index');
    }

    public function create(): View
    {
        return view('admin.pages.ams.room.create', [
            'responsible_persons' => User::getUserTypeWise(Enum::USER_TYPE_ADMIN)
        ]);
    }

    public function store(StoreRoomRequest $request): RedirectResponse
    {
        $result = $this->room_service->store($request->validated());

        if($result)
            return redirect()->route('admin.ams.room.index')->with('success', $this->room_service->message);

        return back()->withInput($request->all())->with('error', $this->room_service->message);
    }

    public function show(Request $request, Room $room): View
    {
        return view('Room.show', compact('Room'));
    }

    public function edit(Request $request, Room $room): View
    {
        return view('admin.pages.ams.room.edit', [
            'room' => $room,
            'responsible_persons' => User::getUserTypeWise(Enum::USER_TYPE_ADMIN)
        ]);
    }

    public function update(UpdateRoomRequest $request, Room $room): RedirectResponse
    {
        $result = $this->room_service->update($room, $request->validated());

        if($result)
            return redirect()->route('admin.ams.room.index')->with('success', $this->room_service->message);

        return back()->withInput($request->all())->with('error', $this->room_service->message);
    }

    public function destroy( Room $room): RedirectResponse
    {
        $result = $room->delete();

        if($result)
            return redirect()->back()->with('success', "Successfully Delete");

        return back()->with('error', 'Unable to delete now');
    }
}

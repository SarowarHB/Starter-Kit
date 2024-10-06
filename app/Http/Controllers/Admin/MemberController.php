<?php

namespace App\Http\Controllers\Admin;

use App\Library\Enum;
use App\Models\Member;
use App\Library\Helper;
use App\Library\Response;
use App\Models\StockAssign;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\MemberService;
use App\Http\Requests\Admin\Member\CreateRequest;
use App\Http\Requests\Admin\Member\UpdateRequest;

class MemberController extends Controller
{
    use ApiResponse;

    private $member_service;

    function __construct(MemberService $member_service)
    {
        $this->member_service = $member_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $filter_request = $request->only(['status', 'is_deleted']);
            return $this->member_service->dataTable($filter_request);
        }
        return view('admin.pages.member.index');
    }

    public function show(Member $member)
    {
        abort_unless($member->user , 404);
        return view('admin.pages.member.show', [
            'member'            => $member,
            'user_id'           => $member->user_id,
            'emergency_contact' => $member->user->emergency,
            'payments'          => $member->payments,
            'assigns'           => $member->user->assigns,
            'stock_status'            => Enum::getStockStatus(),
            'currency'          => env('CURRENCY_SIGN'),
        ]);
    }

    public function showCreateForm()
    {
        return view('admin.pages.member.create', [
            'countries' => Helper::getCountries(),
        ]);
    }

    public function create(CreateRequest $request)
    {
        $result = $this->member_service->createMember($request->validated());
        if($result)
            return redirect()->route('admin.member.index')->with('success',  $this->member_service->message);
        else
            return back()->withInput(request()->all())->with('error', $this->member_service->message);
    }

    public function showUpdateForm(Member $member)
    {
        abort_unless($member->user , 404);
        return view('admin.pages.member.update', [
            'member'     => $member,
            'countries' => Helper::getCountries(),
        ]);
    }

    public function update(Member $member, UpdateRequest $request)
    {
        abort_unless($member->user , 404);
        $result = $this->member_service->updateMember($member, $request->validated());
        return back()->withInput(request()->all())->with($result ? 'success' : 'error', $this->member_service->message);
    }

    public function acceptStock(Request $request, StockAssign $assign)
    {
        abort_unless($assign , 404);
        $result = $this->member_service->acceptStock($assign);

        if($request->ajax())
            return $result ? Response::success($this->member_service->message) : Response::error($this->member_service->message);
        else
            return back()->with($result ? 'success' : 'error', $this->member_service->message);
    }

    public function stockStatusChange(Request $request)
    {
        $result = $this->member_service->stockStatusChange($request->all());
        return back()->with($result ? 'success' : 'error', $this->member_service->message);
    }
}

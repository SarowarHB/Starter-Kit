<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Library\Enum;
use App\Models\Stock;
use Illuminate\View\View;
use App\Models\StockAssign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Library\Services\Admin\StockAssignService;
use App\Http\Requests\Admin\StockAssign\StockAssignStoreRequest;
use App\Http\Requests\Admin\StockAssign\StockAssignUpdateRequest;

class StockAssignController extends Controller
{
    private $stock_assign_service;

    function __construct(StockAssignService $stock_assign_service)
    {
        $this->stock_assign_service = $stock_assign_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->stock_assign_service->dataTable();
        }
        return view('admin.pages.ams.stock_assign.index');
    }

    public function create(Request $request): View
    {
        $users = User::all();
        
        return view('admin.pages.ams.stock_assign.create', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user_ids = $request->user_ids;
        $stock_ids = $request->stock_ids;
        $quantity = $request->quantity;

        $this->stock_assign_service->store($user_ids, $stock_ids, $quantity);

        return redirect()->route('admin.ams.stock_assign.index')->with('success', $this->stock_assign_service->message);
    }

    public function show(Request $request, Assign $assign): View
    {
        return view('assign.show', compact('assign'));
    }

    public function edit(Request $request, Assign $assign): View
    {
        return view('assign.edit', compact('assign'));
    }

    public function update(StockAssignUpdateRequest $request, Assign $assign): RedirectResponse
    {
        $assign->update($request->validated());

        $request->session()->flash('assign.id', $assign->id);

        return redirect()->route('assign.index');
    }

    public function destroy(Request $request, Assign $assign): RedirectResponse
    {
        $assign->delete();

        return redirect()->route('assign.index');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\StockTransfer;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\StockTransfer\StockTransferStoreRequest;
use App\Http\Requests\Admin\StockTransfer\StockTransferUpdateRequest;
use App\Http\Traits\ApiResponse;
use App\Library\Enum;
use App\Library\Services\Admin\ConfigService;
use App\Library\Services\Admin\StockTransferService;
use App\Models\Stock;

class StockTransferController extends Controller
{
    use ApiResponse;

    private $stock_transfer_service;

    function __construct(StockTransferService $stock_transfer_service)
    {
        $this->stock_transfer_service = $stock_transfer_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->stock_transfer_service->dataTable();
        }
        return view('admin.pages.ams.stock_transfer.index');
    }

    public function create(): View
    {
        return view('admin.pages.ams.stock_transfer.create',[
            'stocks' => Stock::all(),
            'locations' => ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_AMS_LOCATION)
        ]);
    }

    public function store(StockTransferStoreRequest $request): RedirectResponse
    {
        $result = $this->stock_transfer_service->store($request->validated());

        if($result)
            return redirect()->route('admin.ams.stock_transfer.index')->with('success', $this->stock_transfer_service->message);

        return back()->withInput($request->all())->with('error', $this->stock_transfer_service->message);
    }

    public function edit(StockTransfer $stock_transfer): View
    {
        return view('admin.pages.ams.stock_transfer.edit',[
            'stock_transfer' => $stock_transfer,
            'stocks' => Stock::all(),
            'locations' => ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_AMS_LOCATION),
        ]);
    }

    public function update(StockTransferUpdateRequest $request, StockTransfer $stock_transfer): RedirectResponse
    {
        $result = $this->stock_transfer_service->update($stock_transfer, $request->validated());

        if($result)
            return redirect()->route('admin.ams.stock_transfer.index')->with('success', $this->stock_transfer_service->message);

        return back()->withInput($request->all())->with('error', $this->stock_transfer_service->message);
    }

    public function destroy(StockTransfer $stock_transfer): RedirectResponse
    {
        $result = $stock_transfer->delete();

        if($result)
            return redirect()->back()->with('success', "Successfully Delete");

        return back()->with('error', 'Unable to delete now');
    }

    public function getStock(Request $request)
    {
        $stock = Stock::find($request->stock_id);
        $entry_type = $stock->product->category->categoryType->entry_type;

        return response()->json([
            'stock' => $stock,
            'entry_type'=> $entry_type,
        ]);
    }
}

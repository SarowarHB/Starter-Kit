<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use App\Models\StockTesting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\StockTesting\StockTestingStoreRequest;
use App\Http\Traits\ApiResponse;
use App\Library\Enum;
use App\Library\Services\Admin\StockTestingService;
use App\Models\Stock;

class StockTestingController extends Controller
{
    use ApiResponse;

    private $stock_testing_service;

    function __construct(StockTestingService $stock_testing_service)
    {
        $this->stock_testing_service = $stock_testing_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->stock_testing_service->dataTable();
        }
        return view('admin.pages.ams.stock_testing.index');
    }

    public function showTest(Stock $stock): View
    {
        return view('admin.pages.ams.stock_testing.test', [
            'status' => Enum::getStockStatus(),
            'stock' => $stock,
        ]);
    }

    public function storeTest(StockTestingStoreRequest $request): RedirectResponse
    {
        $result = $this->stock_testing_service->storeTest($request->validated());

        if($result)
            return redirect()->route('admin.ams.stock_testing.index')->with('success', $this->stock_testing_service->message);

        return back()->withInput($request->all())->with('error', $this->stock_testing_service->message);
    }

    public function view(Stock $stock): View
    {
        return view('admin.pages.ams.stock_testing.show',[
            'stock' => $stock,
            'stock_testings' => $stock->stockTest
        ]);
    }
}

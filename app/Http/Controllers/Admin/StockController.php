<?php

namespace App\Http\Controllers\Admin;

use App\Library\Enum;
use App\Models\Stock;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Library\Services\Admin\StockService;
use App\Http\Requests\Admin\Stock\StockStoreRequest;
use App\Http\Requests\Admin\Stock\StockUpdateRequest;
use App\Library\Services\Admin\ConfigService;
use App\Models\Product;
use App\Models\Supplier;

class StockController extends Controller
{
    use ApiResponse;

    private $stock_service;

    function __construct(StockService $stock_service)
    {
        $this->stock_service = $stock_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $filter_request = $request->only(['status']);
            return $this->stock_service->dataTable($filter_request);
        }
        return view('admin.pages.ams.stock.index');
    }

    public function getSupplier(Request $request)
    {
        $product = Product::find($request->product_id);
        $supplier_type = $product->category->categoryType->id;
        $entry_type = $product->category->categoryType->entry_type;

        $suppliers = Supplier::where('supplier_type', $supplier_type)
                              ->get();
        return response()->json([
            'suppliers' => $suppliers,
            'entry_type'=> $entry_type,
        ]);
    }

    public function create()
    {
        return view('admin.pages.ams.stock.create',[
            'products'  => Product::get(),
            'suppliers' => Supplier::get(),
            'locations' => ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_AMS_LOCATION)
        ]);
    }

    public function store(StockStoreRequest $request): RedirectResponse
    {
        $result = $this->stock_service->store($request->validated());

        if($result)
            return redirect()->route('admin.ams.stock.index')->with('success', $this->stock_service->message);

        return back()->withInput($request->all())->with('error', $this->stock_service->message);
    }

    public function showApi(Request $request, Stock $stock)
    {
        return response($stock->load('product.category.categoryType'));
    }

    public function getStockByLocation(Request $request, $location)
    {
        $stocks = Stock::with('product.category.categoryType')->where('location', $location)->get();
        
        return response($stocks);
    }

    public function show(Stock $stock): View
    {
        return view('admin.pages.ams.stock.show', ['stock' => $stock]);
    }

    public function edit(Stock $stock): View
    {
        abort_unless($stock, 404);
        return view('admin.pages.ams.stock.edit', [
            'stock'     => $stock,
            'products'  => Product::get(),
            'suppliers' => Supplier::get(),
            'locations' => ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_AMS_LOCATION)
        ]);
    }

    public function update(StockUpdateRequest $request, Stock $stock): RedirectResponse
    {
        abort_unless($stock , 404);
        $result = $this->stock_service->update($stock, $request->validated());
        if($result)
            return redirect()->route('admin.ams.stock.index')->with('success', $this->stock_service->message);

        return back()->withInput($request->all())->with('error', $this->stock_service->message);
    }

    public function destroy(Stock $stock): RedirectResponse
    {
        abort_unless($stock , 404);

        $result = $this->stock_service->delete($stock);
        if($result)
            return redirect()->route('admin.ams.stock.index')->with('success', __('Successfully Deleted'));
        else
            return back()->with('error', 'Unable to delete now');
    }

    public function changeStatus(Stock $stock, Request $request)
    {
        abort_unless($stock , 404);
        $result = $this->stock_service->changeStatus($stock, $request->all());
        if($result)
            return redirect()->route('admin.ams.stock.index', $stock->id)->with('success', $this->stock_service->message);

        return back()->withInput($request->all())->with('error', $this->stock_service->message);
    }
}

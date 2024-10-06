<?php

namespace App\Http\Controllers\Admin;

use App\Library\Enum;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Library\Services\Admin\ConfigService;
use App\Library\Services\Admin\ProductService;
use App\Http\Requests\Admin\Product\ProductStoreRequest;
use App\Http\Requests\Admin\Product\ProductUpdateRequest;

class ProductController extends Controller
{
    private $product_service;

    function __construct(ProductService $product_service)
    {
        $this->product_service = $product_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->product_service->dataTable();
        }

        return view('admin.pages.ams.product.index');
    }

    public function create(Request $request): View
    {
        $categories = Category::all();
        $brands  = ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_AMS_BRAND);
        
        return view('admin.pages.ams.product.create', compact('categories', 'brands'));
    }

    public function store(ProductStoreRequest $request): RedirectResponse
    {
        $result = $this->product_service->store($request->validated());

        if($result)
            return redirect()->route('admin.ams.product.index')->with('success', $this->product_service->message);

        return back()->withInput($request->all())->with('error', $this->product_service->message);
    }

    public function show(Product $product): View
    {
        return view('admin.pages.ams.product.show', compact('product'));
    }

    public function edit(Request $request, Product $product): View
    {
        $categories = Category::all();
        $brands  = ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_AMS_BRAND);
        return view('admin.pages.ams.product.edit', compact('categories', 'brands', 'product'));
    }

    public function update(ProductUpdateRequest $request, Product $product): RedirectResponse
    {
        abort_unless($product , 404);
        $result = $this->product_service->update($product, $request->validated());
        if($result)
            return redirect()->route('admin.ams.product.index', $product->id)->with('success', $this->product_service->message);

        return back()->withInput($request->all())->with('error', $this->product_service->message);
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.ams.product.index')->with('success', __('Successfully Deleted'));
    }

    public function changeStatus(Request $request, Product $product)
    {
        $result = $this->product_service->changeStatus($product);

        if($result)
            return redirect()->route('admin.ams.product.index')->with('success', $this->product_service->message);

        return back()->withInput($request->all())->with('error', $this->product_service->message);
    }
}

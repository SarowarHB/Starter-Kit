<?php

namespace App\Http\Controllers\Admin;

use App\Models\Supplier;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\Supplier\SupplierStoreRequest;
use App\Http\Requests\Admin\Supplier\SupplierUpdateRequest;
use App\Http\Traits\ApiResponse;
use App\Library\Enum;
use App\Library\Helper;
use App\Library\Services\Admin\SupplierService;
use App\Models\Category;
use App\Models\CategoryType;

class SupplierController extends Controller
{
    use ApiResponse;

    private $supplier_service;

    function __construct(SupplierService $supplier_service)
    {
        $this->supplier_service = $supplier_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->supplier_service->dataTable();
        }
        return view('admin.pages.ams.supplier.index');
    }

    public function create(): View
    {
        return view('admin.pages.ams.supplier.create',[
            'types'     => CategoryType::where('is_active', 1)->get(),
            'countries' => Helper::getCountries(),
        ]);
    }

    public function store(SupplierStoreRequest $request): RedirectResponse
    {
        $result = $this->supplier_service->store($request->validated());

        if($result)
            return redirect()->route('admin.ams.supplier.index')->with('success', $this->supplier_service->message);

        return back()->withInput($request->all())->with('error', $this->supplier_service->message);
    }

    public function show(Request $request, Supplier $supplier): View
    {
        return view('supplier.show', compact('supplier'));
    }

    public function edit(Supplier $supplier): View
    {
        return view('admin.pages.ams.supplier.edit',[
            'supplier'  => $supplier,
            'types'     => CategoryType::where('is_active', 1)->get(),
            'countries' => Helper::getCountries(),
        ]);
    }

    public function update(SupplierUpdateRequest $request, Supplier $supplier): RedirectResponse
    {
        $result = $this->supplier_service->update($supplier, $request->validated());

        if($result)
            return redirect()->route('admin.ams.supplier.index')->with('success', $this->supplier_service->message);

        return back()->withInput($request->all())->with('error', $this->supplier_service->message);
    }

    public function destroy(Request $request, Supplier $supplier): RedirectResponse
    {
        $result = $supplier->delete();

        if($result)
            return redirect()->back()->with('success', "Successfully Delete");

        return back()->with('error', 'Unable to delete now');
    }

    public function changeStatus(Request $request, Supplier $supplier)
    {
        $result = $this->supplier_service->changeStatus($supplier);

        if($result)
            return redirect()->route('admin.ams.supplier.index')->with('success', $this->supplier_service->message);

        return back()->withInput($request->all())->with('error', $this->supplier_service->message);
    }
}

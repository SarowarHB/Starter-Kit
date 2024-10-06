<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\CategoryType;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\CategoryTypeService;
use App\Http\Requests\Admin\CategoryType\CategoryTypeStoreRequest;
use App\Http\Requests\Admin\CategoryType\CategoryTypeUpdateRequest;

class CategoryTypeController extends Controller
{
    use ApiResponse;

    private $category_type_service;

    function __construct(CategoryTypeService $category_type_service)
    {
        $this->category_type_service = $category_type_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->category_type_service->dataTable();
        }
        return view('admin.pages.ams.category_type.index');
    }

    public function create()
    {
        return view('admin.pages.ams.category_type.create');
    }
 
    public function store(CategoryTypeStoreRequest $request)
    {
        $result = $this->category_type_service->store($request->validated());

        if($result)
            return redirect()->route('admin.ams.category_type.index')->with('success', $this->category_type_service->message);

        return back()->withInput($request->all())->with('error', $this->category_type_service->message);
    }

    public function edit(CategoryType $category_type)
    {
        abort_unless($category_type, 404);
        return view('admin.pages.ams.category_type.edit',[
            'category_type'      => $category_type,
        ]);
    }

    public function update(CategoryType $category_type, CategoryTypeUpdateRequest $request)
    {
        abort_unless($category_type , 404);
        $result = $this->category_type_service->update($category_type, $request->validated());
        if($result)
            return redirect()->route('admin.ams.category_type.index', $category_type->id)->with('success', $this->category_type_service->message);

        return back()->withInput($request->all())->with('error', $this->category_type_service->message);
    }

    public function destroy(Request $request, CategoryType $category_type)
    {
        if($category_type->category->count()){
            return back()->withInput($request->all())->with('error', "This Category Is Already Used");
        }else{
            $category_type->delete();
            return redirect()->route('admin.ams.category_type.index')->with('success', __('Successfully Deleted'));
        }
    }

    public function changeStatus(Request $request, CategoryType $category_type)
    {
        $result = $this->category_type_service->changeStatus($category_type);

        if($result)
            return redirect()->route('admin.ams.category_type.index')->with('success', $this->category_type_service->message);

        return back()->withInput($request->all())->with('error', $this->category_type_service->message);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\CategoryService;
use App\Http\Requests\Admin\Category\CategoryStoreRequest;
use App\Http\Requests\Admin\Category\CategoryUpdateRequest;
use App\Models\CategoryType;

class CategoryController extends Controller
{
    use ApiResponse;

    private $category_service;

    function __construct(CategoryService $category_service)
    {
        $this->category_service = $category_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->category_service->dataTable();
        }
        return view('admin.pages.ams.category.index');
    }

    public function create()
    {
        return view('admin.pages.ams.category.create',[
            'parent_categories'  => Category::all(),
            'category_types'  => CategoryType::all()
        ]);
    }
 
    public function store(CategoryStoreRequest $request)
    {
        $result = $this->category_service->store($request->validated());

        if($result)
            return redirect()->route('admin.ams.category.index')->with('success', $this->category_service->message);

        return back()->withInput($request->all())->with('error', $this->category_service->message);
    }

    public function edit(Category $category)
    {
        abort_unless($category, 404);
        return view('admin.pages.ams.category.edit',[
            'category'      => $category,
            'parent_categories'  => Category::all(),
            'category_types'  => CategoryType::all()
        ]);
    }

    public function update(Category $category, CategoryUpdateRequest $request)
    {
        abort_unless($category , 404);
        $result = $this->category_service->update($category, $request->validated());
        if($result)
            return redirect()->route('admin.ams.category.index', $category->id)->with('success', $this->category_service->message);

        return back()->withInput($request->all())->with('error', $this->category_service->message);
    }

    public function destroy(Request $request, Category $category)
    {
        $category->delete();

        return redirect()->route('admin.ams.category.index')->with('success', __('Successfully Deleted'));
    }

    public function changeStatus(Request $request, Category $category)
    {
        $result = $this->category_service->changeStatus($category);

        if($result)
            return redirect()->route('admin.ams.category.index')->with('success', $this->category_service->message);

        return back()->withInput($request->all())->with('error', $this->category_service->message);
    }
}

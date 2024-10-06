<?php

namespace App\Library\Services\Admin;

use App\Library\Enum;
use App\Library\Helper;
use App\Models\Asset;
use App\Models\AssetSale;
use App\Models\Category;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Illuminate\Support\Facades\DB;


class CategoryService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';

        if($row->id){
            $actionHtml = '
            <a class="dropdown-item" href="' . route('admin.ams.category.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>
            <a class="dropdown-item text-danger" href="' . route('admin.ams.category.delete', $row->id) . '" ><i class="fas fa-trash-alt"></i> Delete</a>';
        }
        else{
            $actionHtml = '';
        }

        return '<div class="action dropdown">
                    <button class="btn btn2-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <i class="fas fa-tools"></i> Action
                    </button>
                    <div class="dropdown-menu">
                        '.$actionHtml.'
                    </div>
                </div>';
    }

    private function getSwitch($row){
        $is_check =  $row->is_active  ? "checked" : "";
        $route = "'". route('admin.ams.category.change_status', $row->id)."'";

        return '<div class="custom-control custom-switch">
                    <input type="checkbox"
                        onchange="changeStatus(event, '. $route .')"
                        class="custom-control-input"
                        id="primarySwitch_'. $row->id .'" '. $is_check .' >
                    <label class="custom-control-label" for="primarySwitch_'. $row->id .'"></label>
                </div>';
    }

    public function dataTable()
    {
        $query = Category::select('*');
        $data = $query->get();

        return Datatables::of($data)
                ->addIndexColumn()

                ->editColumn('parent_id', function($row){
                    return $row->parent_id ? $row->parent->name : 'N/A';
                })

                ->editColumn('category_type_id', function($row){
                    return $row->categoryType->name;
                })
                
                ->editColumn('operator_id', function($row){
                    return $row->operator->full_name;
                })
                
                ->addColumn('action', function($row){
                    return $this->actionHtml($row);
                })

                ->editColumn('is_active', function($row){
                    return $this->getSwitch($row);
                })

                ->rawColumns(['action', 'is_active', 'category_type_id'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();
            $this->data = Category::create($data);

            return $this->handleSuccess('Successfully created');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function update(Category $category, array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();
            $this->data = $category->update($data);

            return $this->handleSuccess('Successfully Updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function changeStatus(Category $category): bool
    {
        try {
            $this->data = $category->update(['is_active' => !$category->is_active]);
            return $this->handleSuccess('Successfully Updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }
}

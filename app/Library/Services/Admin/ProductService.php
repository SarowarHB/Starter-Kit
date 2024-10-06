<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Library\Enum;
use App\Library\Helper;
use App\Models\Product;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;


class ProductService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';

        if($row->id){
            $actionHtml = '
            <a class="dropdown-item" href="' . route('admin.ams.product.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>
            <a class="dropdown-item text-danger" onclick="confirmFormModal(\'' . route('admin.ams.product.delete', $row->id) . '\', \'Confirmation\', \'Are you sure to delete operation?\')" ><i class="fas fa-trash-alt"></i> Delete</a>';
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
        $route = "'". route('admin.ams.product.change_status', $row->id)."'";

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
        $query = Product::select('*');
        $data = $query->get();

        return Datatables::of($data)
                ->addIndexColumn()

                ->editColumn('is_active', function($row){
                    return $this->getSwitch($row);
                })

                ->addColumn('name', function($row){
                    $user_role = User::getAuthUserRole();
                    $name = $row->name;
                    return !$user_role->hasPermission('product_show') || $row->deleted_at ? $name : '<a href="' . route('admin.ams.product.show', $row->id) . '" class="text-success pr-2">'. $name .'</a>';
                })

                ->editColumn('category_id', function($row){
                    return $row->category ? $row->category->name : 'N/A';
                })

                ->editColumn('brand', function($row){
                    return $row->brand ? $row->brand : 'N/A';
                })

                ->editColumn('model', function($row){
                    return $row->model ? $row->model : 'N/A';
                })
                
                ->editColumn('operator_id', function($row){
                    return $row->operator->full_name;
                })
                
                ->addColumn('action', function($row){
                    return $this->actionHtml($row);
                })

                ->rawColumns(['action', 'is_active', 'category_id', 'name'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();

            if(isset($data['image'])){
                $data['image'] = Helper::uploadImage($data['image'], Enum::AMS_PRODUCT_IMAGE_DIR, 200, 200);
            }

            $this->data = Product::create($data);

            return $this->handleSuccess('Successfully created');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function update(Product $product, array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();

            if(isset($data['image'])){
                $data['image'] = Helper::uploadImage($data['image'], Enum::AMS_PRODUCT_IMAGE_DIR, 200, 200);
            }

            $this->data = $product->update($data);

            return $this->handleSuccess('Successfully Updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function changeStatus(Product $product): bool
    {
        try {
            $this->data = $product->update(['is_active' => !$product->is_active]);
            return $this->handleSuccess('Successfully Updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }
}

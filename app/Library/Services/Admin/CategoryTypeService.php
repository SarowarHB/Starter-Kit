<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Models\CategoryType;
use Yajra\DataTables\Facades\DataTables;


class CategoryTypeService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';

        if($row->id && $row->id > 4){
            $actionHtml = '
            <a class="dropdown-item" href="' . route('admin.ams.category_type.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>
            <a class="dropdown-item text-danger" href="' . route('admin.ams.category_type.delete', $row->id) . '" ><i class="fas fa-trash-alt"></i> Delete</a>';
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
        $route = "'". route('admin.ams.category_type.change_status', $row->id)."'";

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
        $query = CategoryType::select('*');
        $data = $query->get();

        return Datatables::of($data)
                ->addIndexColumn()

                ->editColumn('is_active', function($row){
                    return $this->getSwitch($row);
                })

                ->editColumn('entry_type', function($row){
                    return $row->entry_type ? '<div class="">Individual</div>' : '<div class="">Bulk</div>';
                })

                ->editColumn('operator_id', function($row){
                    return $row->operator->full_name;
                })

                ->addColumn('action', function($row){
                    return $this->actionHtml($row);
                })

                ->rawColumns(['action', 'is_active', 'entry_type'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();

            $this->data = CategoryType::create($data);

            return $this->handleSuccess('Successfully created');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function update(CategoryType $category_type, array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();

            $this->data = $category_type->update($data);

            return $this->handleSuccess('Successfully Updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function changeStatus(CategoryType $category_type): bool
    {
        try {
            $this->data = $category_type->update(['is_active' => !$category_type->is_active]);
            return $this->handleSuccess('Successfully Updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }
}

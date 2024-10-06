<?php

namespace App\Library\Services\Admin;

use App\Library\Enum;
use App\Library\Helper;
use App\Models\Supplier;
use Yajra\DataTables\Facades\DataTables;
use Exception;


class SupplierService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';

        if($row->id){
            $actionHtml = '
            <a class="dropdown-item" href="' . route('admin.ams.supplier.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>
            <a class="dropdown-item text-danger" href="' . route('admin.ams.supplier.delete', $row->id) . '" ><i class="fas fa-trash-alt"></i> Delete</a>';
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
        $route = "'". route('admin.ams.supplier.change_status', $row->id)."'";

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
        $query = Supplier::select('*');
        $data = $query->get();

        return Datatables::of($data)
                ->addIndexColumn()

                ->editColumn('supplier_type', function($row){
                    return $row->supplierType->name;
                })

                ->editColumn('phone', function($row){
                    return $row->phone ? $row->phone : 'N/A';
                })

                ->editColumn('email', function($row){
                    return $row->email ? $row->email : 'N/A';
                })

                ->editColumn('address', function($row){
                    return $row->address ? $row->address : 'N/A';
                })

                ->editColumn('contact_person', function($row){
                    return $row->contact_person ? $row->contact_person : 'N/A';
                })

                ->editColumn('company', function($row){
                    return $row->company ? $row->company : 'N/A';
                })

                ->editColumn('operator', function($row){
                    return $row->operator->getFullNameAttribute();
                })

                ->addColumn('action', function($row){
                    return $this->actionHtml($row);
                })

                ->editColumn('is_active', function($row){
                    return $this->getSwitch($row);
                })

                ->rawColumns(['action','operator', 'supplier_type', 'is_active'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();

            if(isset($data['logo'])){
                $data['logo'] = Helper::uploadImage($data['logo'], Enum::SUPPLIER_LOGO, 200, 200);
            }

            $this->data = Supplier::create($data);

            return $this->handleSuccess('Successfully created');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function update(Supplier $supplier, array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();

            if(isset($data['logo'])){
                $data['logo'] = Helper::uploadImage($data['logo'], Enum::SUPPLIER_LOGO, 200, 200);
            }
            $this->data = $supplier->update($data);

            return $this->handleSuccess('Successfully Updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function changeStatus(Supplier $supplier): bool
    {
        try {
            $this->data = $supplier->update(['is_active' => !$supplier->is_active]);
            return $this->handleSuccess('Successfully Updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }
}

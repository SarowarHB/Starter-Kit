<?php

namespace App\Library\Services\Admin;

use App\Library\Enum;
use App\Library\Helper;
use App\Models\Asset;
use App\Models\AssetSale;
use App\Models\Category;
use App\Models\StockTransfer;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Illuminate\Support\Facades\DB;


class StockTransferService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';

        if($row->id){
            $actionHtml = '
            <a class="dropdown-item" href="' . route('admin.ams.stock_transfer.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>
            <a class="dropdown-item text-danger" href="' . route('admin.ams.stock_transfer.delete', $row->id) . '" ><i class="fas fa-trash-alt"></i> Delete</a>';
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

    public function dataTable()
    {
        $query = StockTransfer::select('*');
        $data = $query->get();

        return Datatables::of($data)
                ->addIndexColumn()
                
                ->editColumn('operator_id', function($row){
                    return $row->operator->full_name;
                })

                ->editColumn('stock_id', function($row){
                    return $row->stock->unique_id;
                })
                
                ->addColumn('action', function($row){
                    return $this->actionHtml($row);
                })

                ->rawColumns(['action', 'operator_id'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();
            $this->data = StockTransfer::create($data);

            return $this->handleSuccess('Successfully created');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function update(StockTransfer $stock_transfer, array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();
            $this->data = $stock_transfer->update($data);

            return $this->handleSuccess('Successfully Updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

}

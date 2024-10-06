<?php

namespace App\Library\Services\Admin;

use Exception;
use Carbon\Carbon;
use App\Library\Enum;
use App\Library\Helper;
use App\Models\Product;
use App\Models\StockAssign;
use App\Events\Stock\StockHistoryEvent;
use App\Models\Stock;
use App\Models\StockHistory;
use Yajra\DataTables\Facades\DataTables;


class StockAssignService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';

        if($row->id){
            $actionHtml = '
            <a class="dropdown-item" href="' . route('admin.ams.product.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>
            <a class="dropdown-item text-danger" href="' . route('admin.ams.product.delete', $row->id) . '" ><i class="fas fa-trash-alt"></i> Delete</a>';
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
        $query = StockAssign::select('*');
        $data = $query->get();

        return Datatables::of($data)
                ->addIndexColumn()

                ->editColumn('unique_id', function($row){
                    return $row->stock ? $row->stock->unique_id : 'N/A';
                })

                ->addColumn('asset_type', function($row){
                    return $row->stock ? $row->stock->product->category->categoryType->name : 'N/A';
                })

                ->addColumn('asset_name', function($row){
                    return $row->stock ? $row->stock->product->name : 'N/A';
                })

                ->editColumn('asset_category', function($row){
                    return $row->stock ? $row->stock->product->category->name : 'N/A';
                })

                ->editColumn('operator_id', function($row){
                    return $row->operator->full_name;
                })

                ->editColumn('assigned_date', function($row){
                    return Carbon::parse($row->assigned_date)->format('m-d-Y');
                })

                ->addColumn('action', function($row){
                    return $this->actionHtml($row);
                })

                ->rawColumns(['action', 'unique_id', 'asset_type', 'asset_category', 'assigned_date'])
                ->make(true);
    }

    public function store($user, $stockIds, $quantity): bool
    {
        try {
            foreach ($user as $key => $value) {
                $stock_assign = new StockAssign;
                $stock_assign->user_id = $value;
                $stock_assign->stock_id = $stockIds[$key];
                $stock_assign->quantity = $quantity[$key];
                $stock_assign->assigned_date = now()->format('Y-m-d');
                $stock_assign->status = Enum::STOCK_ASSIGNED;
                $stock_assign->operator_id = auth()->id();
                $stock_assign->acknowledgement_status = false;
                $stock_assign->save();

                // Do some extra staff if stock type is bulk
                $stock = $stock_assign->stock;
                if ($stock_assign->stock->product->category->categoryType->entry_type == (string) Enum::CATEGORY_BULK) {

                    $alreadyReceived = StockAssign::whereHas('stock.product.category.categoryType', function ($query) {
                        $query->where('entry_type', (string) Enum::CATEGORY_BULK);
                    })->where('user_id', $value)->where('acknowledgement_status', 1)->count();

                    if ($alreadyReceived > 0) {
                        // Update acknowledgement status
                        $stock_assign->acknowledgement_status = true;
                        $stock_assign->save();
                        
                        // Update stock quantity
                        $stock->quantity -= $quantity[$key];
                        $stock->save();
                        
                        // Update product stock
                        $product = $stock_assign->stock->product;
                        $product->stock -= $quantity[$key];
                        $product->save();
                    }
                } else {
                    $stock->status = Enum::STOCK_ASSIGNED;
                    $stock->save();
                }

                // Store stock history
                $stock_assign['assign_id'] = $stock_assign->id;
                $stock_assign['location'] = $stock_assign->stock->location;
                $stock_assign['id'] = $stock_assign->stock_id;

                event(new StockHistoryEvent($stock_assign));
            }

            return $this->handleSuccess('Successfully Assigned');
        }
        catch (Exception $e) {
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
}

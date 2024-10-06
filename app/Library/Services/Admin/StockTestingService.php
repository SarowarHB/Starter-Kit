<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Library\Enum;
use App\Models\Stock;
use App\Models\StockTesting;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;


class StockTestingService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';

        if($row->id){
            $actionHtml = '
            <a class="dropdown-item" href="' . route('admin.ams.stock_testing.test', $row->id) . '" ><i class="fas fa-check"></i> Test</a>
            <a class="dropdown-item text-success" href="' . route('admin.ams.stock_testing.view', $row->id) . '" ><i class="fas fa-eye"></i> View</a>';
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

    private function getBadge($row){

        if($row->status == Enum::STOCK_AVAILABLE){
            $badge = '<div class="badge btn2-secondary">' . Enum::getStockStatus(Enum::STOCK_AVAILABLE) . '</div>';
        }
        else if ($row->status == Enum::STOCK_ASSIGNED){
            $badge = '<div class="badge badge-primary">' . Enum::getStockStatus(Enum::STOCK_ASSIGNED) . '</div>';
        }
        else if ($row->status == Enum::STOCK_WARRANTY){
            $badge = '<div class="badge badge-secondary">' . Enum::getStockStatus(Enum::STOCK_WARRANTY) . '</div>';
        }
        else if ($row->status == Enum::STOCK_DAMAGED){
            $badge = '<div class="badge badge-warning">' . Enum::getStockStatus(Enum::STOCK_DAMAGED) . '</div>';
        }
        else if ($row->status == Enum::STOCK_MISSING){
            $badge = '<div class="badge badge-dark">' . Enum::getStockStatus(Enum::STOCK_MISSING) . '</div>';
        }
        else if ($row->status == Enum::STOCK_EXPIRED){
            $badge = '<div class="badge badge-danger">' . Enum::getStockStatus(Enum::STOCK_EXPIRED) . '</div>';
        }else{
            $badge = '<div class="badge btn2-secondary">' . Enum::getStockStatus(Enum::STOCK_EXPIRED) . '</div>';
        }

        return $badge;
    }

    public function dataTable()
    {
        $next_month = now()->modify('+1 month')->format('Y-m-d');
        $data = Stock::where('testing_date', '<=', $next_month)->orderBy('id','desc')->get();

        return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('unique_id', function($row){
                    $user_role = User::getAuthUserRole();
                    return $user_role->hasPermission('stock_show') ? '<a class="text-primary" href="' . route('admin.ams.stock_testing.view', $row->id) . '" >'.$row->unique_id.'</a>' : $row->unique_id;
                })

                ->addColumn('type', function($row){
                    return $row->product->category->categoryType->name;
                })

                ->addColumn('category', function($row){
                    return $row->product->category->name;
                })

                ->addColumn('product', function($row){
                    return $row->product->name;
                })

                ->addColumn('testing_date', function($row){
                    return $row->testing_date ? $row->testing_date : 'N/A';
                })

                ->addColumn('unit_price', function($row){
                    return env('CURRENCY_SIGN').$row->unit_price;
                })

                ->addColumn('action', function($row){
                    return $this->actionHtml($row);
                })

                ->rawColumns(['unique_id', 'type', 'category', 'product', 'unit_price', 'action'])
                ->make(true);
    }

    public function storeTest(array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();
            $this->data = StockTesting::create($data);

            $stock = Stock::find($data['stock_id']);
            $stock->testing_date = $data['next_testing_date'];
            $stock->save();

            return $this->handleSuccess('Successfully created');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function update(StockTesting $stock_testing, array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();
            $this->data = $stock_testing->update($data);

            return $this->handleSuccess('Successfully Updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }
}

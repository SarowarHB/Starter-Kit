<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Models\User;
use App\Library\Enum;
use App\Models\Stock;
use App\Library\Helper;
use App\Models\Product;
use App\Models\StockAssign;
use App\Models\StockHistory;
use Illuminate\Support\Facades\DB;
use App\Events\Stock\StockHistoryEvent;
use Yajra\DataTables\Facades\DataTables;

class StockService extends BaseService
{
    private function filter(array $params)
    {
        $query = Stock::select('*');

        $query->where('status', $params['status']);

        return $query->get();
    }

    private function actionHtml($row)
    {
        $actionHtml = '';

        $user_role = User::getAuthUserRole();

        if($row->id){
            if($user_role->hasPermission('stock_show')){
                $actionHtml .= '<a class="dropdown-item text-primary" href="' . route('admin.ams.stock.show', $row->id) . '" ><i class="fas fa-eye"></i> View</a>';
            }
            if($user_role->hasPermission('stock_update')){
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.ams.stock.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }
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

    public function dataTable(array $filter_params)
    {
        $data = $this->filter($filter_params);

        return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('unique_id', function($row){
                    $user_role = User::getAuthUserRole();
                    return $user_role->hasPermission('stock_show') ? '<a class="text-primary" href="' . route('admin.ams.stock.show', $row->id) . '" >'.$row->unique_id.'</a>' : $row->unique_id;
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

                ->addColumn('unit_price', function($row){
                    return env('CURRENCY_SIGN').$row->unit_price;
                })

                ->addColumn('action', function($row){
                    return $this->actionHtml($row);
                })

                ->rawColumns(['unique_id', 'type', 'category', 'product', 'unit_price', 'action'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        DB::beginTransaction();
        try{
            $length = $data['quantity'];
            $data['operator_id'] = auth()->id();
            $data['status'] = Enum::STOCK_AVAILABLE;
            $product = Product::find($data['product_id']);
            $key = $product->category->categoryType->unique_key;

            if($product->category->categoryType->entry_type == Enum::CATEGORY_INDIVIDUAL)
            {
                for($i = 0; $i < $length; $i++)
                {
                    $data['unique_id'] = Helper::uniqueId($key);

                    unset($data['quantity']);
                    $data['quantity'] = 1;

                    $this->data = Stock::create($data);

                    $history = $this->data;
                    $history['type'] = $product->category->categoryType->name;
                    event(new StockHistoryEvent($history));
                }
            } else{
                $data['unique_id'] = Helper::uniqueId($key);
                $this->data = Stock::create($data);

                $history = $this->data;
                $history['type'] = $product->category->categoryType->name;
                event(new StockHistoryEvent($history));
            }

            $product->update([
                'stock' => $product->stock + $length,
            ]);

            DB::commit();
            $this->message = __('Successfully created');
            return true;
        }
        catch (Exception $e){
            Helper::log($e);
            DB::rollBack();
            return $this->handleException($e);
        }

    }

    public function update(Stock $stock, array $data): bool
    {
        DB::beginTransaction();
        try {
            $stockHistory = StockHistory::where('stock_id', $stock->id)->first();
            $product = Product::where('id', $stock->product_id)->first();

            $data['operator_id'] = auth()->id();

            StockHistory::where('stock_id', $stock->id)->first()->update([
                'quantity'  => $stockHistory->quantity - $stock->quantity + $data['quantity'],
                'location'  => $data['location'],
                'note'      => $data['note'],
                'operator_id' => auth()->id(),
            ]);

            Product::where('id', $stock->product_id)->update([
                // 'stock' => $product->stock - $stockHistory->quantity + $data['quantity']
                'stock' => $product->stock - $stock->quantity + $data['quantity']
            ]);

            // $data['quantity'] = $stock->quantity - $stockHistory->quantity + $data['quantity'];
            $data['quantity'] = $data['quantity'];
            $this->data = $stock->update($data);

            DB::commit();
            $this->message = __('Successfully updated');
            return true;
        }
        catch (Exception $e){
            Helper::log($e);
            DB::rollBack();
            return $this->handleException($e);
        }
    }

    public function changeStatus(Stock $stock, array $data): bool
    {
        DB::beginTransaction();
        try {
            $types = $stock->product->category->categoryType->entry_type;

            if($types == Enum::CATEGORY_INDIVIDUAL){
                $status = $data['status'];

                if($stock->status == Enum::STOCK_AVAILABLE){
                    $quantity = $stock->product->stock - 1;
                }elseif($data['status'] == Enum::STOCK_AVAILABLE){
                    $quantity = $stock->product->stock + 1;
                }else{
                    $quantity = $stock->product->stock;
                }

                $this->data = $stock->update([
                    'status' => $status,
                ]);

            } else {
                if($stock->product->stock >= $data['quantity'] && $data['quantity'] > 0){
                    if($data['status'] == Enum::STOCK_AVAILABLE){
                        $quantity = $stock->product->stock + $data['quantity'];
                    }elseif($data['status'] != Enum::STOCK_AVAILABLE){
                        $quantity = $stock->product->stock - $data['quantity'];
                    }else{
                        $quantity = $stock->product->stock;
                    }
                } else {
                    if($data['status'] == Enum::STOCK_AVAILABLE){
                        $quantity = $stock->product->stock + $data['quantity'];
                    }
                }

                $status = '';
                if($stock->product->stock == 0 && $data['quantity'] > 0 && $data['status'] == Enum::STOCK_AVAILABLE){
                    $status = $data['status'];
                }
                elseif($stock->product->stock > 0 && $quantity > 0){
                    $status = $stock->status;
                }
                elseif($quantity == 0){
                    $status = Enum::STOCK_OUT;
                }
                // $status = $quantity > 0 ? $stock->status : Enum::STOCK_OUT;
                // dd($status);

                $this->data = $stock->update([
                    'status' => $status,
                    'quantity' => $quantity,
                ]);
            }

            Product::find($stock->product_id)->update([
                'stock' => $quantity,
            ]);

            $history = $stock;
            $history['status'] = $data['status'];
            $history['note'] = $data['note'];
            $history['type'] = $stock->product->category->categoryType->name;
            $history['quantity'] = $types == Enum::CATEGORY_BULK ? $data['quantity'] : $stock->quantity;

            event(new StockHistoryEvent($history));

            DB::commit();
            $this->message = __('Successfully created');
            return true;
        }
        catch (Exception $e){
            Helper::log($e);
            DB::rollBack();
            return $this->handleException($e);
        }
    }

    public function delete(Stock $stock): bool
    {
        DB::beginTransaction();
        try {
            $assignData = StockAssign::where('stock_id', $stock->id)->count('id');
            $historyData = StockHistory::where('stock_id', $stock->id)->count('id');

            if($assignData == 0 && $historyData <= 1){

                StockHistory::where('stock_id', $stock->id)->delete();
                $stock->delete();

                Product::where('id', $stock->product_id)->update([
                    'stock' => $stock->product->stock - $stock->quantity,
                ]);
            }

            DB::commit();
            $this->message = __('Successfully deleted');
            return true;
        }
        catch (Exception $e){
            Helper::log($e);
            DB::rollBack();
            return $this->handleException($e);
        }
    }
}

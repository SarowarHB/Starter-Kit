<?php

namespace App\Library\Services\Admin;

use App\Library\Enum;
use App\Library\Helper;
use App\Models\Asset;
use App\Models\AssetSale;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Illuminate\Support\Facades\DB;


class AssetService extends BaseService
{
    private function filter(array $params)
    {
        $query = Asset::select('*');
        if (isset($params['is_deleted']) && $params['is_deleted'] == 1) {
            $query->onlyTrashed();
        }
        else if(isset($params['status'])){
            $query->where('status', $params['status']);
        }
        return $query->get();
    }


    private function actionHtml($row)
    {
        $actionHtml = '';

        if($row->id){
            $actionHtml = '<a class="dropdown-item text-primary" href="' . route('admin.asset.show', $row->id) . '" ><i class="fas fa-eye"></i> View</a>
            <a class="dropdown-item" href="' . route('admin.asset.update', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
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
                
                ->addColumn('created_by', function($row){
                    return $row->user->nick_name;
                })

                ->addColumn('name', function($row){
                    $user_role = User::getAuthUserRole();
                    $name = $row->name;
                    return !$user_role->hasPermission('asset_show') || $row->deleted_at || $row->id == null ? $name : '<a href="' . route('admin.asset.show', $row->id) . '" class="text-success pr-2">'. $name .'</a>';
                })
                
                ->addColumn('stock', function($row){
                    return $row->stock <= 0 ? '<span class="badge btn-danger">Stock Out</span>' : '<span class="badge btn2-secondary">'.$row->stock.'</span>' ;
                })
                
                ->addColumn('action', function($row){
                    return $this->actionHtml($row);
                })
                ->rawColumns(['created_by', 'stock', 'action', 'name'])
                ->make(true);
    }

    public function createAsset(array $data): bool
    {
        try {
            $data['stock'] = $data['quantity'];
            $data['created_by'] = User::getAuthUser()->id;

            if(isset($data['attachments'])){
                $data['attachments'] = Helper::uploadImage($data['attachments'], Enum::ASSET_DOCUMENTS, 200, 200);
            }

            $this->data = Asset::create($data);

            return $this->handleSuccess('Successfully created');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function updateAsset(Asset $asset, array $data): bool
    {
        try {
            $data['stock'] = $data['quantity'];
            $data['created_by'] = User::getAuthUser()->id;

            if(isset($data['attachments'])){
                $data['attachments'] = Helper::uploadImage($data['attachments'], Enum::ASSET_DOCUMENTS, 200, 200);
            }
            $this->data = $asset->update($data);

            return $this->handleSuccess('Successfully Updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function changeStatus(Asset $asset, string $data): bool
    {
        try {
            $this->data = $asset->update(['status' => $data]);
            return $this->handleSuccess('Successfully Updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    private function saleActionHtml($row)
    {
        if($row->id){
            $actionHtml = '<a class="dropdown-item text-primary" href="' . route('admin.asset.sale.show', [$row->asset_id, $row->id]) . '" ><i class="fas fa-eye"></i> View</a>
            <a class="dropdown-item" href="' . route('admin.asset.sale.update', [$row->asset_id, $row->id]) . '" ><i class="far fa-edit"></i> Edit</a>';
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

    public function assetSaleDataTable()
    {
        $data = AssetSale::select('*');
        return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('lose_or_profit', function($row){
                        return $row->lose_or_profit < 0 ? '<span class="badge btn-danger">'.$row->lose_or_profit.'</span>' : '<span class="badge btn2-secondary">'.$row->lose_or_profit.'</span>';
                    })
                    ->addColumn('action', function($row){
                        return $this->saleActionHtml($row);
                    })
                    ->rawColumns(['lose_or_profit', 'action'])
                    ->make(true);
    }

    public function createAssetSale(Asset $asset, array $data): bool
    {
        DB::beginTransaction();
        try {
            $depreciation_cost = ($data['price'] * $data['quantity']) - ($asset->price * $data['quantity']);

            $data['lose_or_profit'] = $depreciation_cost;
            $data['created_by'] = User::getAuthUser()->id;

            $this->data = AssetSale::create($data);

            $asset->update([
                'stock' => $asset->stock - $data['quantity'],
            ]);

            DB::commit();
            return $this->handleSuccess('Successfully Created');

        } catch (Exception $e) {
            DB::rollback();
            return $this->handleException($e);
        }
    }

    public function updateAssetSale(Asset $asset, AssetSale $assetSale, array $data): bool
    {
        DB::beginTransaction();
        try{
            $pre_sale_quan = $assetSale->quantity;

            $depreciation_cost = ($data['price'] * $data['quantity']) - ($asset->price * $data['quantity']);

            $data['lose_or_profit'] = $depreciation_cost;
            $data['created_by'] = User::getAuthUser()->id;

            $this->data = $assetSale->update($data);

            $asset->update([
                'stock' => $asset->stock + $pre_sale_quan - $data['quantity'],
            ]);

            DB::commit();
            return $this->handleSuccess('Successfully Updated');
        }
        catch (\Exception $e){
            DB::rollBack();
            return $this->handleException($e);
        }
    }
}

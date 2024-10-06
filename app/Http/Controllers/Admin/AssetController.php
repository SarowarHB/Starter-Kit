<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Asset\CreateRequest;
use App\Http\Requests\Admin\Asset\UpdateRequest;
use App\Http\Requests\Admin\AssetSale\CreateRequest as AssetSaleCreateRequest;
use App\Http\Requests\Admin\AssetSale\UpdateRequest as AssetSaleUpdateRequest;
use App\Http\Traits\ApiResponse;
use App\Library\Enum;
use App\Library\Services\Admin\AssetService;
use App\Library\Services\Admin\ConfigService;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\AssetSale;

class AssetController extends Controller
{
    /*------========= service container Using Constructor Injection =========--------*/
    use ApiResponse;
    private $asset_service;

    function __construct(AssetService $asset_service)
    {
        $this->asset_service = $asset_service;
    }

    /*------=============== Asset Section Start ==========--------------*/
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $filter_request = $request->only(['status', 'is_deleted']);
            return $this->asset_service->dataTable($filter_request);
        }
        return view('admin.pages.asset.index');
    }

    public function show(Asset $asset)
    {
        abort_unless($asset , 404);
        return view('admin.pages.asset.show',[
            'asset' => $asset
        ]);
    }

    public function showCreateForm()
    {
        return view('admin.pages.asset.create',[
            'asset_type'  => ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_ASSET_TYPE)
        ]);
    }

    public function create(CreateRequest $request)
    {
        $result = $this->asset_service->createAsset($request->validated());

        if($result)
            return redirect()->route('admin.asset.index')->with('success', $this->asset_service->message);

        return back()->withInput($request->all())->with('error', $this->asset_service->message);

    }

    public function showUpdateForm(Asset $asset)
    {
        abort_unless($asset, 404);
        return view('admin.pages.asset.update',[
            'asset'      => $asset,
            'asset_type'  => ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_ASSET_TYPE)
        ]);
    }

    public function update(Asset $asset, UpdateRequest $request)
    {
        abort_unless($asset , 404);
        $result = $this->asset_service->updateAsset($asset, $request->validated());
        if($result)
            return redirect()->route('admin.asset.show', $asset->id)->with('success', $this->asset_service->message);

        return back()->withInput($request->all())->with('error', $this->asset_service->message);
    }

    public function changeStatusApi(Asset $asset, Request $request)
    {
        abort_unless($asset , 404);
        $result = $this->asset_service->changeStatus($asset, $request->status);
        if($result)
            return redirect()->route('admin.asset.show', $asset->id)->with('success', $this->asset_service->message);

        return back()->withInput($request->all())->with('error', $this->asset_service->message);
    }
    /*------=============== Asset Section End ==========--------------*/


    /*------=============== Asset Sale Module Start ==========--------------*/
    public function saleIndex(Request $request)
    {
        if ($request->ajax()) {
            return $this->asset_service->assetSaleDataTable();
        }
        return view('admin.pages.asset.sale.index');
    }

    public function saleShow(Asset $asset, AssetSale $assetSale)
    {
        abort_unless($assetSale , 404);
        return view('admin.pages.asset.sale.show',[
            'assetSale' => $assetSale
        ]);
    }

    public function showCreateSaleForm(Asset $asset)
    {
        return view('admin.pages.asset.sale.create',[
            'asset' => $asset,
        ]);
    }

    public function saleCreate(Asset $asset, AssetSaleCreateRequest $request)
    {
        $result = $this->asset_service->createAssetSale($asset, $request->validated());

        if($result)
            return redirect()->route('admin.asset.sale.index')->with('success', $this->asset_service->message);

        return back()->withInput($request->all())->with('error', $this->asset_service->message);
    }

    public function saleShowUpdateForm(Asset $asset, AssetSale $assetSale)
    {
        abort_unless($assetSale, 404);
        return view('admin.pages.asset.sale.update', [
            'asset'      => $asset,
            'assetSale'  => $assetSale,
        ]);
    }

    public function updateAssetSale(Asset $asset, AssetSale $assetSale, AssetSaleUpdateRequest $request)
    {
        $result = $this->asset_service->updateAssetSale($asset, $assetSale, $request->validated());

        if($result)
            return redirect()->route('admin.asset.sale.index')->with('success', $this->asset_service->message);

        return back()->withInput($request->all())->with('error', $this->asset_service->message);
    }
    /*------=============== Asset Sale Module End ==========--------------*/
}

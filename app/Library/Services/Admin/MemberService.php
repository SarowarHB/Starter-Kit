<?php


namespace App\Library\Services\Admin;

use Exception;
use App\Library\Enum;
use App\Library\Helper;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Member;
use App\Models\User;
use App\Models\StockAssign;
use Illuminate\Support\Facades\DB;
use App\Events\Stock\StockHistoryEvent;
use Yajra\DataTables\Facades\DataTables;

class MemberService extends BaseService
{

    private function filter(array $params)
    {
        $query =  User::select('members.id as member_id', 'members.*', 'users.*')
                        ->join('members', 'users.id', '=', 'members.user_id')
                        ->where('user_type', Enum::USER_TYPE_MEMBER);

        if (isset($params['is_deleted']) && $params['is_deleted'] == 1) {
            $query->onlyTrashed();
            $query->whereNotNull('members.deleted_at');
        }
        else if (isset($params['status'])) {
            $query->where('is_active', $params['status']);
            $query->whereNull('members.deleted_at');
        }
        return $query->get();
    }

    private function actionHtml($row)
    {
        $user_role =  User::getAuthUserRole();
        $actionHtml = '';
        if ($user_role->hasPermission('user_restore') && $row->deleted_at) {
            $actionHtml .=  '<a class="dropdown-item text-secondary" href="javascript:void(0)" onclick="confirmModal(restoreMember, '. $row->id .', \'Are you sure to restore operation?\')" ><i class="fas fa-trash-restore-alt"></i> Restore</a>';
        }
        else if($row->member_id && !$row->deleted_at){
            if($user_role->hasPermission('member_show')){
                $actionHtml .= '<a class="dropdown-item text-primary" href="' . route('admin.member.show', $row->member_id) . '" ><i class="fas fa-eye"></i> View</a>';
            }
            if($user_role->hasPermission('member_update')){
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.member.update', $row->member_id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }
        }
        else{
            $actionHtml = '';
        }
        return '<div class="action dropdown">
                    <button class="btn btn2-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                ->addColumn('name', function($row) {
                    $user_role =  User::getAuthUserRole();
                    $name = $row->full_name;
                    return !$user_role->hasPermission('member_show') || $row->deleted_at || $row->member_id == null ? $name : '<a href="' . route('admin.member.show', $row->member_id) . '" class="text-success pr-2">'. $name .'</a>';
                })
                ->addColumn('country', function($row){
                    return Helper::getCountryName($row->country);
                })
                ->addColumn('action', function($row){
                    return $this->actionHtml($row);
                })
                ->editColumn('id', function($row){
                    return "D{$row->id}";
                })
                ->rawColumns(['name', 'is_adult', 'action'])
                ->make(true);

    }

    public function createMember(array $data): bool
    {
       DB::beginTransaction();
       try {
            $user = $data['user'];
            $user['user_type'] = Enum::USER_TYPE_MEMBER;
            unset($data['user']);
            $user['password'] = bcrypt($user['password']);
            $data['user_id'] =  User::create($user)->id;

            if(isset($data['profile_image'])){
                $data['profile_image'] = Helper::uploadImage($data['profile_image'], Enum::MEMBER_PROFILE_IMAGE_DIR, 200, 200);
            }
            if(isset($data['photo_id'])){
                $data['photo_id'] = Helper::uploadImage($data['photo_id'], Enum::MEMBER_NID_IMAGE_DIR, 200, 200);
            }
            $this->data = Member::create($data);
            DB::commit();
            return $this->handleSuccess('Successfully created');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function updateMember(Member $member, array $data)
    {
        DB::beginTransaction();
        try {
            $user = $data['user'];
            $member->user()->update($user);
            unset($data['user']);

            if(isset($data['profile_image'])){
                $data['profile_image'] = Helper::uploadImage($data['profile_image'], Enum::MEMBER_PROFILE_IMAGE_DIR, 200, 200);
            }
            if(isset($data['photo_id'])){
                $data['photo_id'] = Helper::uploadImage($data['photo_id'], Enum::MEMBER_NID_IMAGE_DIR, 200, 200);
            }
            $member->update($data);
            DB::commit();
            return $this->handleSuccess('Successfully updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function acceptStock(StockAssign $assign)
    {
        try {
            $data['received_by'] = auth()->id();
            $data['received_at'] = now();
            $data['acknowledgement_status'] = 1;
            $assign->update($data);

            // Do some extra staff if stock type is bulk
            $stock = $assign->stock;
            
            if ($assign->stock->product->category->categoryType->entry_type == (string) Enum::CATEGORY_BULK) {
                // Update stock quantity
                $stock->quantity -= $assign->quantity;
                $stock->save();
            }

            // Update product stock
            $product = $assign->stock->product;
            $product->stock -= $assign->quantity;
            $product->save();
            

            return $this->handleSuccess('Successfully Accepted');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function stockStatusChange(array $data)
    {
        DB::beginTransaction();
        try {

            $assign  = StockAssign::find($data['assign_id']);
            $assign['operator_id'] = auth()->id();
            $assign->update($data);

            $types = $assign->stock->product->category->categoryType->entry_type;
            $product = Product::where('id', $assign->stock->product->id)->first();

            if($types == Enum::CATEGORY_INDIVIDUAL){

                if($data['status'] == Enum::STOCK_RETURN){
                    Product::where('id', $assign->stock->product->id)->update([
                        'stock' => $product->stock + $assign->quantity,
                    ]);
                }

                Stock::where('id', $assign->stock_id)->update([
                    'status' => $data['status'],
                ]);

                $assign['assign_id'] = $assign->id;
                $assign['location'] = $assign->stock->location;
                $assign['id'] = $assign->stock_id;

                event(new StockHistoryEvent($assign));

            }

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

    public static function getByStatus(int $status)
    {
        return User::whereHas('member')->with('member')
            ->where('user_type', Enum::USER_TYPE_MEMBER)
            ->where('is_active', $status)
            ->get();
    }

    public static function findByUserId(int $user_id)
    {
        return User::whereHas('member')->with('member')
            ->where('user_type', Enum::USER_TYPE_MEMBER)
            ->where('id', $user_id)
            ->first();
    }

}

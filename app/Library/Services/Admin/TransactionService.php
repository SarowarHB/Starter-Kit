<?php


namespace App\Library\Services\Admin;

use Exception;
use App\Library\Enum;
use App\Library\Helper;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;
use App\Events\Account\AccountEvent;
use App\Events\Transaction\PaymentEvent;
use App\Events\Transaction\TransactionStatusChangeEvent;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TransactionService extends BaseService
{
    private function filter(array $params)
    {
        $query = Transaction::select('*');

        if (isset($params['is_deleted']) && $params['is_deleted'] == 1) {
            $query->onlyTrashed();
        }
        else if(isset($params['status'])){
            $query->where('payment_status', $params['status']);
        }

        return $query->get();
    }

    private function actionHtml($row)
    {
        $actionHtml = '';
        if (Helper::hasAuthRolePermission('transaction_show') && $row->deleted_at) {
            $actionHtml .=  '<a class="dropdown-item text-secondary" href="javascript:void(0)" onclick="confirmModal(restoreTransaction, '. $row->id .', \'Are you sure to restore operation?\')" ><i class="fas fa-trash-restore-alt"></i> Restore</a>';
        }
        else if(!$row->deleted_at) {
            if(Helper::hasAuthRolePermission('transaction_show')){
                $actionHtml .= '<a class="dropdown-item text-primary" href="' . route('admin.transaction.show', $row->id) . '" ><i class="fas fa-eye"></i> View</a>';
            }
            if(Helper::hasAuthRolePermission('transaction_update')){
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.transaction.update', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }
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
        return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('nick_name', function($row){
                    return $row->user->nick_name;
                })

                ->addColumn('user_type', function($row){
                    return ucwords($row->user->user_type);
                })
                ->addColumn('type', function($row){
                    return ucwords(str_replace('_', ' ', $row->type));
                })
                ->addColumn('payment_method', function($row){
                    return ucwords(str_replace('_', ' ', $row->payment_method));
                })
                ->addColumn('amount', function($row){
                    return ''.env('CURRENCY_SIGN').' '.number_format($row->amount, 2).'';
                })
                ->addColumn('payment_status', function($row){
                    return '<span class="badge badge-success">' . Enum::getPaymentStatus($row->payment_status) . '</span>';
                })

                ->addColumn('created_at', function($row) {
                    return $row->created_at->format('d-m-Y H:i A');
                })

                ->addColumn('action', function($row){
                    return $this->actionHtml($row);
                })
                ->rawColumns(['user_type', 'payment_status', 'action'])
                ->make(true);
    }


    public function updateTransaction(Transaction $transaction, array $data)
    {
        try{
            if(isset($data['attachment'])){
                $data['attachment'] = Helper::uploadFile($data['attachment'], Enum::TRANSACTION_FILE);
            }
            $transaction->update($data);
            $this->message = __('Successfully updated');
            return true;
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }


    public function updateStatus(Transaction $transaction, array $data)
    {
        DB::beginTransaction();
        try{
            if($data['comment'] == null)
                unset($data['comment']);

            $transaction->update($data);
            $this->message = __('Successfully updated');

            if($transaction->payment_status == Enum::PAYMENT_METHOD_COMPLETED){
                event(new PaymentEvent($transaction));
                event(new AccountEvent($transaction));
            }

            event(new TransactionStatusChangeEvent($transaction));

            DB::commit();
            return true;
        }
        catch (Exception $e){
            Helper::log($e);
            DB::rollBack();
            return $this->handleException($e);
        }
    }

    public function deleteTransaction(Transaction $transaction)
    {
        try{
            if($transaction->payment_status == Enum::PAYMENT_METHOD_COMPLETED){
                throw new  CustomException("You can not delete complete payment.");
            }

            $transaction->delete();
            $this->message = __('Successfully deleted');
            return true;
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function restoreTransaction($id)
    {
        try{
            Transaction::onlyTrashed()->find($id)->restore();
            $this->message = __('Successfully restored');
            return true;
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }


    public function manualDeposit(array $data): bool
    {
        try{
            $data['next_balance'] = $data['balance'] + $data['amount'];
            $this->data = $data;

            return $this->handleSuccess('Successfully created', $this->data);
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function createManualDeposit(array $data): bool
    {
        try{
            $data['action_by'] = Auth::user()->id;
            $data['type'] = Enum::TRANSACTION_TYPE_DEPOSIT;
            $data['payment_method'] = Enum::PAYMENT_METHOD_CASH;
            $data['payment_status'] = Enum::PAYMENT_METHOD_PENDING;

            $this->data = Transaction::create($data);
            return $this->handleSuccess('Successfully created', $this->data->id);
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

}

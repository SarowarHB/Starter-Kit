<?php


namespace App\Library\Services\Admin;

use App\Library\Enum;
use App\Library\Helper;
use App\Models\EmailSignature;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Illuminate\Support\Facades\DB;

class EmailSignatureService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';

        if($row->id){
            $actionHtml = '<a class="dropdown-item text-primary" href="javascript:void(0)" onclick="showViewEmailSignatureModal(\'' . $row->id .'\')" ><i class="fas fa-eye"></i> View</a>
            <a class="dropdown-item" href="' . route('admin.config.email_signature.update', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>
            <a class="dropdown-item text-danger" href="' . route('admin.config.email_signature.delete.api', $row->id) . '" ><i class="far fa-trash"></i> Delete</a>';
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
        $data = EmailSignature::all();
        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('signature', function($row){
                    return $row->signature;
                })
                ->addColumn('action', function($row){
                    return $this->actionHtml($row);
                })
                ->rawColumns(['action','signature'])
                ->make(true);
    }

    public function createEmailSignature(array $data): bool
    {
        try {
            $data['operator_id'] = User::getAuthUser()->id;
            EmailSignature::create($data);
            return $this->handleSuccess('Successfully Created');

        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function updateEmailSignature(EmailSignature $email_signature, array $data): bool
    {
        try {
            $data['operator_id'] = User::getAuthUser()->id;

            $email_signature->update($data);
            return $this->handleSuccess('Successfully Updated');
        }catch(Exception $e){
            return $this->handleException($e);
        }
    }
}

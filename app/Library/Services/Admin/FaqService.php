<?php


namespace App\Library\Services\Admin;

use App\Models\Faq;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class FaqService extends BaseService
{
    private function filter(array $params)
    {
        $query = Faq::select('*');
        if(isset($params['status'])){
            $query->where('is_active', $params['status']);
        }
        return $query->get();
    }

    private function actionHtml($row)
    {
        $actionHtml = '';

        if($row->id){
            $actionHtml = '<a class="dropdown-item text-primary" href="' . route('admin.website.faq.show', $row->id) . '" ><i class="fas fa-eye"></i> View</a>
            <a class="dropdown-item" href="' . route('admin.website.faq.update', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
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
        return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('is_active', function($row){
                    return $row->is_active ? '<i class="fas fa-check-circle"></i>' : '<i class="fa-solid fa-circle-xmark"></i>';
                })
                
                ->addColumn('action', function($row){
                    return $this->actionHtml($row);
                })
                ->rawColumns(['action','is_active'])
                ->make(true);
    }

    public function createFaq(array $data): bool
    {
        try {
            $data['created_by'] = User::getAuthUser()->id;
            Faq::create($data);
            return $this->handleSuccess('Successfully Created');

        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function updateFaq(Faq $faq, array $data): bool
    {
        try {
            $data['created_by'] = User::getAuthUser()->id;
            $faq->update($data);
            return $this->handleSuccess('Successfully Updated');

        }catch(Exception $e){
            return $this->handleException($e);
        }
    }
}

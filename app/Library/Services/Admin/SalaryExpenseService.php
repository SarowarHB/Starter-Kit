<?php


namespace App\Library\Services\Admin;

use App\Models\SalaryExpense;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class SalaryExpenseService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';

        if($row->id){
            $actionHtml = '<a class="dropdown-item text-primary" href="' . route('admin.expense.salary.show', $row->id) . '" ><i class="fas fa-eye"></i> View</a>
            <a class="dropdown-item text-primary" href="' . route('admin.expense.salary.update', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
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
        $data = SalaryExpense::select('*');

            return DataTables::of($data)
                    ->addIndexColumn()
                    
                    ->addColumn('name', function($row){
                        $name = $row->user->getFullNameAttribute();
                        return '<a class="text-success pr-2" href="' . route('admin.expense.salary.show', $row->id) . '">'.$name.'</a>';
                    })

                    ->addColumn('note', function($row){
                        return  isset($row->note) ? $row->note : 'N/A';
                    })
                    
                    ->addColumn('action', function($row){
                        return $this->actionHtml($row);
                    })
                    ->rawColumns(['name', 'action'])
                    ->make(true);
    }

    public function createSalaryExpense(array $data): bool
    {
        try {
            $data['created_by'] = User::getAuthUser()->id;
            $this->data =  SalaryExpense::create($data);
            return $this->handleSuccess('Successfully Created');
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function updateSalaryExpense(SalaryExpense $salary_expense, array $data): bool
    {
        // dd($salary_expense);
        try {
            $data['created_by'] = User::getAuthUser()->id;
            $this->data = $salary_expense->update($data);

            return $this->handleSuccess('Successfully updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

}

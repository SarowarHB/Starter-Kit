<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SalaryExpense\CreateRequest;
use App\Http\Requests\Admin\SalaryExpense\UpdateRequest;
use App\Library\Enum;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Library\Services\Admin\ConfigService;
use App\Library\Services\Admin\EmployeeService;
use App\Library\Services\Admin\SalaryExpenseService;
use App\Models\SalaryExpense;

;

class SalaryExpenseController extends Controller
{
        /*------========= Service container Using Constructor Injection =========--------*/
        use ApiResponse;
        private $salary_expense_service;
    
        function __construct(SalaryExpenseService $salary_expense_service)
        {
            $this->salary_expense_service = $salary_expense_service;
        }
    
        public function index(Request $request)
        {
            if ($request->ajax()) {
                return $this->salary_expense_service->dataTable();
            }
            return view('admin.pages.accounts.salary_expense.index');
        }
    
        public function showCreateForm()
        {
            return view('admin.pages.accounts.salary_expense.create', [
                'payment_methods'  => ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_PAYMENT_TYPE ),
                'employees'  => EmployeeService::getByStatus(Enum::USER_STATUS_ACTIVE)
            ]);
        }
    
        public function create(CreateRequest $request)
        {
            $result = $this->salary_expense_service->createSalaryExpense($request->validated());
    
            if($result)
                return redirect()->route('admin.expense.salary.index')->with('success', $this->salary_expense_service->message);
    
            return back()->withInput($request->all())->with('error', $this->salary_expense_service->message);
        }
    
        public function show(SalaryExpense $salary_expense)
        {
            abort_unless($salary_expense , 404);
            return view('admin.pages.accounts.salary_expense.show', [
                'salary_expense'  => $salary_expense,
            ]);
        }
    
        public function showUpdateForm(SalaryExpense $salary_expense)
        {
            abort_unless($salary_expense , 404);
            return view('admin.pages.accounts.salary_expense.update', [
                'salary_expense'  => $salary_expense,
                'payment_methods'  => ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_PAYMENT_TYPE ),
                'employees'  => EmployeeService::getByStatus(Enum::USER_STATUS_ACTIVE)
            ]);
        }
    
        public function update(SalaryExpense $salary_expense, UpdateRequest $request)
        {
            abort_unless($salary_expense , 404);
            $result = $this->salary_expense_service->updateSalaryExpense($salary_expense, $request->validated());
            if($result)
                return redirect()->route('admin.expense.salary.index')->with('success', $this->salary_expense_service->message);
            else
                return back()->withInput(request()->all())->with('error', $this->salary_expense_service->message);
        }
    
        public function deleteApi(SalaryExpense $salary_expense)
        {
            abort_unless($salary_expense , 404);
            $salary_expense->delete();
            if($salary_expense)
                return redirect()->route('admin.expense.salary.index')->with('success', __('Successfully Deleted'));
            else
                return back()->with('error', 'Unable to delete now');
        }
}

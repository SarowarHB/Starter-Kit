<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Expense\CreateRequest;
use App\Http\Requests\Admin\Expense\UpdateRequest;
use App\Library\Enum;
use App\Library\Services\Admin\ConfigService;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Http\Traits\ApiResponse;
use App\Library\Services\Admin\ExpenseService;

class GeneralExpenseController extends Controller
{
    /*------========= Service container Using Constructor Injection =========--------*/
    use ApiResponse;
    private $expense_service;

    function __construct(ExpenseService $expense_service)
    {
        $this->expense_service = $expense_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->expense_service->dataTable();
        }
        return view('admin.pages.accounts.expense.index');
    }

    public function showCreateForm()
    {
        return view('admin.pages.accounts.expense.create', [
            'expense_type'  => ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_EXPENSE_TYPE)
        ]);
    }

    public function create(CreateRequest $request)
    {
        $result = $this->expense_service->createExpense($request->validated());

        if($result)
            return redirect()->route('admin.expense.general.index')->with('success', $this->expense_service->message);

        return back()->withInput($request->all())->with('error', $this->expense_service->message);
    }

    public function show(Expense $expense)
    {
        abort_unless($expense , 404);
        return view('admin.pages.accounts.expense.show', [
            'expense'  => $expense,
        ]);
    }

    public function showUpdateForm(Expense $expense)
    {
        abort_unless($expense , 404);
        return view('admin.pages.accounts.expense.update', [
            'expense'  => $expense,
            'expense_type'  => ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_EXPENSE_TYPE)
        ]);
    }

    public function update(Expense $expense, UpdateRequest $request)
    {
        abort_unless($expense , 404);
        $result = $this->expense_service->updateExpense($expense, $request->validated());
        if($result)
            return redirect()->route('admin.expense.general.index')->with('success', $this->expense_service->message);
        else
            return back()->withInput(request()->all())->with('error', $this->expense_service->message);
    }

    public function deleteApi(Expense $expense)
    {
        abort_unless($expense , 404);
        $expense->delete();

        if($expense)
            return redirect()->route('admin.expense.general.index')->with('success', __('Successfully Deleted'));
        else
            return back()->with('error', 'Unable to delete now');
    }
}

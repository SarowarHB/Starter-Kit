<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Models\Role;
use App\Library\Enum;
use App\Models\Config;
use App\Library\Helper;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Models\EmergencyContact;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\ConfigService;
use App\Library\Services\Admin\EmployeeService;
use App\Http\Requests\Admin\Employee\CreateRequest;
use App\Http\Requests\Admin\Employee\UpdateRequest;

class EmployeeController extends Controller
{
    use ApiResponse;

    private $employee_service;

    function __construct(EmployeeService $employee_service)
    {
        $this->employee_service = $employee_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $filter_request = $request->only(['status', 'is_deleted']);
            return $this->employee_service->dataTable($filter_request);
        }
        return view('admin.pages.employee.index');
    }

    public function show(Employee $employee)
    {
        abort_unless($employee->user , 404);
        return view('admin.pages.employee.show',[
            'employee'          => $employee,
            'emergency_contact' => $employee->user->emergency,
            'user_id'           => $employee->user_id,
            'countries'         => Helper::getCountries(),
            'assigns'           => $employee->user->assigns,
            'stock_status'            => Enum::getStockStatus(),
        ]);
    }

    public function showCreateForm()
    {
        return view('admin.pages.employee.create',[
            'countries'     => Helper::getCountries(),
            'roles'         => Role::getAll(),
            'designations'  => ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_EMP_DESIGNATION),
        ]);
    }

    public function create(CreateRequest $request)
    {
        $result = $this->employee_service->createEmployee($request->validated());

        if($result)
            return redirect()->route('admin.employee.index', $this->employee_service->data)->with('success', $this->employee_service->message);

        return back()->withInput($request->all())->with('error', $this->employee_service->message);
    }

    public function showUpdateForm(Employee $employee)
    {
        abort_unless($employee->user , 404);
        return view('admin.pages.employee.update',[
            'employee'      => $employee,
            'countries'     => Helper::getCountries(),
            'roles'         => Role::getAll(),
            'designations'  => ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_EMP_DESIGNATION),
        ]);
    }

    public function update(Employee $employee, UpdateRequest $request)
    {
        abort_unless($employee->user , 404);
        $result = $this->employee_service->updateEmployee($employee, $request->validated());
        if($result)
            return redirect()->route('admin.employee.show', $employee->id)->with('success', $this->employee_service->message);

        return back()->withInput($request->all())->with('error', $this->employee_service->message);
    }


}

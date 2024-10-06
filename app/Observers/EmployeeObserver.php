<?php

namespace App\Observers;

use App\Library\Helper;
use App\Models\Employee;

class EmployeeObserver
{
    /**
     * Handle the Employee "created" event.
     *
     * @param  \App\Models\Employee  $employee
     * @return void
     */
    public function created(Employee $employee)
    {
        $difference = Helper::getDifference($employee, false, true);

        Helper::createActivityLog('Updated', 'Employee', $employee->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Employee "updated" event.
     *
     * @param  \App\Models\Employee  $employee
     * @return void
     */
    public function updated(Employee $employee)
    {
        $difference = Helper::getDifference($employee, true);

        Helper::createActivityLog('Updated', 'Employee', $employee->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Employee "deleted" event.
     *
     * @param  \App\Models\Employee  $employee
     * @return void
     */
    public function deleted(Employee $employee)
    {
        $difference = Helper::getDifference($employee);

        Helper::createActivityLog('Deleted', 'Employee', $employee->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Employee "restored" event.
     *
     * @param  \App\Models\Employee  $employee
     * @return void
     */
    public function restored(Employee $employee)
    {
        $difference = Helper::getDifference($employee);

        Helper::createActivityLog('Restored', 'Employee', $employee->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Employee "force deleted" event.
     *
     * @param  \App\Models\Employee  $employee
     * @return void
     */
    public function forceDeleted(Employee $employee)
    {
        $difference = Helper::getDifference($employee);

        Helper::createActivityLog('Force Deleted', 'Employee', $employee->id, $difference, request()->ip(), request()->userAgent());
    }
}

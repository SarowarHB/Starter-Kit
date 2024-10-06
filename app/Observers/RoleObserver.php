<?php

namespace App\Observers;

use App\Models\Role;
use App\Library\Helper;

class RoleObserver
{
    /**
     * Handle the Role "created" event.
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function created(Role $role)
    {
        $difference = Helper::getDifference($role, false, true);

        Helper::createActivityLog('Created', 'Role', $role->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Role "updated" event.
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function updated(Role $role)
    {
        $difference = Helper::getDifference($role, true);

        Helper::createActivityLog('Updated', 'Role', $role->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Role "deleted" event.
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function deleted(Role $role)
    {
        $difference = Helper::getDifference($role);

        Helper::createActivityLog('Deleted', 'Role', $role->id, $difference, request()->ip(), request()->userAgent());
        
    }

    /**
     * Handle the Role "restored" event.
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function restored(Role $role)
    {
        $difference = Helper::getDifference($role);

        Helper::createActivityLog('Restored', 'Role', $role->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Role "force deleted" event.
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function forceDeleted(Role $role)
    {
        $difference = Helper::getDifference($role);

        Helper::createActivityLog('Force Deleted', 'Role', $role->id, $difference, request()->ip(), request()->userAgent());
    }
}

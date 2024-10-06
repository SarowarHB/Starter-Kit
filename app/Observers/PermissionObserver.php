<?php

namespace App\Observers;

use App\Library\Helper;
use App\Models\Permission;

class PermissionObserver
{
    /**
     * Handle the Permission "created" event.
     *
     * @param  \App\Models\Permission  $permission
     * @return void
     */
    public function created(Permission $permission)
    {
        $difference = Helper::getDifference($permission, false, true);

        Helper::createActivityLog('Created', 'Permission', $permission->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Permission "updated" event.
     *
     * @param  \App\Models\Permission  $permission
     * @return void
     */
    public function updated(Permission $permission)
    {
        $difference = Helper::getDifference($permission, true);

        Helper::createActivityLog('Updated', 'Permission', $permission->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Permission "deleted" event.
     *
     * @param  \App\Models\Permission  $permission
     * @return void
     */
    public function deleted(Permission $permission)
    {
        $difference = Helper::getDifference($permission);

        Helper::createActivityLog('Deleted', 'Permission', $permission->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Permission "restored" event.
     *
     * @param  \App\Models\Permission  $permission
     * @return void
     */
    public function restored(Permission $permission)
    {
        $difference = Helper::getDifference($permission);

        Helper::createActivityLog('Restore', 'Permission', $permission->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Permission "force deleted" event.
     *
     * @param  \App\Models\Permission  $permission
     * @return void
     */
    public function forceDeleted(Permission $permission)
    {
        $difference = Helper::getDifference($permission);

        Helper::createActivityLog('Force Deleted', 'Permission', $permission->id, $difference, request()->ip(), request()->userAgent());
    }
}

<?php

namespace App\Observers;

use App\Library\Helper;
use App\Models\Member;

class MemberObserver
{
    /**
     * Handle the Member "created" event.
     *
     * @param  \App\Models\Member  $member
     * @return void
     */
    public function created(Member $member)
    {
        $difference = Helper::getDifference($member, false, true);

        Helper::createActivityLog('Created', 'Member', $member->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Member "updated" event.
     *
     * @param  \App\Models\Member  $member
     * @return void
     */
    public function updated(Member $member)
    {   
        $difference = Helper::getDifference($member, true);

        Helper::createActivityLog('Updated', 'Member', $member->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Member "deleted" event.
     *
     * @param  \App\Models\Member  $member
     * @return void
     */
    public function deleted(Member $member)
    {
        $difference = Helper::getDifference($member);

        Helper::createActivityLog('Deleted', 'Member', $member->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Member "restored" event.
     *
     * @param  \App\Models\Member  $member
     * @return void
     */
    public function restored(Member $member)
    {
        $difference = Helper::getDifference($member);

        Helper::createActivityLog('Restored', 'Member', $member->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Member "force deleted" event.
     *
     * @param  \App\Models\Member  $member
     * @return void
     */
    public function forceDeleted(Member $member)
    {
        $difference = Helper::getDifference($member);

        Helper::createActivityLog('Force Deleted', 'Member', $member->id, $difference, request()->ip(), request()->userAgent());
    }
}

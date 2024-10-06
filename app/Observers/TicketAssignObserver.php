<?php

namespace App\Observers;

use App\Library\Helper;
use App\Models\TicketAssign;

class TicketAssignObserver
{
    /**
     * Handle the TicketAssign "created" event.
     *
     * @param  \App\Models\TicketAssign  $ticketAssign
     * @return void
     */
    public function created(TicketAssign $ticketAssign)
    {
        $difference = Helper::getDifference($ticketAssign, false, true);

        Helper::createActivityLog('Created', 'Ticket Assign', $ticketAssign->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the TicketAssign "updated" event.
     *
     * @param  \App\Models\TicketAssign  $ticketAssign
     * @return void
     */
    public function updated(TicketAssign $ticketAssign)
    {
        $difference = Helper::getDifference($ticketAssign, true);

        Helper::createActivityLog('Updated', 'Ticket Assign', $ticketAssign->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the TicketAssign "deleted" event.
     *
     * @param  \App\Models\TicketAssign  $ticketAssign
     * @return void
     */
    public function deleted(TicketAssign $ticketAssign)
    {
        $difference = Helper::getDifference($ticketAssign);

        Helper::createActivityLog('Deleted', 'Ticket Assign', $ticketAssign->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the TicketAssign "restored" event.
     *
     * @param  \App\Models\TicketAssign  $ticketAssign
     * @return void
     */
    public function restored(TicketAssign $ticketAssign)
    {
        $difference = Helper::getDifference($ticketAssign);

        Helper::createActivityLog('Restored', 'Ticket Assign', $ticketAssign->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the TicketAssign "force deleted" event.
     *
     * @param  \App\Models\TicketAssign  $ticketAssign
     * @return void
     */
    public function forceDeleted(TicketAssign $ticketAssign)
    {
        $difference = Helper::getDifference($ticketAssign);

        Helper::createActivityLog('Force Deleted', 'Ticket Assign', $ticketAssign->id, $difference, request()->ip(), request()->userAgent());
    }
}

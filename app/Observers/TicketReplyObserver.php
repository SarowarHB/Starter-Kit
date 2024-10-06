<?php

namespace App\Observers;

use App\Library\Helper;
use App\Models\TicketReply;

class TicketReplyObserver
{
    /**
     * Handle the TicketReply "created" event.
     *
     * @param  \App\Models\TicketReply  $ticketReply
     * @return void
     */
    public function created(TicketReply $ticketReply)
    {
        $difference = Helper::getDifference($ticketReply, false, true);

        Helper::createActivityLog('Created', 'Ticket Reply', $ticketReply->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the TicketReply "updated" event.
     *
     * @param  \App\Models\TicketReply  $ticketReply
     * @return void
     */
    public function updated(TicketReply $ticketReply)
    {
        $difference = Helper::getDifference($ticketReply);

        Helper::createActivityLog('Updated', 'Ticket Reply', $ticketReply->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the TicketReply "deleted" event.
     *
     * @param  \App\Models\TicketReply  $ticketReply
     * @return void
     */
    public function deleted(TicketReply $ticketReply)
    {
        $difference = Helper::getDifference($ticketReply);

        Helper::createActivityLog('Deleted', 'Ticket Reply', $ticketReply->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the TicketReply "restored" event.
     *
     * @param  \App\Models\TicketReply  $ticketReply
     * @return void
     */
    public function restored(TicketReply $ticketReply)
    {
        $difference = Helper::getDifference($ticketReply);

        Helper::createActivityLog('Deleted', 'Ticket Reply', $ticketReply->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the TicketReply "force deleted" event.
     *
     * @param  \App\Models\TicketReply  $ticketReply
     * @return void
     */
    public function forceDeleted(TicketReply $ticketReply)
    {
        $difference = Helper::getDifference($ticketReply);

        Helper::createActivityLog('Force Deleted', 'Ticket Reply', $ticketReply->id, $difference, request()->ip(), request()->userAgent());
    }
}

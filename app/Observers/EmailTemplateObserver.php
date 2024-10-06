<?php

namespace App\Observers;

use App\Library\Helper;
use App\Models\EmailTemplate;

class EmailTemplateObserver
{
    /**
     * Handle the EmailTemplate "created" event.
     *
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * @return void
     */
    public function created(EmailTemplate $emailTemplate)
    {
        $difference = Helper::getDifference($emailTemplate, false, true);

        Helper::createActivityLog('Created', 'Email Template', $emailTemplate->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the EmailTemplate "updated" event.
     *
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * @return void
     */
    public function updated(EmailTemplate $emailTemplate)
    {
        $difference = Helper::getDifference($emailTemplate, true);

        Helper::createActivityLog('Updated', 'Email Template', $emailTemplate->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the EmailTemplate "deleted" event.
     *
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * @return void
     */
    public function deleted(EmailTemplate $emailTemplate)
    {
        $difference = Helper::getDifference($emailTemplate);

        Helper::createActivityLog('Deleted', 'Email Template', $emailTemplate->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the EmailTemplate "restored" event.
     *
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * @return void
     */
    public function restored(EmailTemplate $emailTemplate)
    {
        $difference = Helper::getDifference($emailTemplate);

        Helper::createActivityLog('Restored', 'Email Template', $emailTemplate->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the EmailTemplate "force deleted" event.
     *
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * @return void
     */
    public function forceDeleted(EmailTemplate $emailTemplate)
    {
        $difference = Helper::getDifference($emailTemplate);

        Helper::createActivityLog('Force Deleted', 'Email Template', $emailTemplate->id, $difference, request()->ip(), request()->userAgent());
    }
}

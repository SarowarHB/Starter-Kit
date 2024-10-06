<?php

namespace App\Listeners\Notification;

use App\Events\Notification\DeleteEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteListener
{
    public function __construct()
    {
        //
    }

    public function handle(DeleteEvent $event)
    {
        $data = $event->notification;
        //get all delected notification data
    }
}

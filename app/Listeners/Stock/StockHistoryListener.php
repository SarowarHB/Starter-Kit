<?php

namespace App\Listeners\Stock;

use App\Events\Stock\StockHistoryEvent;
use App\Models\StockHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StockHistoryListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Stock\StockHistoryEvent  $event
     * @return void
     */
    public function handle(StockHistoryEvent $event)
    {
       $event = $event->stock;

        $data               = new StockHistory();
        $data->stock_id     = $event->id;
        $data->assign_id    = $event->assign_id;
        $data->quantity     = $event->quantity;
        $data->status       = $event->status;
        $data->location     = $event->location;
        $data->note         = $event->note;
        $data->operator_id  = auth()->id();
        $data->date         = now();
        $data->save();
    }
}

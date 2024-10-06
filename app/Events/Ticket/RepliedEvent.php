<?php

namespace App\Events\Ticket;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RepliedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $ticket_reply;


    public function __construct($ticket_reply)
    {
        $this->ticket_reply = $ticket_reply;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

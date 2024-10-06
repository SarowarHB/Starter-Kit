<?php

namespace App\Listeners\Ticket;

use App\Events\Ticket\RepliedEvent;
use App\Library\Enum;
use App\Library\Helper;
use App\Library\Services\Admin\EmailService;
use App\Models\EmailTemplate;
use App\Mail\DefaultMail;
use App\Models\TicketReply;
use Illuminate\Support\Facades\Mail;

class RepliedListener
{
    public function __construct()
    {
        //
    }

    public function handle(RepliedEvent $event)
    {
        $this->sendEmailNotification($event->ticket_reply);
    }

    private function sendEmailNotification(TicketReply $ticket_reply)
    {
        if($ticket_reply->is_admin_reply == 1){
            $sender_user = $ticket_reply->ticket->user;
        }
        else{
            $sender_user = $ticket_reply->ticket->assign_to_id ? $ticket_reply->ticket->employee : $ticket_reply->ticket->user;
        }

        $email_setting = EmailTemplate::where('key', Enum::EMAIL_TICKET_REPLY)->first();

        $subject = $email_setting->subject;
        $message = $email_setting->message;
        $ticket_user = $sender_user;

        $shortcodes = explode(',', $email_setting->shortcodes);
        $shortcode_values = [];

        foreach ($shortcodes as $shortcode)
        {
            switch ($shortcode) {
                case 'receiver_name':
                    $shortcode_values['receiver_name'] = $ticket_user->getFullNameAttribute();
                    break;
                case 'ticket_id':
                    $shortcode_values['ticket_id'] = $ticket_reply->ticket_id;
                    break;

                case 'reply_message':
                    $shortcode_values['reply_message'] = $ticket_reply->comment;
                    break;
                default:
            }
        }

        $message = Helper::replaceMessageWithShortcodes($message, $shortcode_values);

        $data = [
            'user_id' => $sender_user->id,
            'email'   => $ticket_user->email,
            'subject' => $subject,
            'message' => $message,
        ];

        EmailService::sendMail($data);
    }
}

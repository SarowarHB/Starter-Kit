<?php

namespace Database\Seeders\SystemData;

use App\Models\EmailTemplate;
use App\Library\Enum;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = self::getRecords();
        foreach ($records as $record)
        {
            EmailTemplate::create($record);
        }
    }

    private static function getRecords()
    {
        return array(
            //=====--- Ticket --=========//
            [
                'name' => 'Ticket Created',
                'key' => Enum::EMAIL_TICKET_CREATE,
                'subject' => 'You have been opened a ticket',
                'message' => self::getContent(Enum::EMAIL_TICKET_CREATE),
                'shortcodes' => 'receiver_name,ticket_id'
            ],
            [
                'name' => 'Ticket Assigned',
                'key' => Enum::EMAIL_TICKET_ASSIGN,
                'subject' => 'You have been assigned a ticket',
                'message' => self::getContent(Enum::EMAIL_TICKET_ASSIGN)
            ],
            [
                'name' => 'Ticket Replied',
                'key' => Enum::EMAIL_TICKET_REPLY,
                'subject' => 'You have been Replied a ticket',
                'message' => self::getContent(Enum::EMAIL_TICKET_REPLY),
                'shortcodes' => 'reply_message'
            ],
        );
    }

    private static function getContent($key)
    {
        return file_get_contents(__DIR__ . '/emails/' . $key . '.php');
    }
}

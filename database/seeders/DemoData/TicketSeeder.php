<?php

namespace Database\Seeders\DemoData;

use App\Library\Enum;
use App\Library\Services\Admin\ConfigService;
use App\Library\Services\Admin\MemberService;
use App\Models\Ticket;
use App\Models\TicketAssign;
use App\Models\User;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run()
    {
        $records = self::getRecords();
        foreach ($records as $record)
        {
            $find_user = User::find($record['user_id']);

            $ticket = new Ticket();
            $ticket->user_id      = $record['user_id'];
            $ticket->full_name    = $find_user->getFullNameAttribute();
            $ticket->subject      = $record['subject'];
            $ticket->message      = $record['message'];
            $ticket->department   = $record['department'];
            $ticket->priority     = $record['priority'];
            $ticket->created_by   = 1;
            $ticket->save();

            $data['assigned_to'] = User::where('user_type', Enum::USER_TYPE_ADMIN)->first()->id;
            $data['notes'] = "New Ticket Create";

            $assigner = User::find($data['assigned_to']);
            $data['assigned_by'] = $assigner->id;
            $data['assigned_by_name'] = $assigner->full_name;

            $assignee = User::find($data['assigned_to']);
            $data['assign_to_name'] = $assignee->full_name;

            $data['ticket_id'] = $ticket->id;
            $assign_data = TicketAssign::create($data);

            $ticket_data = $ticket->update([
                'assign_to_id'  => $data['assigned_to'],
                'assign_id'     =>  $assign_data->id,
            ]);
        }
    }

    private static function getRecords()
    {
        return array(
            [
                'subject'       => 'Facing a Problem',
                'message'       => 'Every fundraising strategy worth its salt (what a weird expression) knows that numbers equal impact, so incorporate some data into your donation requests. How many baby chinchillas will that $100 donation help? Whoa, that a lot. I know where my tax returns going.',
                'user_type'     => Enum::USER_TYPE_MEMBER,
                'user_id'       => MemberService::getByStatus(Enum::USER_STATUS_ACTIVE)[0]->id,
                'department'    => ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_TICKET_DEPARTMENT)[0],
                'priority'      => Enum::TICKET_PRIORITY_LOW,
            ],
            [
                'subject'       => 'Facing a Error',
                'message'       => 'Every fundraising strategy worth its salt (what a weird expression) knows that numbers equal impact, so incorporate some data into your donation requests. How many baby chinchillas will that $100 donation help? Whoa, that a lot. I know where my tax returns going.',
                'user_type'     => Enum::USER_TYPE_MEMBER,
                'user_id'       => MemberService::getByStatus(Enum::USER_STATUS_ACTIVE)[1]->id,
                'department'    => ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_TICKET_DEPARTMENT)[1],
                'priority'      => Enum::TICKET_PRIORITY_HIGH,
            ],
            [
                'subject'       => 'Facing a Problem',
                'message'       => 'Every fundraising strategy worth its salt (what a weird expression) knows that numbers equal impact, so incorporate some data into your donation requests. How many baby chinchillas will that $100 donation help? Whoa, that a lot. I know where my tax returns going.',
                'user_type'     => Enum::USER_TYPE_MEMBER,
                'user_id'       => MemberService::getByStatus(Enum::USER_STATUS_ACTIVE)[2]->id,
                'department'    => ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_TICKET_DEPARTMENT)[2],
                'priority'      => Enum::TICKET_PRIORITY_MEDIUM,
            ],
        );
    }
}

<?php

namespace Database\Seeders\DemoData;

use App\Library\Enum;
use App\Library\Services\Admin\ConfigService;
use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = self::getRecords();

        foreach($records as $value){
            $notification = new Notification();
            $notification->is_for_emp   = $value['is_for_emp'];
            $notification->subject   = $value['subject'];
            $notification->is_for_member = $value['is_for_member'];
            $notification->message      = $value['message'];
            $notification->save();
        }
    }

    private static function getRecords()
    {
        return array(
            [
                'subject'          => 'For Employment Period',
                'is_for_emp'       => 1,
                'is_for_member'    => 0,
                'message'          => 'The Employee agrees that during the Employment Period, he/she shall devote his/her full business time to the business affairs of the Company and shall perform the duties assigned to him/her faithfully and efficiently.'
            ],

            [
                'subject'           => 'Contractual agreement',
                'is_for_emp'        => 0,
                'is_for_member'     => 1,
                'message'           => 'A contractual agreement, also known as a contract, outlines, defines, and governs all of the rights and duties between the parties involved.'
            ],

            [
                'subject'           => 'For legal document',
                'is_for_emp'        => 0,
                'is_for_member'     => 1,
                'message'           => 'As stated above, a contract is a legal document. In its simplest terms, it is a statement of an agreement between or among two or more parties that involves an exchange of value. There may be money involved, or there may be an exchange of goods, services, space, or some other commodity. If theres an agreement to provide something in return for something else, its considered a contract.'
            ],
        );
    }
}

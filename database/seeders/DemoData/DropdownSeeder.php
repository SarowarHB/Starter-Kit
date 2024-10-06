<?php

namespace Database\Seeders\DemoData;

use App\Library\Enum;
use App\Library\Services\Admin\ConfigService;
use App\Models\Config;
use Illuminate\Database\Seeder;

class DropdownSeeder extends Seeder
{
    public function run()
    {
        $records = self::getRecords();
        foreach ($records as $record)
        {
            $values = ConfigService::getDropdowns($record['dropdown']);
            $values[] = $record['name'];
            self::updateConfig($record['dropdown'], json_encode($values, true));
        }
    }

    private static function getRecords()
    {
        return array(
            /*CONFIG_DROPDOWN_EMP_DESIGNATION*/
            [
                'name' => 'HR',
                'dropdown' => Enum::CONFIG_DROPDOWN_EMP_DESIGNATION,
            ],
            [
                'name' => 'Accounts',
                'dropdown' => Enum::CONFIG_DROPDOWN_EMP_DESIGNATION,
            ],
            [
                'name' => 'Manager',
                'dropdown' => Enum::CONFIG_DROPDOWN_EMP_DESIGNATION,
            ],
             /*CONFIG_DROPDOWN_EMP_DESIGNATION*/
            [
                'name' => 'Customer Service',
                'dropdown' => Enum::CONFIG_DROPDOWN_TICKET_DEPARTMENT,
            ],
            [
                'name' => 'On Field Service',
                'dropdown' => Enum::CONFIG_DROPDOWN_TICKET_DEPARTMENT,
            ],
            [
                'name' => 'Accounts Service',
                'dropdown' => Enum::CONFIG_DROPDOWN_TICKET_DEPARTMENT,
            ],

             /*CONFIG_DROPDOWN_EMP_DESIGNATION*/
            [
                'name' => 'Weekly Announcement',
                'dropdown' => Enum::CONFIG_DROPDOWN_NOTIFICATION_TYPE,
            ],
            [
                'name' => 'Monthly Announcement',
                'dropdown' => Enum::CONFIG_DROPDOWN_NOTIFICATION_TYPE,
            ],
            [
                'name' => 'Daily Announcement',
                'dropdown' => Enum::CONFIG_DROPDOWN_NOTIFICATION_TYPE,
            ],
        );
    }

    private static function updateConfig(string $key, string $value)
    {
        $config = Config::firstOrNew(['key' => $key]);
        $config->value = $value;
        $config->save();

    }
}

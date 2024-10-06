<?php

namespace Database\Seeders;

use Database\Seeders\DemoData\CategoryTypeSeeder;
use Database\Seeders\DemoData\MemberSeeder;
use Database\Seeders\DemoData\DropdownSeeder;
use Database\Seeders\DemoData\EmployeeSeeder;
use Database\Seeders\DemoData\NotificationSeeder;
use Database\Seeders\DemoData\TicketSeeder;
use Database\Seeders\DemoData\ConfigSeeder;
use Illuminate\Database\Seeder;

class DemoData extends Seeder
{
    public function run()
    {
        $this->call([
            MemberSeeder::class,
            DropdownSeeder::class,
            EmployeeSeeder::class,
            NotificationSeeder::class,
            TicketSeeder::class,
            ConfigSeeder::class,
            CategoryTypeSeeder::class,
        ]);
    }
}

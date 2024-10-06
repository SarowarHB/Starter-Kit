<?php

namespace Database\Seeders;

use Database\Seeders\SystemData\EmailTemplateSeeder;
use Database\Seeders\SystemData\PermissionSeeder;
use Database\Seeders\SystemData\RoleSeeder;
use Database\Seeders\SystemData\UserSeeder;
use Illuminate\Database\Seeder;

class SystemData extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            EmailTemplateSeeder::class,
        ]);
    }
}

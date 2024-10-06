<?php

namespace Database\Seeders\SystemData;

use App\Models\User;
use App\Library\Enum;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAdmin();
    }

    private function createAdmin()
    {
        $user = new User();
        $user->f_name    = "Sarowar";
        $user->l_name    = "Admin";
        $user->nick_name    = "Administrator";
        $user->email   = env('ADMIN_EMAIL');
        $user->password = bcrypt(env('ADMIN_PASSWORD'));
        $user->user_type = Enum::USER_TYPE_ADMIN;
        $user->is_active = 1;
        $user->save();
    }
}

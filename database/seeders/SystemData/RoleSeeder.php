<?php

namespace Database\Seeders\SystemData;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = 'Administrator';
        $role->slug = 'admin';
        $role->save();

        $admin_user = User::where('email', env('ADMIN_EMAIL'))->first();

        if($admin_user)
        {
            $admin_user->roles()->attach($role);
        }  
        
        $role = new Role();
        $role->name = 'Employee';
        $role->slug = 'employee';
        $role->save();

        $admin_user = User::where('email','!=', env('ADMIN_EMAIL'))->first();

        if($admin_user)
        {
            $admin_user->roles()->attach($role);
        }            
    }
}

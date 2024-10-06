<?php

namespace Database\Seeders\DemoData;

use App\Library\Enum;
use App\Library\Services\Admin\ConfigService;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Employee-1
        $user_data = ['f_name'=>'Rasel','l_name'=>'Hossain','nick_name'=>"Rasel",'email'=>'rasel@admin.com','password'=>bcrypt(12345678),'user_type'=>Enum::USER_TYPE_ADMIN, 'is_active'=>1];
        $user = User::create($user_data);
        $user->roles()->attach(2);
        $employee_data = ['user_id'=>$user->id,'mobile'=>'+880-0195245454','dob'=>'2000-02-02','address_line_1'=>'152/4 Green Road','city'=>'Dhaka','post_code'=>1205,'country'=>'BD','emp_type'=>Enum::EMPLOYEE_TYPE_FULL_TIME,'designation'=>ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_EMP_DESIGNATION)[0]];
        Employee::create($employee_data);

        //Employee-2
        $user_data = ['f_name'=>'Sojib','l_name'=>'Hossain','nick_name'=>"Rabbi",'email'=>'shojib@admin.com','password'=>bcrypt(12345678),'user_type'=>Enum::USER_TYPE_ADMIN, 'is_active'=>1];
        $user = User::create($user_data);
        $user->roles()->attach(2);
        $employee_data = ['user_id'=>$user->id,'mobile'=>'+880-01756324569','dob'=>'2000-02-01','address_line_1'=>'79 Green Road','city'=>'Dhaka','post_code'=>1205,'country'=>'BD','emp_type'=>Enum::EMPLOYEE_TYPE_FULL_TIME,'designation'=>ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_EMP_DESIGNATION)[1]];
        Employee::create($employee_data);

        //Employee-3
        $user_data = ['f_name'=>'Mofiz','l_name'=>'Islam','nick_name'=>"Akon",'email'=>'mofiz@admin.com','password'=>bcrypt(12345678),'user_type'=>Enum::USER_TYPE_ADMIN];
        $user = User::create($user_data);
        $user->roles()->attach(2);
        $employee_data = ['user_id'=>$user->id,'mobile'=>'+880-01924554542','dob'=>'1999-02-01','address_line_1'=>'79 Panthapath','city'=>'Dhaka','post_code'=>1205,'country'=>'BD','emp_type'=>Enum::EMPLOYEE_TYPE_FULL_TIME,'designation'=>ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_EMP_DESIGNATION)[2]];
        Employee::create($employee_data);

    }
}

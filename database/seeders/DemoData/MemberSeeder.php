<?php

namespace Database\Seeders\DemoData;

use App\Library\Enum;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Member-1
        $user_data = ['f_name'=>'sarowar','l_name'=>'Hossain','nick_name'=>"Sabbir",'email'=>'sarowar@member.com','password'=>bcrypt(12345678),'user_type'=>Enum::USER_TYPE_MEMBER, 'is_active'=>1];
        $user = User::create($user_data);
        $member_data = ['user_id'=>$user->id,'mobile'=>'+880-01845454','dob'=>'2000-02-02','address_line_1'=>'152/4 Green Road','city'=>'Dhaka','post_code'=>1205,'country'=>'BD','photo_id'=>Enum::NO_IMAGE_PATH];
        Member::create($member_data);

        // Member-2
        $user_data = ['f_name'=>'Rakib','l_name'=>'Hossain','nick_name'=>"Rabbi",'email'=>'rakib@member.com','password'=>bcrypt(12345678),'user_type'=>Enum::USER_TYPE_MEMBER, 'is_active'=>1];
        $user = User::create($user_data);
        $member_data = ['user_id'=>$user->id,'mobile'=>'+880-01845554','dob'=>'2000-02-01','address_line_1'=>'79 Green Road','city'=>'Dhaka','post_code'=>1205,'country'=>'BD','photo_id'=>Enum::NO_IMAGE_PATH];
        Member::create($member_data);

        // Member-3
        $user_data = ['f_name'=>'Mazarul','l_name'=>'Islam','nick_name'=>"Rimon",'email'=>'mazarul@member.com','password'=>bcrypt(12345678),'user_type'=>Enum::USER_TYPE_MEMBER, 'is_active'=>1];
        $user = User::create($user_data);
        $member_data = ['user_id'=>$user->id,'mobile'=>'+880-018455654','dob'=>'1999-02-01','address_line_1'=>'79 Panthapath','city'=>'Dhaka','post_code'=>1205,'country'=>'BD','photo_id'=>Enum::NO_IMAGE_PATH];
        Member::create($member_data);

    }
}

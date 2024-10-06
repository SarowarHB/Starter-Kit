<?php

namespace Database\Seeders\DemoData;

use App\Models\Config;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // General Settings
            ['key' => 'app_title', 'value' => ''],
            ['key' => 'email', 'value' => ''],
            ['key' => 'country_code', 'value' => ''],
            ['key' => 'phone', 'value' => ''],
            ['key' => 'logo', 'value' => ''],
            ['key' => 'favicon', 'value' => ''],
            ['key' => 'og_image', 'value' => ''],
            ['key' => 'address', 'value' => ''],
            ['key' => 'city', 'value' => ''],
            ['key' => 'state', 'value' => ''],
            ['key' => 'zip_code', 'value' => ''],
            ['key' => 'country', 'value' => ''],
            ['key' => 'copyright', 'value' => ''],
            ['key' => 'copyright_url', 'value' => ''],
            ['key' => 'currency_name', 'value' => ''],
            ['key' => 'currency_symbol', 'value' => ''],
            ['key' => 'version', 'value' => ''],
            ['key' => 'admin_prefix', 'value' => ''],

            // Email Settings
            ['key' => 'mail_driver', 'value' => 'smtp'],
            ['key' => 'mail_host', 'value' => 'smtp.gmail.com'],
            ['key' => 'mail_port', 'value' => '587'],
            ['key' => 'mail_user_name', 'value' => ''],
            ['key' => 'mail_password', 'value' => ''],
            ['key' => 'mail_from', 'value' => 'Sarowar'],
            ['key' => 'mail_from_name', 'value' => 'Sarowar'],
            ['key' => 'encryption', 'value' => 'tls'],

            // Social Link Share
            ['key' => 'facebook_link', 'value' => '#'],
            ['key' => 'twitter_link', 'value' => '#'] ,
            ['key' => 'instagram_link', 'value' => '#'],
            ['key' => 'linkedin_link', 'value' => '#'],
            ['key' => 'youtube_link', 'value' => '#'] ,
        ];

        Config::insert($data);
    }
}

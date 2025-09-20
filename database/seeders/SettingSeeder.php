<?php

namespace Database\Seeders;

use App\Models\CommonSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setting = [
            [
                'phone' => '017XXXXXXXX',
                'email' => 'info@gmail.com',
                'address' => 'Dhaka, Bangladesh',
                'facebook' => 'https://facebook.com',
                'twitter' => 'https://twitter.com',
                'linkedin' => 'https://linkedin.com',
                'instagram' => 'https://instagram.com',
                'youtube' => 'https://youtube.com',
                'logo' => 'logo.png',
                'favicon' => 'favicon.png'
            ],
        ];
        

        CommonSetting::insert($setting);
    }
}

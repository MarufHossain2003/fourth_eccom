<?php

namespace Database\Seeders;

use App\Models\HomeBanner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomeBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $homeBanner = [
            [
                'banner' => 'test.png',
            ],
        ];

        HomeBanner::insert($homeBanner);
    }
}

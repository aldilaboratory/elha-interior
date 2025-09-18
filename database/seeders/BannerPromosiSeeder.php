<?php

namespace Database\Seeders;

use App\Models\BannerPromosi;
use Illuminate\Database\Seeder;

class BannerPromosiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "nama" => "M75 Sport Watch",
                "deskripsi" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
                "image" => "slider-bg1.jpg",
            ],
            [
                "nama" => "Get the Best Deal on CCTV Camera",
                "deskripsi" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
                "image" => "slider-bg2.jpg",
            ],
        ];

        BannerPromosi::insert($data);
    }
}

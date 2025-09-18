<?php

namespace Database\Seeders;

use App\Models\FooterPromosi;
use Illuminate\Database\Seeder;

class FooterPromosiSeeder extends Seeder
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
                "nama" => "Smart Watch 2.0",
                "deskripsi" => "LSpace Gray Aluminum Case with <br>Black/Volt Real Sport Band ",
                "image" => "banner-1-bg.jpg",
                "produk_id" => "1",
            ],
            [
                "nama" => "Get the Best Deal on CCTV Camera",
                "deskripsi" => "Lorem ipsum dolor sit amet, <br>eiusmod tempor
                                incididunt ut labore.",
                "image" => "banner-2-bg.jpg",
                "produk_id" => "2",
            ],
        ];

        FooterPromosi::insert($data);
    }
}

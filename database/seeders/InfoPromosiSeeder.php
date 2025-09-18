<?php

namespace Database\Seeders;

use App\Models\InfoPromosi;
use Illuminate\Database\Seeder;

class InfoPromosiSeeder extends Seeder
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
                "deskripsi" => "LSpace Gray Aluminum Case with Black/Volt Real Sport Band ",
            ],
        ];

        InfoPromosi::insert($data);
    }
}

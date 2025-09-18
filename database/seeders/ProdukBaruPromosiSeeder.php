<?php

namespace Database\Seeders;

use App\Models\ProdukBaruPromosi;
use Illuminate\Database\Seeder;

class ProdukBaruPromosiSeeder extends Seeder
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
                "image" => "slider-bnr.jpg",
                "produk_id" => "1",
            ],
        ];

        ProdukBaruPromosi::insert($data);
    }
}

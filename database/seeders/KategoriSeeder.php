<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [["nama" => "Watches"], ["nama" => "Speaker"], ["nama" => "Camera"], ["nama" => "Phones"], ["nama" => "Headphones"], ["nama" => "Laptop"]];

        Kategori::insert($data);
    }
}

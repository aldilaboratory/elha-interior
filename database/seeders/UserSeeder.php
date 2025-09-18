<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
                "name" => "admin",
                "username" => "admin",
                "email" => "admin@gmail.com",
                "password" => Hash::make("password"),
                "group_id" => "1",
                "provinsi_id" => "1",
                "kab_kot_id" => "1",
                "kecamatan_id" => "1",
                "desa_id" => "1",
                "alamat" => "Blitar",
            ],
            [
                "name" => "penguna",
                "username" => "penguna",
                "email" => "penguna@gmail.com",
                "password" => Hash::make("password"),
                "group_id" => "2",
                "provinsi_id" => "1",
                "kab_kot_id" => "1",
                "kecamatan_id" => "1",
                "desa_id" => "1",
                "alamat" => "Blitar",
            ],
        ];

        User::insert($data);
    }
}

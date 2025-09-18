<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $this->call([
            UserSeeder::class,
            ProdukSeeder::class,
            GroupSeeder::class,
            KategoriSeeder::class,
            StatusSeeder::class,
            BannerPromosiSeeder::class,
            FooterPromosiSeeder::class,
            InfoPromosiSeeder::class,
            ProdukBaruPromosiSeeder::class,
            UpdateResiSeeder::class
        ]);

        Schema::enableForeignKeyConstraints();
    }
}

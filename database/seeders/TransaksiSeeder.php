<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample transactions
        $transaksi1 = Transaksi::create([
            'user_id' => 1,
            'order_id' => 'ORD-' . time() . '-001',
            'nama_penerima' => 'John Doe',
            'alamat' => 'Jl. Contoh No. 123',
            'no_hp' => '081234567890',
            'provinsi_id' => 1,
            'provinsi_nama' => 'DKI Jakarta',
            'kota_id' => 1,
            'kota_nama' => 'Jakarta Selatan',
            'kurir' => 'jne',
            'paket' => 'REG',
            'paket_harga' => 15000,
            'paket_estimasi' => '2-3 hari',
            'ongkir' => 15000,
            'total' => 175000,
            'status' => 'selesai',
            'payment_method' => 'bank_transfer',
            'created_at' => now()->subDays(5),
            'updated_at' => now()->subDays(5),
        ]);

        TransaksiDetail::create([
            'transaksi_id' => $transaksi1->id,
            'produk_id' => 1,
            'nama_produk' => 'Xiaomi Mi Band 5',
            'gambar_produk' => 'product-1.jpg',
            'jumlah' => 2,
            'harga' => 45000,
            'subtotal' => 90000,
        ]);

        TransaksiDetail::create([
            'transaksi_id' => $transaksi1->id,
            'produk_id' => 6,
            'nama_produk' => 'Mini Bluetooth Speaker',
            'gambar_produk' => 'product-6.jpg',
            'jumlah' => 1,
            'harga' => 110000,
            'subtotal' => 110000,
        ]);

        $transaksi2 = Transaksi::create([
            'user_id' => 1,
            'order_id' => 'ORD-' . (time() + 1) . '-002',
            'nama_penerima' => 'Jane Smith',
            'alamat' => 'Jl. Merdeka No. 456',
            'no_hp' => '081234567891',
            'provinsi_id' => 2,
            'provinsi_nama' => 'Jawa Barat',
            'kota_id' => 2,
            'kota_nama' => 'Bandung',
            'kurir' => 'pos',
            'paket' => 'REG',
            'paket_harga' => 20000,
            'paket_estimasi' => '3-4 hari',
            'ongkir' => 20000,
            'total' => 520000,
            'status' => 'pending',
            'payment_method' => 'credit_card',
            'created_at' => now()->subDays(3),
            'updated_at' => now()->subDays(3),
        ]);

        TransaksiDetail::create([
            'transaksi_id' => $transaksi2->id,
            'produk_id' => 3,
            'nama_produk' => 'WiFi Security Camera',
            'gambar_produk' => 'product-3.jpg',
            'jumlah' => 1,
            'harga' => 500000,
            'subtotal' => 500000,
        ]);

        $transaksi3 = Transaksi::create([
            'user_id' => 1,
            'order_id' => 'ORD-' . (time() + 2) . '-003',
            'nama_penerima' => 'Bob Johnson',
            'alamat' => 'Jl. Sudirman No. 789',
            'no_hp' => '081234567892',
            'provinsi_id' => 1,
            'provinsi_nama' => 'DKI Jakarta',
            'kota_id' => 1,
            'kota_nama' => 'Jakarta Pusat',
            'kurir' => 'tiki',
            'paket' => 'ONS',
            'paket_harga' => 25000,
            'paket_estimasi' => '1-2 hari',
            'ongkir' => 25000,
            'total' => 275000,
            'status' => 'selesai',
            'payment_method' => 'bank_transfer',
            'created_at' => now()->subDays(1),
            'updated_at' => now()->subDays(1),
        ]);

        TransaksiDetail::create([
            'transaksi_id' => $transaksi3->id,
            'produk_id' => 7,
            'nama_produk' => 'PX7 Wireless Headphones',
            'gambar_produk' => 'product-7.jpg',
            'jumlah' => 1,
            'harga' => 250000,
            'subtotal' => 250000,
        ]);

        $transaksi4 = Transaksi::create([
            'user_id' => 1,
            'order_id' => 'ORD-' . (time() + 3) . '-004',
            'nama_penerima' => 'Alice Brown',
            'alamat' => 'Jl. Gatot Subroto No. 321',
            'no_hp' => '081234567893',
            'provinsi_id' => 3,
            'provinsi_nama' => 'Jawa Tengah',
            'kota_id' => 3,
            'kota_nama' => 'Semarang',
            'kurir' => 'jne',
            'paket' => 'YES',
            'paket_harga' => 50000,
            'paket_estimasi' => '1 hari',
            'ongkir' => 50000,
            'total' => 4050000,
            'status' => 'dibatalkan',
            'payment_method' => 'e_wallet',
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDays(2),
        ]);

        TransaksiDetail::create([
            'transaksi_id' => $transaksi4->id,
            'produk_id' => 8,
            'nama_produk' => 'Apple MacBook Air',
            'gambar_produk' => 'product-8.jpg',
            'jumlah' => 1,
            'harga' => 4000000,
            'subtotal' => 4000000,
        ]);
    }
}

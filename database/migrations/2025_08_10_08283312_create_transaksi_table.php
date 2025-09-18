<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("transaksi", function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('order_id')->unique();
            $table->string('nama_penerima');
            $table->text('alamat');
            $table->string('no_hp');

            $table->unsignedBigInteger('provinsi_id');
            $table->string('provinsi_nama');
            $table->unsignedBigInteger('kota_id');
            $table->string('kota_nama');

            $table->string('kurir');
            $table->string('paket');
            $table->integer('paket_harga')->default(0);
            $table->string('paket_estimasi')->nullable();

            $table->integer('ongkir')->default(0);
            $table->integer('total')->default(0);

            $table->string('status')->default('pending');
            $table->string('payment_method');
            $table->string('snap_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("transaksi");
    }
}

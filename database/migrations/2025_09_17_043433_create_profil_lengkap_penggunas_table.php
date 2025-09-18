<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profil_lengkap_penggunas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->nullOnDelete();
            $table->string("name_penerima");
            $table->text('alamat');
            $table->string('no_telp');

            $table->unsignedBigInteger('provinsi_id');
            $table->string('provinsi_nama');
            $table->unsignedBigInteger('kota_id');
            $table->string('kota_nama');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_lengkap_penggunas');
    }
};

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
        Schema::table('profil_lengkap_penggunas', function (Blueprint $table) {
            $table->boolean('is_default')->default(false)->after('kota_nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profil_lengkap_penggunas', function (Blueprint $table) {
            $table->dropColumn('is_default');
        });
    }
};

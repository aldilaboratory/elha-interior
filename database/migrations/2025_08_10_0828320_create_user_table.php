<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("user", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("username");
            $table->string("email");
            $table->string("password");
            $table->integer("group_id");
            $table->integer("provinsi_id")->nullable();
            $table->integer("kab_kot_id")->nullable();
            $table->integer("kecamatan_id")->nullable();
            $table->integer("desa_id")->nullable();
            $table->text("alamat")->nullable();
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
        Schema::dropIfExists("user");
    }
}

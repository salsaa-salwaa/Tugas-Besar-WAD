<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKonselorsTable extends Migration
{
    public function up()
    {
        Schema::create('konselors', function (Blueprint $table) {
            $table->id('id_konselor'); 
            $table->string('nama');
            $table->string('no_telp');
            $table->json('keahlian');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('konselors');
        Schema::dropIfExists('konselor_keahlian');
    }
}

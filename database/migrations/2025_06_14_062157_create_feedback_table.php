<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('konselor_id');
            $table->tinyInteger('rating')->unsigned()->comment('1 to 5');
            $table->text('komentar')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('mahasiswa_id')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('konselor_id')->references('id_konselor')->on('konselors')->onDelete('cascade');
        });
    }

    


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};

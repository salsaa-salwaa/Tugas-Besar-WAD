<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('id_appointment');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('jadwal_id');
            $table->date('tanggal'); // Tanggal appointment
            $table->text('deskripsi')->nullable();
            $table->enum('tipe', ['daring', 'luring'])->default('daring');
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->timestamps();

            $table->foreign('mahasiswa_id')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('jadwal_id')->references('id_jadwal')->on('jadwals')->onDelete('cascade');

            $table->unique(['mahasiswa_id', 'jadwal_id', 'tanggal']); // Cegah double-book pada hari & slot yang sama
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};

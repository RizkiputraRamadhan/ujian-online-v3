<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kehadiran', function (Blueprint $table) {
            $table->id();
            $table->string('no_peserta');
            $table->enum('status_ujian', ['SELESAI', 'MENGERJAKAN', 'BELUM_DIMULAI']);
            $table->enum('status_kehadiran', ['HADIR', 'TIDAK_HADIR']);
            $table->enum('status_blokir', ['Y', 'N']);
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('jadwal_id');
            $table->unsignedBigInteger('siswa_id');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('jadwal_id')->references('id')->on('jadwal')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('siswa_id')->references('id')->on('siswa')->onDelete('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('kehadiran');
    }
};

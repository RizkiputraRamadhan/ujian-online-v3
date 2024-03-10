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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nis');
            $table->string('nip_nik_nisn')->unique();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['P', 'L']);
            $table->string('ttl');
            $table->string('password');
            $table->string('password_view');
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('sekolah_id');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('sekolah_id')->references('id')->on('sekolah')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('siswa');
    }
};

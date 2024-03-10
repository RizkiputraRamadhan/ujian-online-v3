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
        Schema::create('bank_jawaban', function (Blueprint $table) {
            $table->id();
            $table->string('jawaban')->nullable();
            $table->enum('status_jawaban', ['yakin', 'ragu_ragu']);
            $table->unsignedBigInteger('banksoal_id');
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('mapel_id');
            $table->unsignedBigInteger('kehadiran_id');
            $table->foreign('banksoal_id')->references('id')->on('bank_soal')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('mapel_id')->references('id')->on('mapel')->onDelete('cascade')->onDelete('cascade');
            $table->foreign('kehadiran_id')->references('id')->on('kehadiran')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('bank_jawaban');
    }
};

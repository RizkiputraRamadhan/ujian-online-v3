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
        Schema::create('mapel', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mapel');
            $table->double('kkm');
            $table->integer('jumlah_soal');
            $table->enum('acak_soal', ['Y', 'N']);
            $table->enum('umumkan_nilai', ['Y', 'N']);
            $table->string('kode')->unique();
            $table->enum('semester', ['GANJIL', 'GENAP']);
            $table->unsignedBigInteger('guru_id');
            $table->unsignedBigInteger('tahunajaran_id');
            $table->foreign('guru_id')->references('id')->on('guru')->ondelete('cascade')->onUpdate('cascade');
            $table->foreign('tahunajaran_id')->references('id')->on('tahun_ajaran')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('mapel');
    }
};

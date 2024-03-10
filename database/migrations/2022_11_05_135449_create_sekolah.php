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
        Schema::create('sekolah', function (Blueprint $table) {
            $table->id();
            $table->string('instansi');
            $table->string('nama');
            $table->enum('level', ['MI', 'MTS', 'MA']);
            $table->string('no_telp');
            $table->string('email');
            $table->string('alamat');
            $table->string('nip_kamad')->nullable();
            $table->string('nama_kamad');
            $table->enum('semester', ['GANJIL', 'GENAP']);
            $table->unsignedBigInteger('tahunajaran_id');
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
        Schema::dropIfExists('sekolah');
    }
};

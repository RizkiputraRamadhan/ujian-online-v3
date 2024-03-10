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
        Schema::create('bank_soal', function (Blueprint $table) {
            $table->id();
            $table->mediumText('soal')->nullable();
            $table->text('jawaban_singkat')->nullable();
            $table->integer('jenis_soal');
            $table->mediumText('pil_1')->nullable();
            $table->mediumText('pil_2')->nullable();
            $table->mediumText('pil_3')->nullable();
            $table->mediumText('pil_4')->nullable();
            $table->mediumText('pil_5')->nullable();
            $table->string('kunci')->nullable();
            $table->string('jenis_hrf')->nullable();
            $table->string('jenis_inp')->nullable();
            $table->mediumText('soal_jdh_array')->nullable();
            $table->string('jawaban_jdh')->nullable();
            $table->unsignedBigInteger('mapel_id');
            $table->foreign('mapel_id')->references('id')->on('mapel')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('bank_soal');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelanggaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelanggarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nisn_id');
            $table->foreign('nisn_id')->references('id')->on('siswas')->onUpdate('cascade');
            $table->unsignedBigInteger('nama_id');
            $table->foreign('nama_id')->references('id')->on('siswas')->onUpdate('cascade');
            // $table->string('pelanggaran');
            $table->unsignedBigInteger('kelas_id');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onUpdate('cascade');
            $table->unsignedBigInteger('bentuk_id');
            $table->foreign('bentuk_id')->references('id')->on('bentuks')->onUpdate('cascade');
            $table->unsignedBigInteger('bobot_id');
            // $table->foreign('bobot_id')->references('id')->on('bentuks')->onUpdate('cascade');
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
        Schema::dropIfExists('pelanggarans');
    }
}

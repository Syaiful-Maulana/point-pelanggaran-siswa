<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBentuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bentuks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori');
            $table->foreign('kategori')->references('id')->on('kategoris')->onUpdate('cascade')->onDelete('cascade');
            $table->string('bentuk');
            $table->bigInteger('bobot');
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
        Schema::dropIfExists('bentuks');
    }
}

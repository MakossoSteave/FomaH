<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvoirCursusMotCleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avoir_cursus_mot_cle', function (Blueprint $table) {
            $table->bigInteger('id_cursus')->unsigned();
            $table->bigInteger('id_mot_cle')->unsigned();
            $table->primary(['id_cursus', 'id_mot_cle']);
            $table->foreign('id_mot_cle')->references('id')->on('mot_cle');    
            $table->foreign('id_cursus')->references('id')->on('cursus');
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
        Schema::dropIfExists('avoir_cursus_mot_cle');
    }
}

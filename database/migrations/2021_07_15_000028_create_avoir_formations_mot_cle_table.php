<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvoirformationsMotCleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avoir_formations_mots_cles', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->bigInteger('id_formation')->unsigned();
            $table->bigInteger('id_mot_cle')->unsigned();
            $table->primary(['id_formation', 'id_mot_cle']);
            $table->foreign('id_mot_cle')->references('id')->on('mots_cles');    
            $table->foreign('id_formation')->references('id')->on('formations');
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
        Schema::dropIfExists('avoir_formations_mots_cles');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvoirCoursMotCleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avoir_cours_mots_cles', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->bigInteger('id_cours')->unsigned();
            $table->bigInteger('id_mot_cle')->unsigned();
            $table->primary(['id_cours', 'id_mot_cle']);
            $table->foreign('id_mot_cle')->references('id')->on('mots_cles');    
            $table->foreign('id_cours')->references('id_cours')->on('cours');
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
        Schema::dropIfExists('avoir_cours_mots_cles');
    }
}

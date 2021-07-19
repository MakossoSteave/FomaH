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
        Schema::create('avoir_cours_mot_cle', function (Blueprint $table) {
            $table->bigInteger('id_cours')->unsigned();
            $table->bigInteger('id_mot_cle')->unsigned();
            $table->integer('numero_cours')->unsigned();
            $table->primary(['id_cours', 'id_mot_cle', 'numero_cours']);
            $table->foreign('id_mot_cle')->references('id')->on('mot_cle');    
            $table->foreign('id_cours')->references('id_cours')->on('cours');
            $table->foreign('numero_cours')->references('numero_cours')->on('cours');
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
        Schema::dropIfExists('avoir_cours_mot_cle');
    }
}

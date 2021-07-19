<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuivreCoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suivre_cours', function (Blueprint $table) {
            $table->engine='MyISAM';
            $table->bigInteger('id_cours')->unsigned();
            $table->bigInteger('id_stagiaire')->unsigned();
            $table->integer('numero_cours')->unsigned();
            $table->primary(['id_cours', 'id_stagiaire', 'numero_cours']);
            $table->foreign('id_stagiaire')->references('id')->on('stagiaire');    
            $table->foreign('id_cours')->references('id_cours')->on('cours');
            $table->foreign('numero_cours')->references('numero_cours')->on('cours');
            $table->bigInteger('id_chapitre')->unsigned()->index();
            $table->foreign('id_chapitre')->references('id_chapitre')->on('chapitre')->onDelete('cascade');
            $table->integer('nombre_chapitre_lu');
            $table->integer('progression');
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
        Schema::dropIfExists('suivre_cours');
    }
}

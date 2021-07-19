<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuivreCursusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suivre_cursus', function (Blueprint $table) {
            $table->engine='MyiSAM';
            $table->bigInteger('id_stagiaire')->unsigned();
            $table->bigInteger('id_cursus')->unsigned();
            $table->primary(['id_stagiaire', 'id_cursus']);
            $table->foreign('id_cursus')->references('id')->on('cursus');    
            $table->foreign('id_stagiaire')->references('id')->on('stagiaire');
            $table->bigInteger('id_cours')->unsigned()->index();
            $table->foreign('id_cours')->references('id_cours')->on('cours')->onDelete('cascade');
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
        Schema::dropIfExists('suivre_cursus');
    }
}

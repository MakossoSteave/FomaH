<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuivreformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suivre_formations', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->bigInteger('id_stagiaire')->unsigned();
            $table->bigInteger('id_session')->unsigned();
            $table->bigInteger('id_formations')->unsigned(); 
            $table->foreign('id_session')->references('id')->on('sessions')->onDelete('cascade');    
            $table->primary(['id_stagiaire', 'id_session']);
            $table->foreign('id_formations')->references('id')->on('formations')->onDelete('cascade');    
            $table->foreign('id_stagiaire')->references('id')->on('stagiaires')->onDelete('cascade');
            $table->bigInteger('id_cours')->unsigned()->index()->nullable();
            $table->foreign('id_cours')->references('id_cours')->on('cours')->onDelete('set null');
            $table->bigInteger('id_chapitre')->unsigned()->index()->nullable();
            $table->foreign('id_chapitre')->references('id_chapitre')->on('chapitres')->onDelete('set null');
            $table->bigInteger('id_chapitre_Courant')->unsigned()->index()->nullable();
            $table->foreign('id_chapitre_Courant')->references('id_chapitre')->on('chapitres')->onDelete('set null');
            $table->bigInteger('id_projet')->unsigned()->index()->nullable();
            $table->foreign('id_projet')->references('id')->on('projets')->onDelete('set null');
            $table->bigInteger('id_qcm')->unsigned()->index()->nullable();
            $table->foreign('id_qcm')->references('id')->on('qcm')->onDelete('set null');
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
        Schema::dropIfExists('suivre_formations');
    }
}

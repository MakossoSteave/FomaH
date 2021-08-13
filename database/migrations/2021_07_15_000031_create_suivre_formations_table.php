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
            $table->bigInteger('id_formations')->unsigned();
            $table->primary(['id_stagiaire', 'id_formations']);
            $table->foreign('id_formations')->references('id')->on('formations')->onDelete('cascade');    
            $table->foreign('id_stagiaire')->references('id')->on('stagiaires')->onDelete('cascade');
            $table->bigInteger('id_cours')->unsigned()->index();
            $table->foreign('id_cours')->references('id_cours')->on('cours');
            $table->bigInteger('id_chapitre')->unsigned()->index();
            $table->foreign('id_chapitre')->references('id_chapitre')->on('chapitres');
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaireProjetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faire_projet', function (Blueprint $table) {
            $table->engine='MyiSAM';
            $table->bigInteger('id_projet')->unsigned();
            $table->bigInteger('id_stagiaire')->unsigned();
            $table->primary(['id_projet', 'id_stagiaire']);
            $table->foreign('id_stagiaire')->references('id')->on('stagiaire');    
            $table->foreign('id_projet')->references('id')->on('projet');
            $table->boolean('statut_reussite')->nullable();
            $table->boolean('resultat_description')->nullable();
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
        Schema::dropIfExists('faire_projet');
    }
}

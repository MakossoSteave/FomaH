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
        Schema::create('faire_projets', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->bigInteger('id_projet')->unsigned();
            $table->bigInteger('id_stagiaire')->unsigned();
            $table->primary(['id_projet', 'id_stagiaire']);
            $table->foreign('id_stagiaire')->references('id')->on('stagiaires');    
            $table->foreign('id_projet')->references('id')->on('projets');
            $table->string('lien', 1000);
            $table->boolean('statut_reussite')->nullable();
            $table->string('resultat_description',3000)->nullable();
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
        Schema::dropIfExists('faire_projets');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContenirSessionProjetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contenir_sessions_projets', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->bigInteger('id_projet')->unsigned();
            $table->bigInteger('id_session')->unsigned();
            $table->primary(['id_projet', 'id_session']);
            $table->foreign('id_session')->references('id')->on('sessions')->onDelete('cascade');    
            $table->foreign('id_projet')->references('id')->on('projets')->onDelete('cascade');
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->bigInteger('statut_id')->unsigned()->index();
            $table->foreign('statut_id')->references('id')->on('statut')->onDelete('cascade');
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
        Schema::dropIfExists('contenir_sessions_projets');
    }
}

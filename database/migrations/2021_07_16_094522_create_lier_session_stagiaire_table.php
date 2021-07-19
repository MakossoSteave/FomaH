<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLierSessionStagiaireTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lier_session_stagiaire', function (Blueprint $table) {
            $table->bigInteger('id_session')->unsigned();
            $table->bigInteger('id_stagiaire')->unsigned();
            $table->primary(['id_session', 'id_stagiaire']);
            $table->foreign('id_stagiaire')->references('id')->on('stagiaire');    
            $table->foreign('id_session')->references('id')->on('session');
            $table->boolean('etat');
            $table->boolean('validation')->nullable();
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
        Schema::dropIfExists('lier_session_stagaire');
    }
}

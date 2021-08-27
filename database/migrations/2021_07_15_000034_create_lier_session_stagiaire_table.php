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
        Schema::create('lier_sessions_stagiaires', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->bigInteger('id_session')->unsigned();
            $table->bigInteger('id_stagiaire')->unsigned();
            $table->primary(['id_session', 'id_stagiaire']);
            $table->foreign('id_stagiaire')->references('id')->on('stagiaires');    
            $table->foreign('id_session')->references('id')->on('sessions');
            $table->boolean('etat');
            $table->boolean('validation')->nullable();
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
        Schema::dropIfExists('lier_sessions_stagaires');
    }
}

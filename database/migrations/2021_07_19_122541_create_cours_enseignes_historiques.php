<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursEnseignesHistoriques extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cours_enseignes_historiques', function (Blueprint $table) {
            $table->engine='MyiSAM';
            $table->id();
            $table->bigInteger('id_formateur')->unsigned();
            $table->foreign('id_formateur')->references('id')->on('formateurs');
            $table->bigInteger('id_cours')->unsigned();
            $table->foreign('id_cours')->references('id')->on('cours');
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->string('appreciation_cours');
            $table->integer('pourcentage_reussite');
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
        Schema::dropIfExists('cours_enseignes_historiques');
    }
}

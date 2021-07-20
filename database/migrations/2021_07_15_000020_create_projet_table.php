<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projets', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->id();;
            $table->string('description');
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->boolean('etat');
            $table->bigInteger('formateur_id')->unsigned()->index();
            $table->foreign('formateur_id')->references('id')->on('formateurs')->onDelete('cascade');
            $table->bigInteger('id_cours')->unsigned()->index()->nullable();
            $table->foreign('id_cours')->references('id_cours')->on('cours')->onDelete('cascade');
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
        Schema::dropIfExists('projets');
    }
}

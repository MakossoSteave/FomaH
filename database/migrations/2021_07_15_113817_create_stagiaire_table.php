<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStagiaireTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stagiaires', function (Blueprint $table) {
            $table->engine='MyISAM';
            $table->id();;
            $table->string('nom');
            $table->string('prenom');
            $table->integer('telephone');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('formateur_id')->unsigned()->index()->nullable();
            $table->foreign('formateur_id')->references('id')->on('formateur')->onDelete('cascade');
            $table->bigInteger('type_inscription_id')->unsigned()->index()->nullable();
            $table->foreign('type_inscription_id')->references('id')->on('type_inscription')->onDelete('cascade');
            $table->bigInteger('organisation_id')->unsigned()->index()->nullable();
            $table->foreign('organisation_id')->references('id')->on('organisation')->onDelete('cascade');
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
        Schema::dropIfExists('stagiaire');
    }
}

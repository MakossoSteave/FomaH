<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormationContenirCourss extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formation__contenir__courss', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->bigInteger('id_Formation')->unsigned();
            $table->integer('id_cours')->unsigned();
            $table->integer('numero_cours')->unsigned();
            $table->primary(['id_cours', 'numero_cours']);
            $table->string('designation');
            $table->string('image')->nullable();
            $table->integer('nombre_chapitres');
            $table->float('prix');
            $table->boolean('etat');
            $table->bigInteger('formateur_id')->unsigned()->index();
            $table->foreign('formateur_id')->references('id')->on('formateurs')->onDelete('cascade');
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
        Schema::dropIfExists('formation__contenir__courss');
    }
}

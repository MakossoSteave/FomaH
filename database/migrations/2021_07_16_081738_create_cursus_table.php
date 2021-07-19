<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursus', function (Blueprint $table) {
            $table->engine='MyiSAM';
            $table->id();;
            $table->string('designation');
            $table->string('description');
            $table->string('image')->nullable();
            $table->integer('volume_horaire');
            $table->integer('nombre_cours_total');
            $table->integer('nombre_chapitre_total');
            $table->float('prix');
            $table->boolean('etat');
            $table->bigInteger('categorie_id')->unsigned()->index();
            $table->foreign('categorie_id')->references('id')->on('categorie')->onDelete('cascade');
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
        Schema::dropIfExists('cursus');
    }
}

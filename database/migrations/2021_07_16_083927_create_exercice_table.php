<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExerciceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercice', function (Blueprint $table) {
            $table->id();
            $table->string('enonce');
            $table->string('image')->nullable();
            $table->boolean('etat');
            $table->bigInteger('id_chapitre')->unsigned()->index();
            $table->foreign('id_chapitre')->references('id_chapitre')->on('chapitre')->onDelete('cascade');
            $table->bigInteger('numero_chapitre')->unsigned()->index();
            $table->foreign('numero_chapitre')->references('numero_chapitre')->on('chapitre')->onDelete('cascade');
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
        Schema::dropIfExists('exercice');
    }
}

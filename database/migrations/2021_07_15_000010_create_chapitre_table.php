<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapitreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapitres', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->bigInteger('id_chapitre')->unsigned();
            $table->integer('numero_chapitre')->unsigned();
            $table->primary(['id_chapitre', 'numero_chapitre']);
            $table->string('designation');
            $table->string('image')->nullable();
            $table->string('video');
            $table->boolean('etat');
            $table->bigInteger('id_cours')->unsigned();
            $table->foreign('id_cours')->references('id_cours')->on('cours')->onDelete('cascade');
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
        Schema::dropIfExists('chapitres');
    }
}

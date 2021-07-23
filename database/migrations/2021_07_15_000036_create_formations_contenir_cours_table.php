<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormationsContenirCoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formations_contenir_cours', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->bigInteger('id_formation')->unsigned();
            $table->bigInteger('id_cours')->unsigned();
            $table->primary(['id_formation', 'id_cours']);
            $table->foreign('id_cours')->references('id_cours')->on('cours');    
            $table->foreign('id_formation')->references('id')->on('formations');
            $table->integer('numero_cours');
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
        Schema::dropIfExists('formations_contenir_cours');
    }
}

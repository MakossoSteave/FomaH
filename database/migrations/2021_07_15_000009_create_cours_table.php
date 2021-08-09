<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cours', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->id('id_cours')->unsigned();
            $table->string('designation');
            $table->string('image')->nullable();
            $table->integer('nombre_chapitres');
            $table->float('prix');
            $table->boolean('etat');
            $table->bigInteger('formateur')->unsigned()->index()->nullable();
            $table->foreign('formateur')->references('id')->on('formateurs');
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
        Schema::dropIfExists('cours');
    }
}

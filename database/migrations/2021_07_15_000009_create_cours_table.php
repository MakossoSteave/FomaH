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
            $table->bigInteger('id_cours')->unsigned();
            $table->integer('numero_cours')->unsigned();
            $table->primary(['id_cours', 'numero_cours']);
            $table->string('designation');
            $table->string('image')->nullable();
            $table->integer('nombre_chapitres');
            $table->float('prix');
            $table->boolean('etat');
            $table->bigInteger('formation_id')->unsigned()->index();
            $table->foreign('formation_id')->references('id')->on('formations')->onDelete('cascade');
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

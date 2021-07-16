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
            $table->bigInteger('id_cours')->unsigned();
            $table->integer('numero_cours')->unsigned();
            $table->primary(['id_cours', 'numero_cours']);
            $table->string('designation');
            $table->string('image')->nullable();
            $table->integer('nombre_chapitres');
            $table->float('prix');
            $table->boolean('etat');
            $table->bigInteger('cursus_id')->unsigned()->index();
            $table->foreign('cursus_id')->references('id')->on('cursus')->onDelete('cascade');
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
        Schema::dropIfExists('cous');
    }
}

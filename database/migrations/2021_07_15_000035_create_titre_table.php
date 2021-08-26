<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTitreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('titres', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->id();;
            $table->string('intitule');
            $table->date('date_obtention');
            $table->bigInteger('session_id')->unsigned()->index()->nullable();
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->bigInteger('stagiaire_id')->unsigned()->index();
            $table->foreign('stagiaire_id')->references('id')->on('stagiaires')->onDelete('cascade');
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
        Schema::dropIfExists('titres');
    }
}

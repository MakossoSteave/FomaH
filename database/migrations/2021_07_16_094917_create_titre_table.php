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
        Schema::create('titre', function (Blueprint $table) {
            $table->engine='MyiSAM';
            $table->id();;
            $table->string('intitule');
            $table->date('date_obtention');
            $table->bigInteger('stagiaire_id')->unsigned()->index();
            $table->foreign('stagiaire_id')->references('id')->on('stagiaire')->onDelete('cascade');
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
        Schema::dropIfExists('titre');
    }
}

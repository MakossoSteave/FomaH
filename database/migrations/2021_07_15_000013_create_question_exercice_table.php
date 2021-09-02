<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionExerciceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions_exercices', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->id();
            $table->string('question', 5000);
            $table->boolean('etat');
            $table->bigInteger('exercice_id')->unsigned()->index();
            $table->foreign('exercice_id')->references('id')->on('exercices')->onDelete('cascade');
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
        Schema::dropIfExists('questions_exercices');
    }
}

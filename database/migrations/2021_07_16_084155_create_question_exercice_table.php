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
            $table->engine='MyISAM';
            $table->id();;
            $table->string('question');
            $table->boolean('etat');
            $table->bigInteger('exercice_id')->unsigned()->index();
            $table->foreign('exercice_id')->references('id')->on('exercice')->onDelete('cascade');
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
        Schema::dropIfExists('question_exercice');
    }
}

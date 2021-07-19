<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionCorrectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions_corrections', function (Blueprint $table) {
            $table->engine='MyISAM';
            $table->id();;
            $table->string('reponse');
            $table->string('image')->nullable();
            $table->boolean('etat');
            $table->bigInteger('question_exercice_id')->unsigned()->index();
            $table->foreign('question_exercice_id')->references('id')->on('question_exercice')->onDelete('cascade');
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
        Schema::dropIfExists('question_correction');
    }
}

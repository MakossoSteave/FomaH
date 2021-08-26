<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReponseQuestionQcmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reponse_question_qcm', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->id();;
            $table->string('reponse', 1000);
            $table->boolean('validation');
            $table->boolean('etat');
            $table->bigInteger('question_qcm_id')->unsigned()->index();
            $table->foreign('question_qcm_id')->references('id')->on('question_qcm')->onDelete('cascade');
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
        Schema::dropIfExists('reponse_question_qcm');
    }
}

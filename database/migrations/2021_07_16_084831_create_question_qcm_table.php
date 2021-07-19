<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionQcmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_qcm', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->string('explication')->nullable();
            $table->boolean('etat');
            $table->bigInteger('qcm_id')->unsigned()->index();
            $table->foreign('qcm_id')->references('id')->on('qcm')->onDelete('cascade');
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
        Schema::dropIfExists('question_qcm');
    }
}

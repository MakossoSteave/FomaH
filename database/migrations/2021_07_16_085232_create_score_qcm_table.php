<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreQcmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_qcm', function (Blueprint $table) {
            $table->id();
            $table->integer('resultat');
            $table->bigInteger('stagiaire_id')->unsigned()->index();
            $table->foreign('stagiaire_id')->references('id')->on('stagiaire')->onDelete('cascade');
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
        Schema::dropIfExists('score_qcm');
    }
}

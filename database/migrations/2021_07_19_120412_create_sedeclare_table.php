<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSedeclareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sedeclares', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->bigInteger('id_formateur')->unsigned();
            $table->bigInteger('id_competence')->unsigned();
            $table->foreign('id_formateur')->references('id')->on('formateurs');
            $table->foreign('id_competence')->references('id')->on('competences');
            $table->primary(['id_formateur','id_competence']);
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
        Schema::dropIfExists('sedeclares');
    }
}

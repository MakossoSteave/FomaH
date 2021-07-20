<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQcmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qcm', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->id();;
            $table->string('designation');
            $table->boolean('etat');
            $table->bigInteger('id_chapitre')->unsigned()->index();
            $table->foreign('id_chapitre')->references('id_chapitre')->on('chapitres')->onDelete('cascade');
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
        Schema::dropIfExists('qcm');
    }
}

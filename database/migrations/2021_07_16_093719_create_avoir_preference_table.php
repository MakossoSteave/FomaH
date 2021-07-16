<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvoirPreferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avoir_preference', function (Blueprint $table) {
            $table->bigInteger('id_stagiaire')->unsigned();
            $table->bigInteger('id_mot_cle')->unsigned();
            $table->primary(['id_stagiaire', 'id_mot_cle']);
            $table->foreign('id_mot_cle')->references('id')->on('mot_cle');    
            $table->foreign('id_stagiaire')->references('id')->on('stagiaire');
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
        Schema::dropIfExists('avoir_preference');
    }
}

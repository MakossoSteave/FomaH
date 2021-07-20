<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->id();;
            $table->date('date_debut');
            $table->date('date_fin');
            $table->boolean('etat');
            $table->bigInteger('formateur_id')->unsigned()->index();
            $table->foreign('formateur_id')->references('id')->on('formateurs')->onDelete('cascade');
            $table->bigInteger('formations_id')->unsigned()->index();
            $table->foreign('formations_id')->references('id')->on('formations')->onDelete('cascade');
            $table->bigInteger('statut_id')->unsigned()->index();
            $table->foreign('statut_id')->references('id')->on('statut')->onDelete('cascade');
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
        Schema::dropIfExists('sessions');
    }
}

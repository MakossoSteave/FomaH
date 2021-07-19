<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingEnLigneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_en_lignes', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->id();;
            $table->timestamp('date_meeting');
            $table->bigInteger('statut_id')->unsigned()->index();
            $table->foreign('statut_id')->references('id')->on('statut')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('id_cours')->unsigned()->index()->nullable();
            $table->foreign('id_cours')->references('id_cours')->on('cours')->onDelete('cascade');
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
        Schema::dropIfExists('meeting_en_lignes');
    }
}

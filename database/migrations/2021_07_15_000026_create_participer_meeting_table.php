<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticiperMeetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participer_meetings', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->bigInteger('id_utilisateur')->unsigned();
            $table->bigInteger('id_meeting')->unsigned();
            $table->primary(['id_utilisateur', 'id_meeting']);
            $table->foreign('id_meeting')->references('id')->on('meeting_en_lignes')->onDelete('cascade');
            $table->foreign('id_utilisateur')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('validation')->nullable();
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
        Schema::dropIfExists('participer_meetings');
    }
}

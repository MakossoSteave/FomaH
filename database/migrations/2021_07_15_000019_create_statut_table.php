<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStatutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statut', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->id();
            $table->string('statut');
            $table->timestamps();
        });

        DB::table('statut')->insert(
               
            [
                'statut'=>'Non débuté'
            ]

        );
        DB::table('statut')->insert(
               
            [
                'statut'=>'Non débutée'
            ]

        );
        DB::table('statut')->insert(
               
            [
                'statut'=>'En cours'
            ]

        );
        DB::table('statut')->insert(
               
            [
                'statut'=>'Terminé'
            ]

        );
        DB::table('statut')->insert(
               
            [
                'statut'=>'Terminée'
            ]

        );
        DB::table('statut')->insert(
               
            [
                'statut'=>'Annulé'
            ]

        );
        DB::table('statut')->insert(
               
            [
                'statut'=>'Annulée'
            ]

        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statut');
    }
}

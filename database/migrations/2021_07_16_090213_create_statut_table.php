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
        Schema::create('statuts', function (Blueprint $table) {
            $table->engine='MyISAM';
            $table->id();
            $table->string('statut');
            $table->timestamps();
        });

        DB::table('statuts')->insert(
               
            [
                'statut'=>'Non débuté'
            ]

        );
        DB::table('statuts')->insert(
               
            [
                'statut'=>'Non débutée'
            ]

        );
        DB::table('statuts')->insert(
               
            [
                'statut'=>'En cours'
            ]

        );
        DB::table('statuts')->insert(
               
            [
                'statut'=>'Terminé'
            ]

        );
        DB::table('statuts')->insert(
               
            [
                'statut'=>'Terminée'
            ]

        );
        DB::table('statuts')->insert(
               
            [
                'statut'=>'Annulé'
            ]

        );
        DB::table('statuts')->insert(
               
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateTypeInscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types_inscriptions', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->id();
            $table->string('type');
            $table->timestamps();
        });

        DB::table('types_inscriptions')->insert(
               
            [
                'type'=>'Indépendant'
            ]
    
        );
        DB::table('types_inscriptions')->insert(
               
            [
                'type'=>'Organisation'
            ]
    
        );

        DB::table('types_inscriptions')->insert(
               
            [
                'type'=>'Centre'
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
        Schema::dropIfExists('types_inscriptions');
    }
}

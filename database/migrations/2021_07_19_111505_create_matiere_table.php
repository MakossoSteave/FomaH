<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMatiereTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matieres', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->id();
            $table->string('designation_matiere');
            $table->bigInteger('categorie_id')->unsigned()->index();
            $table->foreign('categorie_id')->references('id')->on('categories');
            $table->timestamps();
        });
        /*
        DB::table('matieres')->insert( ['type'=>'Admin'], );
        */
        DB::table('matieres')->insert(['designation_matiere'=>'Informatique'],);
        DB::table('matieres')->insert(['designation_matiere'=>'Chimie'],);
        DB::table('matieres')->insert(['designation_matiere'=>'Mathematiques'],);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matieres');
    }
}

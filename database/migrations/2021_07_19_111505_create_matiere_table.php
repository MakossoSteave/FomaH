<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMatiereTable extends Migration
{
    /**
     * Run the migrations.matiere
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
            $table->foreign('categorie_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();

        });
        /*
        DB::table('matieres')->insert( ['type'=>'Admin'], );
        */
        DB::table('matieres')->insert( ['designation_matiere'=>'Conception','categorie_id'=> 1], );
        DB::table('matieres')->insert( ['designation_matiere'=>'Programmation','categorie_id'=> 1], );
        DB::table('matieres')->insert( ['designation_matiere'=>'Reseau','categorie_id'=> 1], );
        DB::table('matieres')->insert( ['designation_matiere'=>'Architecture_des_machines','categorie_id'=> 1], );
        DB::table('matieres')->insert( ['designation_matiere'=>'Bases_de_donnees','categorie_id'=> 1], );

        DB::table('matieres')->insert( ['designation_matiere'=>'Anglais','categorie_id'=> 2], );
        DB::table('matieres')->insert( ['designation_matiere'=>'Espagnol','categorie_id'=> 2], );
        
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

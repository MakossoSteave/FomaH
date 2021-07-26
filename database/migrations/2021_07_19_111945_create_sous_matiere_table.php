<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSousMatiereTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sous_matieres', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->id();
            $table->string('designation_sous_matiere');
            $table->bigInteger('designation_matiere_id')->unsigned()->index();
            $table->foreign('designation_matiere_id')->references('id')->on('matieres');
            $table->timestamps();
        });
        /*
        DB::table('matieres')->insert( ['type'=>'Admin'], );
        */
        DB::table('sous_matieres')->insert( ['designation_sous_matiere'=>'Conception'], );
        DB::table('sous_matieres')->insert( ['designation_sous_matiere'=>'Programmation'], );
        DB::table('sous_matieres')->insert( ['designation_sous_matiere'=>'Reseau'], );
        DB::table('sous_matieres')->insert( ['designation_sous_matiere'=>'Architecture_des_machines'], );
        DB::table('sous_matieres')->insert( ['designation_sous_matiere'=>'Bases_de_donnees'], );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sous_matieres');
    }
}

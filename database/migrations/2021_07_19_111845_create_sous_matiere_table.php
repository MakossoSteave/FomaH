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
            $table->bigInteger('matiere_id')->unsigned()->index();
            $table->foreign('matiere_id')->references('id')->on('matieres');
            $table->timestamps();
        });
        DB::table('sous_matieres')->insert( ['designation_sous_matiere'=>'Methodes pour l informatisation','matiere_id'=> 1], );
        DB::table('sous_matieres')->insert( ['designation_sous_matiere'=>'Methodes pour l informatisation - complements','matiere_id'=> 1], );
        DB::table('sous_matieres')->insert( ['designation_sous_matiere'=>'Programmation Notion de bases','matiere_id'=> 2], );
        DB::table('sous_matieres')->insert( ['designation_sous_matiere'=>'Programmation Objet','matiere_id'=> 2], );
        DB::table('sous_matieres')->insert( ['designation_sous_matiere'=>'Programmation Fonctionnelle','matiere_id'=> 2], );
        DB::table('sous_matieres')->insert( ['designation_sous_matiere'=>'Web developpement cote client (Front-End) HTML, CSS et JavaScript','matiere_id'=> 2], );
        DB::table('sous_matieres')->insert( ['designation_sous_matiere'=>'Web developpement cote serveur (Back-End) PHP, Java et SQL','matiere_id'=> 2], );
        DB::table('sous_matieres')->insert( ['designation_sous_matiere'=>'Principes des réseaux informatiques','matiere_id'=> 3], );
        DB::table('sous_matieres')->insert( ['designation_sous_matiere'=>'Technologies pour les applications en reseau','matiere_id'=> 3], );
        
        DB::table('sous_matieres')->insert( ['designation_sous_matiere'=>'Anglais littéraire','matiere_id'=> 6], );
        DB::table('sous_matieres')->insert( ['designation_sous_matiere'=>'Anglais professionnel','matiere_id'=> 6], );
        DB::table('sous_matieres')->insert( ['designation_sous_matiere'=>'Espagnol littéraire','matiere_id'=> 7], );
        DB::table('sous_matieres')->insert( ['designation_sous_matiere'=>'Espagnol professionnel','matiere_id'=> 7], );
        
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competences', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->id();

            $table->bigInteger('id_formateur')->unsigned()->index()->nullable();
            $table->foreign('id_formateur')->references('id')->on('users');


            $table->bigInteger('id_categorie')->unsigned()->index()->nullable();
            $table->foreign('id_categorie')->references('id')->on('categories');

            $table->bigInteger('id_matiere')->unsigned()->index()->nullable();
            $table->foreign('id_matiere')->references('id')->on('matieres');
            
            $table->bigInteger('id_sous_matiere')->unsigned()->index()->nullable();
            $table->foreign('id_sous_matiere')->references('id')->on('sous_matieres');

            $table->bigInteger('id_niveau_scolaire')->unsigned()->index()->nullable();
            $table->foreign('id_niveau_scolaire')->references('id')->on('niveau_scolaires');
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('competences');
    }
}

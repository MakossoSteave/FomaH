<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateNiveauScolaireTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('niveau_scolaires', function (Blueprint $table) {
            $table->engine='MyiSAM';
            $table->id();
            $table->string('designation_niveau_scolaire');
            $table->timestamps();
        });
        /*
        DB::table('matieres')->insert( ['type'=>'Admin'], );
        */
        DB::table('niveau_scolaires')->insert(['designation_niveau_scolaire'=>'Sans niveau'],);
        DB::table('niveau_scolaires')->insert(['designation_niveau_scolaire'=>'Licence l1'],);
        DB::table('niveau_scolaires')->insert(['designation_niveau_scolaire'=>'Licence l2'],);
        DB::table('niveau_scolaires')->insert(['designation_niveau_scolaire'=>'Licence l3'],);
        DB::table('niveau_scolaires')->insert(['designation_niveau_scolaire'=>'Mastere m1'],);
        DB::table('niveau_scolaires')->insert(['designation_niveau_scolaire'=>'Mastere m2'],);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('niveau_scolaires');
    }
}

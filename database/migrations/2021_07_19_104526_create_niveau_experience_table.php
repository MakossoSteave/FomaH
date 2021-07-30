<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateNiveauExperienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('niveau_competence', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        DB::table('niveau_competence')->insert(['name'=>'Débutant'],);
        DB::table('niveau_competence')->insert(['name'=>'Expérimenté'],);
        DB::table('niveau_competence')->insert(['name'=>'Trés expérimenté'],);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('niveau_competence');
    }
}

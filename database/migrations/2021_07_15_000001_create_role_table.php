<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            
            $table->engine='InnoDB';
            $table->id();
            $table->string('type');
            $table->timestamps();
        });
        DB::table('roles')->insert(
               
            [
                'type'=>'Admin'
            ],

        );
        DB::table('roles')->insert(
               
            [
                'type'=>'Entreprise'
            ],

        );
        DB::table('roles')->insert(
               
            [
                'type'=>'Stagiaire'
            ],

        );
        DB::table('roles')->insert(
               
            [
                'type'=>'Formateur'
            ],

        );
        DB::table('roles')->insert(
               
            [
                'type'=>'Organisme'
            ],

        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
     //   Schema::enableForeignKeyConstraints();

        Schema::dropIfExists('roles');
    }
}
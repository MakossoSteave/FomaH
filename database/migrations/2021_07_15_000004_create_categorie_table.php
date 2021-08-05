<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCategorieTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->id();;
            $table->string('designation');
            $table->timestamps();
        });
        DB::table('categories')->insert(['designation'=>'Informatique'],);
        DB::table('categories')->insert(['designation'=>'Langues'],);
        DB::table('categories')->insert(['designation'=>'Chimie'],);
        DB::table('categories')->insert(['designation'=>'Mathematiques'],);
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }

        
}

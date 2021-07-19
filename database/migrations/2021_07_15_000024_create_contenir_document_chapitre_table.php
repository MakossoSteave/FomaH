<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContenirDocumentChapitreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contenir_documents_chapitres', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->bigInteger('id_proj')->unsigned();
            $table->bigInteger('id_doc')->unsigned();
            $table->bigInteger('id_chapitre')->unsigned();
            $table->primary(['id_proj', 'id_doc', 'id_chapitre']);
            $table->foreign('id_doc')->references('id')->on('documents');    
            $table->foreign('id_proj')->references('id')->on('projets');
            $table->foreign('id_chapitre')->references('id_chapitre')->on('chapitres');
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
        Schema::dropIfExists('contenir_documents_chapitres');
    }
}

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
            $table->engine='MyISAM';
            $table->bigInteger('id_proj')->unsigned();
            $table->bigInteger('id_doc')->unsigned();
            $table->integer('num_chap')->unsigned();
            $table->primary(['id_proj', 'id_doc', 'num_chap']);
            $table->foreign('id_doc')->references('id')->on('document');    
            $table->foreign('id_proj')->references('id')->on('projet');
            $table->foreign('num_chap')->references('numero_chapitre')->on('chapitre');
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
        Schema::dropIfExists('contenir_document_chapitre');
    }
}

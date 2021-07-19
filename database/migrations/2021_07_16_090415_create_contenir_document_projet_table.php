<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContenirDocumentProjetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contenir_document_projet', function (Blueprint $table) {
            $table->engine='MyiSAM';
            $table->bigInteger('id_projet')->unsigned();
            $table->bigInteger('id_document')->unsigned();
            $table->primary(['id_projet', 'id_document']);
            $table->foreign('id_document')->references('id')->on('document');    
            $table->foreign('id_projet')->references('id')->on('projet');
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
        Schema::dropIfExists('contenir_document_projet');
    }
}

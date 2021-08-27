<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->id('id');
            $table->string('image')->nullable();
            $table->string('name');
            $table->integer('status_id')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
<<<<<<< HEAD:database/migrations/2014_10_12_000000_create_users_table.php
           $table->unsignedBigInteger('role_id');
           $table->string("preference")->nullable();
=======
            $table->bigInteger('role_id')->unsigned()->index();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->string("preference")->nullable();
>>>>>>> a8ab41008ee5df44f098d8fbf743d9f3a2187f1e:database/migrations/2021_07_15_000002_create_users_table.php
            $table->rememberToken();
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
       // Schema::enableForeignKeyConstraints();
        Schema::dropIfExists('users');
    }
}
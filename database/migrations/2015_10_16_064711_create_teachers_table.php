<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->string('id',9)->primary();
            $table->foreign('id')->references('id')->on('users');
            $table->string('mobilephone',11);
            $table->string('homephone',11);
            $table->string('group',20);
            $table->integer('position')->unsigned();
            $table->string('specialized',20);
            $table->date('incomingday');
            $table->string('active','1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('teachers');
    }
}

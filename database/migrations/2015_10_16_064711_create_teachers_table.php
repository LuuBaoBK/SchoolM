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
            $table->string('mobilephone',15);
            $table->string('homephone',15);
            $table->string('group',20);
            $table->string('position',20);
            $table->string('specialized',20);
            $table->date('incomingday');
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

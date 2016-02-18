<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->string('id',11);
            $table->primary('id');
            $table->string('scholastic',2);
            $table->string('classname',6);
            $table->string('homeroom_teacher',9);
            $table->foreign('homeroom_teacher')->references('id')->on('teachers');
            $table->string('doable',1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('classes');
    }
}

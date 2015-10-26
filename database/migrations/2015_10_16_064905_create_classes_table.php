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
            $table->string('cid',8);
            $table->primary('cid');
            $table->string('mahk',6);
            $table->string('classname',4);
            $table->string('danhhieu',8);
            $table->string('gvcn',8);
            $table->foreign('gvcn')->references('teid')->on('teachers');
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

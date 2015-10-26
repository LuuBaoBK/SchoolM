<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranscriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transcript', function (Blueprint $table) {
            $table->string('stid',8);
            $table->string('mahk',6);
            $table->integer('sid');
            $table->string('type',6);
            $table->integer('diem');
            $table->primary(['stid','mahk','sid','type']);
            $table->foreign('stid')->references('stid')->on('students');
            $table->foreign('sid')->references('sid')->on('subjects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transcript');
    }
}

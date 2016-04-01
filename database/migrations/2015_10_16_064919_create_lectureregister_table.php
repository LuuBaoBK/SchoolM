<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLectureregisterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lectureregister', function (Blueprint $table) {
            $table->increments('id');
            $table->string('teacher_id',9);
            $table->string('title',100);
            $table->string('level',1);
            $table->datetime('wrote_date');
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->text('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lectureregister');
    }
}

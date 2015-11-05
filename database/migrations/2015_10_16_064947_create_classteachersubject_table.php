e<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassteachersubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classteachersubject', function (Blueprint $table) {
            $table->string('class_id',8);
            $table->string('teacher_id',10);
            $table->integer('subject_id');
            $table->primary(array('class_id','teacher_id','subject_id'));
            $table->foreign('class_id')->references('id')->on('teachers');
            $table->foreign('teacher_id')->references('id')->on('classes');
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('classteachersubject');
    }
}

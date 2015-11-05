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
            $table->string('student_id',10);
            $table->string('semester',6);
            $table->integer('subject_id');
            $table->string('type',6);
            $table->integer('score');
            $table->date('datetime');
            $table->primary(['student_id','semester','subject_id','type','datetime']);
            $table->foreign('student_id')->references('id')->on('students');
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
        Schema::drop('transcript');
    }
}

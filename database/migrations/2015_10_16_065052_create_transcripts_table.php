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
            $table->string('student_id',9);
            $table->string('scholastic',2);
            $table->integer('subject_id')->unsigned();
            $table->integer('scoretype_id')->unsigned();
            $table->float('score');
            $table->string('note',100);
            $table->primary(['student_id','scholastic','subject_id','scoretype_id']);
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('subject_id')->references('id')->on('subjects');
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

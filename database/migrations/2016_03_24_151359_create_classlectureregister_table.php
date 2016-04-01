<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClasslectureregisterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classlectureregister', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->string('class_id',11);
            $table->foreign('class_id')->references('id')->on('classes');
            $table->foreign('id')->references('id')->on('lectureregister');
            $table->primary(['id','class_id']);
            $table->string('classname',6);
            $table->datetime('notice_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('classlectureregister');
    }
}

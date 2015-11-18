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
            $table->string('class_id',11);
            $table->string('writeby',9);
            $table->datetime('date_time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->primary(array('class_id','writeby','date_time'));
            $table->foreign('class_id')->references('id')->on('classes');
            $table->foreign('writeby')->references('id')->on('teachers');
            $table->string('content',300);
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

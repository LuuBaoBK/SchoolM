<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->string('cid',8);
            $table->integer('sid');
            $table->string('thu',5);
            $table->integer('tiet');
            $table->primary(['cid','sid','thu','tiet']);
            $table->foreign('cid')->references('cid')->on('classes');
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
        Schema::drop('schedules');
    }
}

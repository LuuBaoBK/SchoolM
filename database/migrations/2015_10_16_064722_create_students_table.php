<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->string('stid',8);
            $table->primary('stid');
            $table->foreign('stid')->references('uid')->on('myusers');
            $table->integer('namnhaphoc');
            $table->integer('namtotnghiep');
            $table->string('paid',8);
            $table->foreign('paid')->references('paid')->on('parents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('students');
    }
}

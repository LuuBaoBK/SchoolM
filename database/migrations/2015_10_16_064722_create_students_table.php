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
            $table->string('id',9)->primary();
            $table->foreign('id')->references('id')->on('users');
            $table->integer('enrolled_year');
            $table->integer('graduated_year');
            $table->string('parent_id',9);
            $table->foreign('parent_id')->references('id')->on('parents');
            $table->text('note');
            $table->text('comment');
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

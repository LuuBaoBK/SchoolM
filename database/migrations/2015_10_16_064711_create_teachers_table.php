<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->string('id',10)->primary();
            $table->foreign('id')->references('id')->on('users');
            $table->string('mobilephone',11)->unique();
            $table->string('homephone',11);
            $table->string('group',10);
            $table->string('position',20);
            $table->string('specialize',20);
            $table->date('incomingday');
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
        Schema::drop('teachers');
    }
}
